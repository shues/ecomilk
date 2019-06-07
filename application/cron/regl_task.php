<?php
/*
SELECT
		`name`,
		`autor`,
		`display_name`,
		`wp_users`.`id` AS `owner`
	FROM
		`r_tickets_plan`
	LEFT OUTER JOIN
		`r_tickets`
	ON
		`r_tickets_plan`.`r_ticket`=`r_tickets`.`id`
	LEFT OUTER JOIN
		`wp_users`
	ON
		`wp_users`.`id`=`r_tickets`.`owner`
	WHERE
		`r_tickets_plan`.`".$today."` = '1'

*/
/*
здесь мы будем проверять, какие регламентные задачи еще не были выполнены.
Этот скрипт загружается каждый час, выполняет свое дело, и завершается.
Алгоритм работы:
 1. Выбрать задачи которые должны были завершиться ко времени запуска скрипта.
 2. Выбрать те задачи которые еще не завершены.
 3. Отправить список незавершенных задач исполнителю и руководителю отдела исполнителя. 	
*/


$db = mysqli_connect("localhost", "root", "glos2ar12", 'corpecomilk');
if(!$db) {
	echo 'error';
	return;
}

mysqli_query($db,"SET NAMES 'utf8'");

$today = strtolower(date('D'));
$now = date('Y-m-d');
$query = "
	SELECT 
		`r_ticket`, 
		`r_tickets`.`name` AS `name`,
		`owner`, 
		`display_name`, 
		`departament`, 
		`boss`, 
		`time_ok` 
	FROM 
		`r_tickets_plan` 
		LEFT OUTER JOIN 
			`r_tickets` 
		ON 
			`r_tickets`.`id`=`r_ticket` 
		LEFT OUTER JOIN 
			`wp_users` 
		ON 
			`wp_users`.`ID`=`owner` 
		LEFT OUTER JOIN 
			`depts` 
		ON 
			`departament`=`depts`.`id` 
		LEFT OUTER JOIN 
			(
				SELECT 
					* 
				FROM 
					`r_task_log` 
				WHERE 
					`time_ok` = '$now'
			) AS `r_task_log` 
		ON 
			`r_tickets`.`id`=`t_id` 
		WHERE 
			`".$today."`='1' 
		AND 
			`time_ok` IS NULL;
";
echo $query;
$res = mysqli_query($db,$query);
if(!$res) {
	echo 'error';
}
$subj = 'not complite task';
$tabl = array();
while($count = mysqli_fetch_assoc($res)) {
	$tabl[$count['owner']] = "\n".$count['name'] .' for '. $count['display_name'];
	//$boss_tabl 
}

print_r($tabl);

foreach($tabl as $key=>$value){
	send_mess('', $key, $subj, $value, $db);
}

function conn_to_base() {
    $db = mysqli_connect("localhost", "root", "glos2ar12", 'corpecomilk');
    if (!$db) {
    		//return;
        $db = null;
        echo 'error db';
    }
    echo "ok";
    mysqli_set_charset($db,"utf8");
    
    return $db;
}

function send_mess($from, $send_to, $subj, $text, $db){
	//echo $send_to;
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
		//$text = 'test';
		$text = nl2br($text);
		//echo $from.' '.$send_to;
		MailSmtp($from, $send_to, $subj, $text);
}
	
function MailSmtp($from, $to, $subject, $message){
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
	
	function fatal_handler() {
		$errno   = E_CORE_ERROR;
		$error = error_get_last();
	}

?>
