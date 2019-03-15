<?php

	//require_once("./config/session.php");
    require_once("./config/config.php");

    $auth_user_request_appointment = new USER();

	if (isset($_POST['requestAppointmentBtn']))
	{

		$fullname = $auth_user_request_appointment->checkInput($_POST['fullname']);
		$email = $auth_user_request_appointment->checkInput($_POST['email']);
		$contactnumber = $auth_user_request_appointment->checkInput($_POST['contactnumber']);
		$appointmentDate = $auth_user_request_appointment->checkInput($_POST['appointmentDate']);
		$appointmentTime = $auth_user_request_appointment->checkInput($_POST['appointmentTime']);
		$purpose = $auth_user_request_appointment->checkInput($_POST['purpose']);


		if (!preg_match("/^[a-zA-Z,. ]*$/" , $fullname)){

            $error[] = "Invalid name format.";

        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        	$error[] = "Invalid email address.";

        } else{

        	if($auth_user_request_appointment->requestAppointment()) {


        	}

        }


	}

?>
<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Requesting Appointment ...</title>
        <meta name="description" content="Hassle-free requesting of appointment? We heard you!">
        <meta name="viewport" content="width=device-width, initial-scale=1">

		<!--
			CSS styles, fonts, libraries and frameworks goes here.
			Bootstrap, Jquery, etc..
		-->
        <?php include './libraries.php'; ?>


    </head>
    <body>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="appointmentForm" method="post" autocomplete="off">
			<div class="card">
				<div class="card-body">
					<h3 class="form-text text-uppercase text-muted my-4"><span class="display-4 mr-3 text-success">|</span>Request Appointment</h3>
					<h6 class="form-text text-muted">Please enter all the details.</h6>
					
					<div class="form-label-group">
						<input type="text" class="form-control" id="requestfullname" name="fullname" placeholder="Full name" />
						<label for="requestfullname">Full name</label>
						<p id="errorFullnameDisplay"></p>
					</div>
					<div class="form-label-group">
						<input type="email" class="form-control" id="requestemail" name="email" placeholder="Email" />
						<label for="requestemail">Email</label>
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
								<input type="text" class="form-control" placeholder="Contact Number" name="contactnumber" minlength="10" maxlength="10" id="requestcontact" />
								<label for="requestcontact">Contact Number</label>
								<p id="errorContactDisplay"></p>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-label-group">
								<input type="text" name="appointmentDate" placeholder="Date of Appointment" id="appointmentDate" class="form-control" />
								<label for="appointmentDate">Date of Appointment</label>
								<p id="errorAppointmentDateDisplay"></p>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-label-group">
								<input type="text" placeholder="Time of Appointment" name="appointmentTime" id="appointmentTime" class="form-control" />
								<label for="appointmentTime">Time of Appointment</label>
								<p id="errorAppointmentTimeDisplay"></p>
							</div>
						</div>
					</div>
					<label for="requestpurpose" class="form-text text-muted">Purpose</label>					
					<div class="form-label-group">
						<textarea name="purpose" id="requestpurpose" cols="70" rows="3" class="form-control border-secondary" ></textarea>
					</div>
					<p id="errorPurposeDisplay"></p>
					<small class="form-text text-muted">&nbsp;</small>
					<input type="submit" value="Submit" name="requestAppointmentBtn" class="form-control btn btn-outline-success"/>
				</div>
			</div>
		</form>
		<script type="text/javascript">
			$("#appointmentForm").validate();
			$(document).ready(function() {
		        var appointmentDate = "";
		        $('#appointmentDate').datepicker({
		        	timepicker: false,
		            autoSize: true,
		            minDate: "+1",
		            changeMonth: true,
		            changeYear: true
		        });
		    });
		    $('#appointmentTime').timepicker({
			    timeFormat: 'h:mm p',
			    interval: 60,
			    minTime: '8',
			    maxTime: '4:00pm',
			    defaultTime: '8',
			    startTime: '10:00',
			    dynamic: true,
			    dropdown: true,
			    scrollbar: true
			});
		</script>
    </body>
</html>
