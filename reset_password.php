<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Reset Password</title>
        <meta name="description" content="You can always recover your account.">
        <meta name="viewport" content="width=device-width, initial-scale=1">

		<!--
			CSS styles, fonts, libraries and frameworks goes here.
			Bootstrap, Jquery, etc..
		-->
        <link rel="shortcut icon" type="image/x-icon" href="./img/favicon.ico"/>
        <link rel="stylesheet" type="text/css" href="./assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="./style.css">
        <link rel="stylesheet" type="text/css" href="./assets/font-awesome/webfonts/all.min.css">
        <script type="text/javascript" src="./assets/bootstrap/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container">
            <form method="post" class="resetPasswordForm">
                <h2 class="form-text text-uppercase text-muted my-4 text-center">Recovering Account</h2>
                <h6 class="form-text text-uppercase text-muted mb-4">Enter your Username or Email</h6>

                <div class="row">
                    <div class="col-md-8 col-lg-8 col-xl-8">
                        <div class="form-label-group">
                            <input type="text" id="resetPasswordUser" name="resetPasswordUser" class="form-control" placeholder="Username or Email" minlength="5" required autofocus>
                            <label for="resetPasswordUser">Username or Email</label>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4 col-xl-4">
                        <input type="submit" name="verify" class="btn btn-lg btn-primary btn-block text-uppercase" value="Verify">
                    </div>
                </div>
                <a href="account_register.php" role="button" class="btn-link">Create an account.</a>
                Click <a href="login.php" role="button" class="btn-link">here</a> to log in.
            </form>
        </div>
    </body>
</html>