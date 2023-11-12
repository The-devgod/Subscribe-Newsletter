<?php
/**
* Class and Function List:
* Function list:
* - SendMail()
* Classes list:
*/
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


function SendMail($email_address, $subject, $mail_message, $first_name)
{

	//Load Composer's autoloader
	require(__DIR__ . "/../../vendor/autoload.php");

	$mail = new PHPMailer;

	//Create an instance; passing `true` enables exceptions
	$mail = new PHPMailer(true);

	try
	{
		//Server settings
		//$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
		$mail->isSMTP(); //Send using SMTP
		$mail->Host       = /*'premium143.web-hosting.com'*/ 'smtp.gmail.com';                     //Set the SMTP server to send through
$mail->SMTPAuth   = true;                                   //Enable SMTP authentication

         $mail->Username   = 'kingsleychibueze16@gmail.com';                     //SMTP username

         $mail->Password   = 'ecyusenfnjbzjccr';  
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable implicit TLS encryption
		$mail->Port       = 465; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
		//Recipients
		$mail->setFrom("kingsleychibueze16@gmail.com", "Thedevgod_");
		$mail->addAddress($email_address, $first_name);
		//Add a recipient
		//$mail->addAddress('ellen@example.com');               //Name is optional
		//$mail->addReplyTo('info@example.com', 'Information');
		//$mail->addCC('cc@example.com');
		//$mail->addBCC('bcc@example.com');
		//Attachments
		//$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
		//mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
		//Content
		$mail->isHTML(true); //Set email format to HTML
		$mail->Subject = $subject;
		$mail->Body    = $mail_message;
		$mail->AltBody = 'Thanks for reaching out';

		if ($mail->send()); {
		return true;
		}
	}
	catch(Exception $e)
	{
		//echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}
}

