<?php
    
    session_start();
    require_once('./config/config.php');

    $user = new User();

    /*
     * If the user is already login
     * return to index page
     */    

    if ($user->is_loggedin() != "")
    {
        $active = "Active";
        $verified = "Verified";

        $email = $_SESSION['email'];

        try
        {

            $stmt = $user->runQuery("SELECT user_status
                                            FROM useraccount_tbl
                                                WHERE user_email=:email");
            
            $stmt->execute(array(':email'=>$email));
            $row=$stmt->fetch(PDO::FETCH_ASSOC);

            if ($row['user_status'] == $verified) {
                
                $user->redirect('account_setup.php');

            } else if ($row['user_status'] == $active) {
                
                $user->redirect('index.php');

            }

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /*
     * If the user created an account
     * 
     */
    
    if(isset($_POST['registerBtn']))
    {

        $username = $user->checkInput($_POST['registerUser']);
        $email = $user->checkInput($_POST['registerEmail']);
        $mobile_number = $user->checkInput($_POST['registerNumber']);
        $password = $user->checkInput($_POST['registerPassword']);
        $cpassword = $user->checkInput($_POST['registercPassword']);


        if (!preg_match("/^[a-zA-Z0-9]{5,}$/" , $username)){

            $error[] = "Username must not contain spaces or special characters.";

        } else if ($password != $cpassword) {

            $error[] = "Password did not match.";

        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                
            $error[] = "Invalid email address.";

        } else {

            try {

                $stmt = $user->runQuery("SELECT user_name, user_email FROM useraccount_tbl WHERE user_name=:username OR user_email=:email");
                $stmt->execute(array(':username'=>$username, ':email'=>$email));
                $row=$stmt->fetch(PDO::FETCH_ASSOC);

                if($row['user_name']==$username) {

                    $error[] = "Username is already taken!";

                } else if ($row['user_email']==$email) {

                    $error[] = "Email is already taken!";

                } else {

                    $mobile_number = "+63" . $mobile_number;
                    $token = $user->generateNewString();

                    if($user->register($username, $email, $password, $mobile_number, $token)){

                        $_SESSION['username'] = $username;
                        $_SESSION['email'] = $email;

                        //$user->send_email($token, $_SESSION['email']);
                        $user->redirect("account_register.php?verify");

                        /*
                        require './config/textlocal.class.php';

                        $apikey = "PNjnmLATqHc-g1YpuCBZ685nWam6O5doA84k0lXTNc";
                        $textlocal = new Textlocal(false, false, $apikey);

                        $number = array($mobile_number);
                        $sender = 'BrgySalitranII';
                        $message = 'Hello! Here is your code: ' . $token;

                        try {

                            $result = $textlocal->sendSms($number, $message, $sender);
                            setcookie('token', $token);
                            

                        } catch (Exception $e) {
                            echo $e->getMessage();
                        }

                        */
                    }


                }

            } catch (PDOException $e) {
                
                echo $e->getMessage();

            }

        }

    }

    /*
     * Verify account
     * 
     */
    
    if (isset($_POST['registerVerifyCodeBtn']))
    {

        $email = $_SESSION['email'];
        $code = $user->checkInput($_POST['registerVerifyCode']);

        try {

            $stmt = $user->runQuery("SELECT user_email_token
                                        FROM useraccount_tbl
                                            WHERE user_email=:email
                                                AND user_email_token=:code
                                                    LIMIT 1");

            $stmt->execute(array(':email'=>$email, 'code'=>$code));
            $row=$stmt->fetch(PDO::FETCH_ASSOC);

            if ($row['user_email_token'] == $code) {

                $status = "Verified";
                $success[] = "You have successfully verified your account!";
                $user->redirect("account_setup.php");

                try {

                    $stmt = $user->runQuery("UPDATE useraccount_tbl
                                                SET user_status = :status
                                                    WHERE user_email=:email
                                                        AND user_email_token=:code");

                    $stmt->bindparam(":email", $email);
                    $stmt->bindparam(":status", $status);
                    $stmt->bindparam(":code", $code);

                    $stmt->execute(); 
                    return $stmt;


                } catch (PDOException $e) {

                    echo $e->getMessage();

                }       

            } else {

                $error[] = "It looks like you've entered an incorrect code. Please try again.";

            }

        } catch (PDOException $e) {
            
            echo $e->getMessage();

        }

    }

?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Sign up for Barangay Salitran II</title>
        <meta name="description" content="Create an account.">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!--
            CSS styles, fonts, libraries and frameworks goes here.
            Bootstrap, Jquery, etc..
        -->

        <?php include './libraries.php'; ?>

        <script type="text/javascript">
            function terms() {
                swal.fire({
                    type: 'info',
                    title: 'Terms and Privacy',
                    text: 'Content here.'
                });
            }
        </script>

    </head>
    <body>
        <?php
            
            if (!isset($_GET['verify']))
            {
                ?>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6">
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <form method="post" class="registerForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="form-text text-uppercase text-muted my-2">Sign Up</h3>
                                    <?php
                                        if(isset($error))
                                        {
                                            foreach($error as $error)
                                            {
                                                 ?>
                                                 <script type="text/javascript">
                                                    swal.fire({
                                                        type: 'error',
                                                        title: 'Oops!',
                                                        text: '<?php echo $error; ?>'
                                                    });
                                                 </script>
                                                 <?php
                                            }
                                        }
                                    ?>
                                    <div id="errorDisplay" class="mt-2"></div>
                                    <div class="form-label-group">
                                        <input type="text" id="registerUser" name="registerUser" class="form-control" placeholder="Username" minlength="5" required autofocus>
                                        <label for="registerUser">Username</label>
                                        <p id="errorUsernameDisplay"></p>
                                    </div>
                                    <div class="form-label-group">
                                        <input type="email" id="registerEmail" name="registerEmail" class="form-control" placeholder="Email" required>
                                        <label for="registerUser">Email</label>
                                        <p id="errorEmailDisplay"></p>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-label-group">
                                                <input type="text" id="sixthree" class="form-control" placeholder="+63" readonly="readonly">
                                                <label for="sixthree">+63</label>
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-label-group">
                                                <input type="text" id="registerNumber" name="registerNumber" class="form-control" placeholder="10-Digit Mobile Number" minlength="10" maxlength="10" required>
                                                <label for="registerNumber">10-Digit Mobile Number</label>
                                                <p id="errorNumberDisplay"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-label-group">
                                        <input type="password" id="registerPassword" name="registerPassword" class="form-control" placeholder="Password" minlength="8" required>
                                        <label for="registerPassword">Password</label>
                                        <p id="errorPasswordDisplay"></p>
                                    </div>
                                    <div class="form-label-group">
                                        <input type="password" id="registercPassword" name="registercPassword" class="form-control" placeholder="Confirm Password" minlength="8" required>
                                        <label for="registercPassword">Confirm Password</label>
                                        <p id="errorcPasswordDisplay"></p>
                                    </div>
                                    <div class="custom-control custom-checkbox mb-4" id="terms">
                                        <input type="checkbox" class="custom-control-input" id="checkboxTerms" name="checkboxTerms" required/>
                                        <label class="custom-control-label" for="checkboxTerms">By creating an account, you are agreeing to our <button type="button" class="btn btn-link" onclick="terms();"><u>Terms and Privacy</u></button> Policy.</label>
                                    </div>
                                    <input type="submit" name="registerBtn" class="btn btn-lg btn-primary btn-block text-uppercase" value="Create">
                                    <hr class="my-4">
                                    <a href="reset_password.php" role="button" class="btn-link">Recover your account.</a>
                                    Click <a href="login.php" role="button" class="btn-link">here</a> to log in.
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php
            }
            else if (isset($_GET['verify']) && isset($_SESSION['username']) || isset($_SESSION['email']))
            {
                ?>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6">
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <form method="post" class="registerForm">
                            <?php
                                if(isset($error))
                                {
                                    foreach($error as $error)
                                    {
                                         ?>
                                         <script type="text/javascript">
                                            swal("Oops!", "<?php echo $error; ?>", "error");
                                         </script>
                                         <?php
                                    }
                                }
                                if(isset($success))
                                {
                                    foreach($success as $success)
                                    {
                                         ?>
                                         <script type="text/javascript">
                                            swal("Great!", "<?php echo $success; ?>", "success");
                                         </script>
                                         <?php
                                    }
                                }
                            ?>
                            <div class="alert alert-success my-5 alert-dismissible fade show" role="alert">
                                <p><strong>Registered Successfully!</strong></p>
                                <p>To activate your account, enter the code we sent to your <strong>email</strong>.<br>If you didn't receive the code, you can <a href="#">request for a new one</a>.</p>
                            </div>
                            <div class="form-label-group">
                                <input type="text" id="registerVerifyCode" name="registerVerifyCode" class="form-control" placeholder="Code" maxlength="5" required autofocus>
                                <label for="registerVerifyCode">Code</label>
                                
                            </div>
                            
                            <input type="submit" name="registerVerifyCodeBtn" class="btn btn-lg btn-primary btn-block text-uppercase" value="Proceed">
                        </form>
                    </div>
                </div>
                <?php
            }
            else
            {
                $user->redirect("error404.php");
            }
        ?>
    </body>
</html>