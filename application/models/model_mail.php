<?php

require_once('./application/core/base.php');

class Model_mail {

	public function send_mess($from, $send_to, $subj, $text, $db){
		echo $send_to;
		$query = "
			SELECT 
				`display_name`
			FROM
				`wp_users`
			WHERE
				`id`='$from'
		";
		$res = mysqli_query($db,$query);
		$from = mysqli_fetch_array($res)[0];
		$query = "
			SELECT 
				`user_email`
			FROM
				`wp_users`
			WHERE
				`id`='$send_to'
		";
		$res = mysqli_query($db,$query);
		$send_to = mysqli_fetch_array($res)[0];
		$text = $from.' '.$text;
		$text = nl2br($text);
		echo $from.' '.$send_to;
		$this->MailSmtp($from, $send_to, $subj, $text);
	}
	
	private function MailSmtp($from, $to, $subject, $message){
		register_shutdown_function( "fatal_handler" );
		try{
			
			$headers = "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html; charset=utf-8\r\n";
			$headers .= "To: $to\r\n";
			$headers .= "From: Robot <robot@ecomilk.ru>";
			
			$mhSmtpMail_Server = "ssl://smtp.mastermail.ru";
			$mhSmtpMail_Port = 465;
			$mhSmtpMail_Username = "v.laptev@ecomilk.ru";
			$mhSmtpMail_Password = "glos2ar12";
			
			$mhSmtpMail_localhost  = "localhost";
			$mhSmtpMail_newline    = "\r\n";
			$mhSmtpMail_timeout    = "10";
			
			$smtpConnect = fsockopen($mhSmtpMail_Server, $mhSmtpMail_Port, $errno, $errstr, $mhSmtpMail_timeout);
			$smtpResponse = fgets($smtpConnect, 515);
			
			if(empty($smtpConnect)){
				$output = "Failed to connect: $smtpResponse";
				return $output;
			}
			else
			{
				$logArray['connection'] = "Connected: $smtpResponse";
			}
			fputs($smtpConnect, "HELO $mhSmtpMail_localhost" . $mhSmtpMail_newline);
			$smtpResponse = fgets($smtpConnect, 515);
			$logArray['heloresponse'] = "$smtpResponse";
			
			fputs($smtpConnect,"AUTH LOGIN" . $mhSmtpMail_newline);
			$smtpResponse = fgets($smtpConnect, 515);
			$logArray['authrequest'] = "$smtpResponse";
			
			fputs($smtpConnect, base64_encode($mhSmtpMail_Username) . $mhSmtpMail_newline);
			$smtpResponse = fgets($smtpConnect, 515);
			$logArray['authmhSmtpMail_username'] = "$smtpResponse";
			
			fputs($smtpConnect, base64_encode($mhSmtpMail_Password) . $mhSmtpMail_newline);
			$smtpResponse = fgets($smtpConnect, 515);
			$logArray['authmhSmtpMail_password'] = "$smtpResponse";
			
			fputs($smtpConnect, "MAIL FROM: $mhSmtpMail_Username" . $mhSmtpMail_newline);
			$smtpResponse = fgets($smtpConnect, 515);
			$logArray['mailmhSmtpMail_fromresponse'] = "$smtpResponse";
			
			fputs($smtpConnect, "RCPT TO: $to" . $mhSmtpMail_newline);
			$smtpResponse = fgets($smtpConnect, 515);
			$logArray['mailtoresponse'] = "$smtpResponse";
			
			fputs($smtpConnect, "DATA" . $mhSmtpMail_newline);
			$smtpResponse = fgets($smtpConnect, 515);
			$logArray['data1response'] = "$smtpResponse";
			
			fputs($smtpConnect, "Subject: $subject\r\n$headers\r\n\r\n$message\r\n.\r\n");
			$smtpResponse = fgets($smtpConnect, 515);
			$logArray['data2response'] = "$smtpResponse";
			
			fputs($smtpConnect,"QUIT" . $mhSmtpMail_newline);
			$smtpResponse = fgets($smtpConnect, 515);
			$logArray['quitresponse'] = "$smtpResponse";
			echo $to;
		}
		catch(Exception $e){
			echo "Не удалось отправить уведомление на почту.";
		}
	}
	
	public function fatal_handler() {
		$errno   = E_CORE_ERROR;
		$error = error_get_last();
	}
}	
?>