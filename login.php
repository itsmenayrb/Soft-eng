<?php
	session_start();
    require_once('./config/config.php');

    $login = new User();

    try {
        
        $active = "Active";
        $verified = "Verified";
        $pending = "Pending";

        $stmt = $login->runQuery("SELECT user_status
                                        FROM useraccount_tbl
                                            WHERE user_status=:active
                                                OR user_status=:verified
                                                	OR user_status=:pending");

        $stmt->execute(array(':active'=>$active, ':verified'=>$verified, ':pending'=>$pending));
        $row=$stmt->fetch(PDO::FETCH_ASSOC);

        if ($login->is_loggedin() != "" && $row['user_status'] == $verified) {
            
            $login->redirect('account_setup.php');

        } else if ($login->is_loggedin() != "" && $row['user_status'] == $active) {
            
            $login->redirect('index.php');

        } else if ($login->is_loggedin() != "" && $row['user_status'] == $pending) {
            
            $login->redirect('account_register.php?verify');

        } 

    } catch (PDOException $e) {

        echo $e->getMessage();

    }

    if (isset($_POST['loginBtn'])) {

		$loginUser = $login->checkInput($_POST['loginUser']);
		$loginEmail = $login->checkInput($_POST['loginUser']);
		$loginPassword = $login->checkInput($_POST['loginPassword']);    	

		if($login->user_login($loginUser, $loginEmail, $loginPassword))
		{
			$login->redirect('index.php');
		}
		else
		{
			$error[] = "Incorrect user information!";
		}

    }
?>
<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Log into Barangay Salitran II</title>
        <meta name="description" content="Hassle-free requesting of documents? We heard you! Log in now to start.">
        <meta name="viewport" content="width=device-width, initial-scale=1">

		<!--
			CSS styles, fonts, libraries and frameworks goes here.
			Bootstrap, Jquery, etc..
		-->
        <?php include './libraries.php'; ?>

    </head>
    <body>

        <div class="row">
        	<div class="col-md-6 col-lg-6 col-xl-6 col-sm-6">
        		
        	</div>
            <div class="col-md-6 col-lg-6 col-xl-6 col-sm-6">
                <div class="container-fluid">
        			<form method="post" class="loginForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        				<div class="card">
        					<div class="card-body">
			        			<h3 class="form-text text-uppercase text-muted my-4"><span class="display-4 mr-3 text-success">|</span>Log in</h3>
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
		        				<div class="form-label-group">
		        					<input type="text" id="loginUser" name="loginUser" class="form-control" placeholder="Username or Email" required autofocus>
		        					<label for="loginUser">Username or Email</label>
		        				</div>
		        				<div class="form-label-group">
		        					<input type="password" id="loginPassword" name="loginPassword" class="form-control" placeholder="Password" required>
		        					<label for="loginPassword">Password</label>
		        				</div>
		        				<div class="custom-control custom-checkbox mb-3">
					                <input type="checkbox" class="custom-control-input" id="customCheck1">
					                <label class="custom-control-label" for="customCheck1">Remember password</label>
				              	</div>
				              	<input type="submit" name="loginBtn" class="btn btn-lg btn-primary btn-block text-uppercase" value="Log in">
				              	<hr class="my-4">
								<a href="reset_password.php" role="button" class="btn-link">Recover your account.</a>
								Click <a href="account_register.php" role="button" class="btn-link">here</a> to sign up.
							</div>
						</div>
        			</form>
	        	</div>
	        </div>
    	</div>
    </body>
</html>