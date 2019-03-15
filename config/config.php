<?php

require_once('dbconfig.php');

class User
{

	private $conn;

	/*
		Database Constructor
		Initializing database
	 */

	public function __construct() {

		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;

	}

	/*
		Database Querying
	 *	
	 */


	public function runQuery($sql) {

		$stmt = $this->conn->prepare($sql);
    	return $stmt;

	}

	/*
	
		Checking of inputs
		Securing of data

	 */
	
	public function checkInput($data) {

		$data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;

	}

	/*
		
		immediate redirecting

	 */
	
	public function redirect($url) {

		header("Location: $url");

	}

	/*
		redirecting with 5 seconds interval
	 */
	public function slow_redirect($url){

		header("refresh:5;url=$url");

	}

	/*
	
		session holder

	 */
	
	public function is_loggedin() {

    	if(isset($_SESSION['username']) || isset($_SESSION['email'])) {
      		return true;
    	}

  	}

  	/*
  	
  		sending of sms

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

	/*
  		sending of email
  		account_register.php
		
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

  	/*
		Generating random strings
		account_register.php && reset_password.php
  	 */
  	
  	public function generateNewString($len = 5) {

  		$token = "abcdefghijklmnopqrstuvwxyz1234567890";
        $token = str_shuffle($token);
        $token = substr($token, 0, $len);
        return $token;

  	}

	/*
		Registration of User
		account_register.php
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

	/*
		login of user
		login.php
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

	/*
		Inserting of personal info of user
		account_setup.php
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

	/*
		Log out function
		for user and admin
	 */

	public function doLogout() {

		session_destroy();
	    unset($_SESSION['username']);
	    unset($_SESSION['email']);
	    return true;

	}

	/*
		requesting of appointment
		user_appointment_request.php

	 */
	
	public function requestAppointment($fullname, $email, $contactnumber, $appointmentDate, $appointmentTime, $purpose) {

		try {

			$stmt = $this->conn->prepare("INSERT INTO appointment_tbl(residents_prefix, residents_first_name, residents_middle_name, residents_last_name, residents_suffix, residents_gender, residents_birthday, residents_age, residents_birthplace, residents_home_address) VALUES (:prefix, :firstname, :middlename, :lastname, :suffix, :gender, :birthday, :age, :birthplace, :full_address)");

			
		} catch (PDOException $e) {
			
		}
	}

}
?>