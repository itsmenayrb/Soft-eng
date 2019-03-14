<?php

    require_once("./config/session.php");
    require_once("./config/config.php");

    $auth_user = new USER();

    $user_email = $_SESSION['email'];
    $user_name = $_SESSION['username'];
    

    $stmt = $auth_user->runQuery("SELECT user_name, user_email, user_status
                                    FROM useraccount_tbl
                                        WHERE user_email=:user_email
                                            OR user_name=:user_name");

    $stmt->execute(array(":user_email"=>$user_email, ":user_name"=>$user_name));
    $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
    

    if (isset($_POST['registerSetupBtn']))
    {

        $prefix = $auth_user->checkInput($_POST['prefix']);
        $firstname = $auth_user->checkInput($_POST['fname']);
        $middlename = $auth_user->checkInput($_POST['mname']);
        $lastname = $auth_user->checkInput($_POST['lname']);
        $suffix = $auth_user->checkInput($_POST['suffix']);
        $gender = $auth_user->checkInput($_POST['gender']);
        $birthday = $auth_user->checkInput($_POST['birthday']);
        $age = $auth_user->checkInput($_POST['age']);
        $birthplace = $auth_user->checkInput($_POST['birthplace']);
        $block = $auth_user->checkInput($_POST['block']);
        $street = $auth_user->checkInput($_POST['street']);
        $subdivision = $auth_user->checkInput($_POST['subdivision']);


        if (!preg_match("/^[a-zA-Z,. ]*$/" , $firstname)){

            $error[] = "Invalid name format.";

        } else if (!preg_match("/^[a-zA-Z,. ]*$/" , $middlename)) {

            $error[] = "Invalid name format.";

        } else if (!preg_match("/^[a-zA-Z,. ]*$/" , $lastname)) {

            $error[] = "Invalid name format.";
                
        } else {

            if($auth_user->save_user_info($prefix, $firstname, $middlename, $lastname, $suffix, $gender, $birthday, $age, $birthplace, $block, $street, $subdivision)){

                $success =  "Information saved. You will redirect to the index page.";

                ?>
                <script type="text/javascript">
                    swal.fire({
                        type: 'success',
                        title: 'Great!',
                        text: '<?php echo $success; ?>'
                    });
                </script>
                <?php
                $auth_user->slow_redirect("index.php");

            }

        }

    }
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Account Setup</title>
    <meta name="description" content="Create an account.">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--
        CSS styles, fonts, libraries and frameworks goes here.
        Bootstrap, Jquery, etc..
    -->
    <?php include './libraries.php'; ?>

</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <form method="post" class="registerSetupForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <?php
                        if(isset($error))
                        {
                            foreach($error as $error)
                            {
                                 ?>
                                 <script type="text/javascript">
                                    swal.fire({
                                        type: 'error',
                                        title: 'Great!',
                                        text: '<?php echo $error; ?>'
                                    });
                                 </script>
                                 <?php
                            }
                        }
                    ?>
                    <h1 class="lead"><strong>Full Name</strong></h1>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-label-group">
                                <select name="prefix" id="reg-prefix" class="form-control" required>
                                    <option value="" selected class="form-control"></option>
                                    <option value="Mr" class="form-control">Mr.</option>
                                    <option value="Ms" class="form-control">Ms.</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-label-group">
                                <input type="text" class="form-control" name="fname" id="reg-fname" placeholder="First Name" required/>
                                <label for="reg-fname">First Name</label>
                                <span id="errorFirstNameDisplay"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-label-group">
                                <input type="text" class="form-control" name="mname" id="reg-mname" placeholder="Middle" />
                                <label for="reg-mname">Middle Name</label>
                                <span id="errorMiddleNameDisplay"></span>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-label-group">
                                <input type="text" class="form-control" name="lname" id="reg-lname" placeholder="Last" required/>
                                <label for="reg-lname">Last Name</label>
                                <span id="errorLastNameDisplay"></span>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <select name="suffix" id="reg-suffix" class="form-control">
                                <option value="" selected class="form-control"></option>
                                <option value="Jr" class="form-control">Jr.</option>
                                <option value="Sr" class="form-control">Sr.</option>
                                <option value="III" class="form-control">III</option>
                                <option value="IV" class="form-control">IV</option>
                                <option value="V" class="form-control">V</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-4">
                            <h1 class="lead"><strong>Gender</strong></h1>
                            <div class="form-check form-check-inline">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" name="gender" value="Male" id="Male"/>
                                    <label class="custom-control-label" for="Male">Male</label>
                                </div>
                                &nbsp;&nbsp;&nbsp;
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" name="gender" value="Female" id="Female"/>
                                    <label class="custom-control-label" for="Female">Female</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h1 class="lead"><strong>Birthdate</strong></h1>
                            <div class="form-label-group">
                                <input type="text" class="form-control" id="reg-birthday" name="birthday" placeholder="Date of Birth" required/>
                                <label for="reg-birthday">Date of Birth</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h1 class="lead"><strong>Age</strong></h1>
                            <div class="form-label-group">
                                <input type="text" id="reg-age" name="age" class="form-control" placeholder="Age" readonly/>
                                <label for="reg-age">Age</label>
                            </div>
                        </div>
                    </div>
                    <h1 class="lead"><strong>Birthplace</strong></h1>
                    <div class="form-label-group">
                        <input type="text" class="form-control" name="birthplace" id="reg-birthplace" placeholder="Place of Birth" /> 
                        <label for="reg-birthplace">Place of Birth</label>
                    </div>
                    <br>
                    <h1 class="lead"><strong>Address</strong></h1>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-label-group">
                                <input type="text" class="form-control" value" id="reg-block" name="block" aria-describedby="blockHelpBlock" placeholder="Block/Lot/House number:" required/>
                                <label for="reg-block">Block/Lot/House number:</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-label-group">
                            <input type="text" class="form-control" id="reg-street" name="street" aria-describedby="streetHelpBlock" placeholder="Street" required/>
                            <label for="reg-street">Street</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-label-group">
                            <input type="text" class="form-control" id="reg-subdivision" name="subdivision" aria-describedby="subdivisionHelpBlock" placeholder="Subdivision" required/>
                            <label for="reg-subdivision">Subdivision</label>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="form-label-group">
                        <input type="text" value="Barangay Salitran II, Dasmariñas City, Cavite, Philippines, 4114" class="form-control" readonly>
                    </div>
                    <br>
                    <input type="submit" name="registerSetupBtn" class="btn btn-lg btn-primary btn-block text-uppercase" value="Save">
                </form>
            </div>
        </div>                 
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            var age = "";
            $('#reg-birthday').datepicker({
                autoSize: true,
                yearRange: "-100:",
                maxDate: "-12Y",
                onSelect: function(value, ui) {
                    var today = new Date();
                    age = today.getFullYear() - ui.selectedYear;
                    $('#reg-age').val(age);
                },
                changeMonth: true,
                changeYear: true
            });
        });
    </script> 
    </body>
</html>