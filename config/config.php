<?php

require_once('dbconfig.php');

/**
 * Main Class called USER
 */
class User
{
	/**
	 * Connector for databases
	 */
	private $conn;

	/**
	 * Initialize Database
	 */

	public function __construct() {

		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;

	}

	/**
	 * Function for querying
	 *
	 * @param string $sql
	 * @return $stmt
	 */
	public function runQuery($sql) {

		$stmt = $this->conn->prepare($sql);
    	return $stmt;

	}

	/**
	 * Function for Sanitizing data
	 *
	 * @param string $data
	 * @return $data
	 */
	public function checkInput($data) {

		$data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;

	}

	/**
	 * Function for redirecting
	 *
	 * @param string $url
	 * @return void
	 */
	public function redirect($url) {

		header("Location: $url");

	}

	/**
	 * Function for redirecting with
	 * 5 seconds interval
	 * @param string $url
	 * @return void
	 */
	public function slow_redirect($url){

		header("refresh:5;url=$url");

	}

	/**
	 * Function if user is logged in
	 *
	 * @return boolean
	 */
	public function is_loggedin() {

    	if(isset($_SESSION['username']) || isset($_SESSION['email'])) {
      		return true;
    	}

  	}

  	/**
	 * Function for OTP using SMS
	 *
	 * @param string $number
	 * @param string $message
	 * @param string $apicode
	 * @return void
	 */
  	public function send_code($number, $message, $apicode){

  		$url = 'https://www.itexmo.com/php_api/api.php';
		$itexmo = array('1' => $number, '2' => $message, '3' => $apicode);
		$param = array(
		    'http' => array(
		        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
		        'method'  => 'POST',
		        'content' => http_build_query($itexmo),
		    ),
		);
		$context  = stream_context_create($param);
		return file_get_contents($url, false, $context);

	}

	/**
	 * Function for OTP using email
	 *
	 * @param string $token
	 * @param string $email_session
	 * @return void
	 */
  	public function send_email($token, $email_session){

  		try {

			    require './PHPMailer-5.2-stable/PHPMailerAutoload.php';

				$mail = new PHPMailer;
				$mail->isSMTP();                                      // Set mailer to use SMTP
				$mail->Host = 'smtp.gmail.com';             		  // Specify main and backup SMTP servers
				$mail->SMTPAuth = true;                               // Enable SMTP authentication
				$mail->Username = 'service.salitrandos@gmail.com';    // SMTP username
				$mail->Password = 'p@ssphr@s3';                       // SMTP password
				$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
				$mail->Port = 587;                                    // TCP port to connect to

				$mail->setFrom('service.salitrandos@gmail.com', 'Barangay Salitran II');
				$mail->addAddress($email_session);     						  // Add a recipient

				$mail->isHTML(true);                                  // Set email format to HTML

				$mail->Subject = 'Activate Account';
				$mail->Body    = "
				  Hi! , <br><br>
				  Here is your code:<br><br>
				  $token <br><br>
				  Kind Regards,<br>
				  Administrator, Barangay Salitran II
				";

				if(!$mail->send()) {
				  echo 'Message could not be sent.';
				  echo 'Mailer Error: ' . $mail->ErrorInfo;
				} else {

				}

  		} catch (PDOException $e) {
  			echo $e->getMessage();
  		}
  	}

  	/**
	   * Function for creating token for OTP
	   *
	   * @param string $token
	   * @param integer $len
	   * @return $token
	   */
  	public function generateNewString($len = 5) {

  		$token = "abcdefghijklmnopqrstuvwxyz1234567890";
        $token = str_shuffle($token);
        $token = substr($token, 0, $len);
        return $token;

  	}


	/**
	 * Function for register
	 *
	 * @param string $username
	 * @param string $email
	 * @param string $password
	 * @param string $mobile_number
	 * @param string $token
	 * @return $stmt and $stmt1
	 */
	public function register($username, $email, $password, $mobile_number, $token) {


		try {

			$status = "Pending";
			$dateCreated = date('Y-m-d G:i:s');
			$hashed_password = password_hash($password, PASSWORD_DEFAULT);

			$stmt = $this->conn->prepare("INSERT INTO useraccount_tbl(user_name, user_email, user_password, user_mobile_number, user_status, user_email_token, user_date_created) VALUES (:username, :email, :password, :mobile_number, :status, :user_email_token, :dateCreated)");

			$stmt1 = $this->conn->prepare("INSERT INTO residents_tbl(residents_first_contact_number)
												VALUES (:residents_mobile_number)");

			$stmt->bindparam(":username", $username);
		    $stmt->bindparam(":email", $email);
		    $stmt->bindparam(":password", $hashed_password);
		    $stmt->bindparam(":mobile_number", $mobile_number);
		    $stmt->bindparam(":status", $status);
		    $stmt->bindparam(":user_email_token", $token);
		    $stmt->bindparam(":dateCreated", $dateCreated);

		    $stmt1->bindparam(":residents_mobile_number", $mobile_number);

		    $stmt->execute();
		    $stmt1->execute();

		    return $stmt;
		    return $stmt1;

		} catch (PDOException $e) {

			echo $e->getMessage();

		}
	}

	/**
	 * Function for logging in
	 *
	 * @param string $username
	 * @param string $email
	 * @param string $password
	 * @return boolean
	 */
	public function user_login($username, $email, $password) {

		try {

			$stmt = $this->conn->prepare("SELECT user_id, user_name, user_email, user_password
											FROM useraccount_tbl
												WHERE user_name=:username
													OR user_email=:email");

			$stmt->execute(array(':username'=>$username, ':email'=>$email));
      		$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

      		if($stmt->rowCount() == 1)
		    {
		        if(password_verify($password, $userRow['user_password']))
		        {
		          	$_SESSION['username'] = $userRow['user_name'];
		          	$_SESSION['email'] = $userRow['user_email'];
		          	return true;
		        }
		        else
		        {
		          	return false;
		        }
		    }

		} catch (PDOException $e) {

			echo $e->getMessage();

		}

	}

	/**
	 * Function for inserting of info right after
	 * registration of user.
	 *
	 * Required.
	 *
	 * @param string $firstname
	 * @param string $prefix
	 * @param string $middlename
	 * @param string $lastname
	 * @param string $suffix
	 * @param string $gender
	 * @param string $birthday
	 * @param string $age
	 * @param string $birthplace
	 * @param string $block
	 * @param string $street
	 * @param string $subdivision
	 * @return $stmt
	 */
	public function save_user_info($prefix, $firstname, $middlename, $lastname, $suffix, $gender, $birthday, $age, $birthplace, $block, $street, $subdivision) {

		try {

			$full_address = $block . " " . $street . " " . $subdivision;
			$stmt = $this->conn->prepare("INSERT INTO residents_tbl(residents_prefix, residents_first_name, residents_middle_name, residents_last_name, residents_suffix, residents_gender, residents_birthday, residents_age, residents_birthplace, residents_home_address) VALUES (:prefix, :firstname, :middlename, :lastname, :suffix, :gender, :birthday, :age, :birthplace, :full_address)");

			$stmt->bindparam(":prefix", $prefix);
		    $stmt->bindparam(":firstname", $firstname);
		    $stmt->bindparam(":middlename", $middlename);
		    $stmt->bindparam(":lastname", $lastname);
		    $stmt->bindparam(":suffix", $suffix);
		    $stmt->bindparam(":gender", $gender);
		    $stmt->bindparam(":birthday", $birthday);
		    $stmt->bindparam(":age", $age);
		    $stmt->bindparam(":birthplace", $birthplace);
		    $stmt->bindparam(":full_address", $full_address);

		    $stmt->execute();

		    return $stmt;

		} catch (PDOException $e) {

			echo $e->getMessage();

		}
	}

	/**
	 * function for logout
	 *
	 * @return boolean
	 */
	public function doLogout() {

		session_destroy();
	    unset($_SESSION['username']);
	    unset($_SESSION['email']);
	    return true;

	}

	/**
	 * Function for requesting of appointment
	 *
	 * @param string $username
	 * @param string $fullname
	 * @param string $email
	 * @param string $contactnumber
	 * @param date $appointmentDate
	 * @param date $appointmentTime
	 * @param string $purpose
	 * @param string $status
	 * @param date $date_requested
	 * @return $stmt
	 */
	public function requestAppointment($username, $fullname, $email, $contactnumber, $appointmentDate, $appointmentTime, $purpose, $status, $date_requested) {

		try {

			$stmt = $this->conn->prepare("INSERT INTO appointment_tbl(appointment_username, appointment_fullname, appointment_email, appointment_contactnumber, appointment_date, appointment_time, appointment_purpose, appointment_daterequested, appointment_status) VALUES (:username, :fullname, :email, :contactnumber, :appointmentdate, :appointmenttime, :appointmentpurpose, :appointmentdaterequested, :appointmentstatus)");

			$stmt->bindparam(":username", $username);
		    $stmt->bindparam(":fullname", $fullname);
		    $stmt->bindparam(":email", $email);
		    $stmt->bindparam(":contactnumber", $contactnumber);
		    $stmt->bindparam(":appointmentdate", $appointmentDate);
		    $stmt->bindparam(":appointmenttime", $appointmentTime);
		    $stmt->bindparam(":appointmentpurpose", $purpose);
		    $stmt->bindparam(":appointmentdaterequested", $date_requested);
			$stmt->bindparam(":appointmentstatus", $status);

			$stmt->execute();

		    return $stmt;

		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	/**
	 * Function for sending email confirmation
	 * for appointment
	 *
	 * @param string $email_session
	 * @param date $appointmentDate
	 * @param time $appointmentTime
	 * @param string $purpose
	 * @return void
	 */
  	public function send_appointment_confirmation_email($email_session, $appointmentDate, $appointmentTime, $purpose){

		try {

			  require './PHPMailer-5.2-stable/PHPMailerAutoload.php';

			  $mail = new PHPMailer;
			  $mail->isSMTP();                                      // Set mailer to use SMTP
			  $mail->Host = 'smtp.gmail.com';             		  // Specify main and backup SMTP servers
			  $mail->SMTPAuth = true;                               // Enable SMTP authentication
			  $mail->Username = 'service.salitrandos@gmail.com';    // SMTP username
			  $mail->Password = 'p@ssphr@s3';                       // SMTP password
			  $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
			  $mail->Port = 587;                                    // TCP port to connect to

			  $mail->setFrom('service.salitrandos@gmail.com', 'Barangay Salitran II');
			  $mail->addAddress($email_session);     						  // Add a recipient

			  $mail->isHTML(true);                                  // Set email format to HTML

			  $mail->Subject = 'Your Appointment Details';
			  $mail->Body    = "
				Hi! , <br><br>
				Your request for appointment on " . $appointmentDate->format('F-d-Y') . ", ". $appointmentTime. " to request for " . $purpose . " is now being processed. <br><br>
				We will contact you for the update.<br><br>
				Kind Regards,<br>
				Administrator, Barangay Salitran II
			  ";

			  if(!$mail->send()) {
				echo 'Message could not be sent.';
				echo 'Mailer Error: ' . $mail->ErrorInfo;
			  } else {

			  }

		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	/**
	 * Function for updating appointment
	 *
	 * @param string $username
	 * @param string $fullname
	 * @param string $email
	 * @param string $contactnumber
	 * @param date $appointmentDate
	 * @param date $appointmentTime
	 * @param string $purpose
	 * @param string $status
	 * @param date $date_requested
	 * @return $stmt
	 */
	public function requestUpdateAppointment($username, $fullname, $email, $contactnumber, $appointmentDate, $appointmentTime, $purpose, $status, $date_requested) {

		try {

			$stmt = $this->conn->prepare("INSERT INTO appointment_tbl(appointment_username, appointment_fullname, appointment_email, appointment_contactnumber, appointment_date, appointment_time, appointment_purpose, appointment_daterequested, appointment_status) VALUES (:username, :fullname, :email, :contactnumber, :appointmentdate, :appointmenttime, :appointmentpurpose, :appointmentdaterequested, :appointmentstatus)");

			$stmt->bindparam(":username", $username);
		    $stmt->bindparam(":fullname", $fullname);
		    $stmt->bindparam(":email", $email);
		    $stmt->bindparam(":contactnumber", $contactnumber);
		    $stmt->bindparam(":appointmentdate", $appointmentDate);
		    $stmt->bindparam(":appointmenttime", $appointmentTime);
		    $stmt->bindparam(":appointmentpurpose", $purpose);
		    $stmt->bindparam(":appointmentdaterequested", $date_requested);
			$stmt->bindparam(":appointmentstatus", $status);

			$stmt->execute();

		    return $stmt;

		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

/**
 *	End of User Class
 *
 */
}
?>