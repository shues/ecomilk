<?php

require_once('./application/core/base.php');
require_once('./application/models/model_mail.php');

class Model_page_5_4 extends Model {

	public function get_data() {
		$this->set_all_cookie();
        $db = conn_to_base();
        if (!$db) {
            echo "error of connect to db";
            return;
        }
        $data[0] = get_main_menu();
        $param = $_SESSION['user_num'];

        $data[1] = $this->get_user_info($db, $param);
        $data[2] = $this->get_executors($db);
        if($_COOKIE['my_task'] == 'on'){
            $data[3] = $this->get_task_of_user($db, $param);
        }
        if($_COOKIE['for_me_task'] == 'on'){
            $data[4] = $this->get_task_for_user($db, $param);
        }

        mysqli_close($db);
        return $data;
    }

    public function add_ticket() {
        $data = $_GET['data'];
        echo $data;
        $data_day = substr($data, 0, 2);
        $data_month = substr($data, 3, 2);
        $data_year = substr($data, 6);
        $data = $data_year . '-' . $data_month . '-' . $data_day;
        echo $data;
        if (!checkdate($data_month, $data_day, $data_year)) {
            return;
        }
        $owner = $_SESSION['user_num'];
        $name = $_GET['name'];
        $opis = $_GET['opis'];
        $deadline = $_GET['deadline'];
        $priority = $_GET['priority'];
        $execut = $_GET['executor'];
        $controller = $_GET['controller'];
        $consultant = $_GET['consultant'];
        $status = '1';

        $today = date('Y-m-d H:i:s');
        if (strpos($execut, 'g') == FALSE) {
            $executor = $execut;
            $executor_group = 0;
        } else {
            $executor = 0;
            $executor_group = substr($execut, 1);
        }

        $db = conn_to_base();
        if (!$db) {
            echo "error of connect to db";
            return;
        }

        // Добавить задачу
        $query = "INSERT INTO `tickets` VALUES(default,'$name','$today')";
        $res = mysqli_query($db, $query);
        if (!$res) {
            return;
        }
        $query = "SELECT LAST_INSERT_ID()";
        $res = mysqli_query($db, $query);
        $id = mysqli_fetch_array($res)[0];
        $today_plus = date('Y-m-d H:i:s');

        // Установить состояние задачи       
        $query = "INSERT INTO `tickets_state` VALUES('$today','$id','$status')";
        mysqli_query($db, $query);


        // Установить сроки и приоритет задачи       
        $query = "INSERT INTO `tickets_terms` VALUES('$today','$id','$deadline','$priority')";
        mysqli_query($db, $query);

        // Сохранить комментарий к задаче
        if ($opis != '') {
            $query = "INSERT INTO `tickets_comments` VALUES('$id','$today','$opis','$owner')";
            mysqli_query($db, $query);
        }

        // Сохранить пользователей задачи
        $query = "INSERT INTO `tickets_users` VALUES('$id','1','$owner')";
        mysqli_query($db, $query);

        $query = "INSERT INTO `tickets_users` VALUES('$id','2','$executor')";
        mysqli_query($db, $query);

        $query = "INSERT INTO `tickets_users` VALUES('$id','3','$controller')";
        mysqli_query($db, $query);

        $query = "INSERT INTO `tickets_users` VALUES('$id','4','$consultant')";
        mysqli_query($db, $query);
        $text = "создал новую задачу для вас"."\r\n";
        $text .= "Название задачи: $name"."\r\n";
        $text .= "Описание задачи: $opis"."\r\n";
        $text .= "Срок выполнения задачи: ".date("d.m.y",strtotime($deadline))."\r\n";
        $this->modmail = new Model_mail();
        $this->modmail->send_mess($owner, $executor, "Новая задача :$name", $text, $db);
    }

    public function del_ticket() {
        $db = conn_to_base();
        if (!$db) {
            echo "error of connect to db";
            return;
        }

        $id = $_GET['id'];
        
        $query = "SELECT `name` FROM `tickets` WHERE `id`='$id'";
        $res = mysqli_query($db, $query);
        $name = mysqli_fetch_array($res)[0];
        
        $query = "SELECT `user_id` FROM `tickets_users` WHERE `ticket_id`='$id' AND `role`='2'";
        $res = mysqli_query($db, $query);
        $executor = mysqli_fetch_array($res)[0];
        
        $query = "DELETE FROM `tickets` WHERE `id`='$id'";
        $res = mysqli_query($db, $query);

        $query = "DELETE FROM `tickets_comments` WHERE `ticket_id`='$id'";
        $res = mysqli_query($db, $query);

        $query = "DELETE FROM `tickets_state` WHERE `ticket`='$id'";
        $res = mysqli_query($db, $query);

        $query = "DELETE FROM `tickets_terms` WHERE `ticket_id`='$id'";
        $res = mysqli_query($db, $query);

        $query = "DELETE FROM `tickets_users` WHERE `ticket_id`='$id'";
        $res = mysqli_query($db, $query);
        
        
        $owner = $_SESSION['user_num'];
        
        $text = "удалил задачу созданную для вас"."\r\n";
        $text .= "Название задачи: $name"."\r\n";
        $this->modmail = new Model_mail();
        $this->modmail->send_mess($owner, $executor, "Задача $name удалена", $text, $db);
    }

    public function save_ticket() {
        $id = $_GET['task_id'];
        $saver = $_SESSION['user_num'];
        $opis = $_GET['opis'];
        
        $deadline = $_GET['deadline'];
        $deadline_day = substr($deadline, 0, 2);
        $deadline_month = substr($deadline, 4, 2);
        $deadline_year = substr($deadline, 6);
        $deadline = $deadline_year . '-' . $deadline_month . '-' . $deadline_day;
        $priority = $_GET['priority'];
        $today = date('Y-m-d H:i:s');

        $db = conn_to_base();
        if (!$db) {
            echo "error of connect to db";
            return;
        }
        
        $query = "SELECT `state` FROM `tickets_state` WHERE `ticket`='$id' ORDER BY `state_date` DESC LIMIT 1";
        $res = mysqli_query($db,$query);
        $state = mysqli_fetch_array($res)[0];
        
        if($state==5){
            return;
        }
        
        if ($opis != '') {
            $query = "INSERT INTO `tickets_comments` VALUES ('$id','$today','$opis','$saver')";
            mysqli_query($db, $query);
        }
        
        if (checkdate($deadline_month, $deadline_day, $deadline_year)) {
            $query = "INSERT INTO `tickets_terms` VALUES('$today','$id','$deadline','$priority')";
            mysqli_query($db, $query);
        }
    }
    
    public function start_ticket(){
        $db = conn_to_base();
        if (!$db) {
            echo "error of connect to db";
            return;
        }
        $id = $_GET['id'];
        $uid = $_SESSION['user_num'];
        $today = date('Y-m-d H:i:s');
        
        // выберем всех исполнителей этой задачи
        $query = "
                SELECT
                    *
                FROM
                    `tickets_users`
                WHERE
                    `ticket_id`='$id' AND `role`='2'
                ";
        $res = mysqli_query($db, $query);
        while ($row = mysqli_fetch_array($res)) {
            if($uid === $row[2]){
                $query = "
                         INSERT INTO
                            `tickets_state`
                         VALUES
                            ('$today','$id','2')
                         ";
                mysqli_query($db, $query);
                $executor = $uid;
                echo "exec_1: ".$executor;
                $query = "SELECT `name` FROM `tickets` WHERE `id`='$id'";
                $res = mysqli_query($db,$query);
                $name = mysqli_fetch_array($res)[0];
                
                $query = "SELECT `user_id` FROM `tickets_users` WHERE `role`='1' AND `ticket_id`='$id'";
                $res = mysqli_query($db,$query);
                $owner = mysqli_fetch_array($res)[0];
                echo "owner_1: ".$owner;
                $text = "взял задачу в работу"."\r\n";
                $text .= "Название задачи: $name"."\r\n";
                $this->modmail = new Model_mail();
        			 $this->modmail->send_mess($executor, $owner, "Задача $name стартовала", $text, $db);
            }
        }
    }
        
    public function ok_ticket() {
        $db = conn_to_base();
        if (!$db) {
            echo "error of connect to db";
            return;
        }
        $id = $_GET['id'];
        $uid = $_SESSION['user_num'];
        $today = date('Y-m-d H:i:s');
        
        // узнаем статус этой задачи
        $query = "
            SELECT
                `state`
            FROM
                `tickets_state`
            WHERE
                `ticket`='$id'
            ORDER BY
                `state_date`
            DESC
            LIMIT 1
            ";
                
        $res = mysqli_query($db, $query);
        $state = mysqli_fetch_array($res)[0];
        switch ($state) {
            case 2:
                $role = 2;
                $next_state = 4;
                break;
            case 4:
                $role = 1;
                $next_state = 5;
                break;
            default:
                break;
        }
        
        // выберем всех исполнителей этой задачи
        $query = "
                SELECT
                    *
                FROM
                    `tickets_users`
                WHERE
                    `ticket_id`='$id' AND `role`='$role'
                ";
        $res = mysqli_query($db, $query);
        while ($row = mysqli_fetch_array($res)) {
            if($uid === $row[2]){
                $query = "
                         INSERT INTO
                            `tickets_state`
                         VALUES
                            ('$today','$id','$next_state')
                         ";
                mysqli_query($db, $query);
                
                $query = "SELECT `name` FROM `tickets` WHERE `id`='$id'";
                $res = mysqli_query($db, $query);
                $name = mysqli_fetch_array($res)[0];
                
                $query = "SELECT `user_id` FROM `tickets_users` WHERE `ticket_id`='$id' AND `role`='1'";
                $res = mysqli_query($db, $query);
                $owner = mysqli_fetch_array($res)[0];
                echo "owner_1: ".$owner;
                $query = "SELECT `user_id` FROM `tickets_users` WHERE `ticket_id`='$id' AND `role`='2'";
                $res = mysqli_query($db, $query);
                $exeсutor = mysqli_fetch_array($res)[0];
                echo "execut_1: ".$exeсutor;
                if($next_state == '4'){
                    $text = "завершил выполнение задачи";
                    $this->modmail = new Model_mail();
                    $this->modmail->send_mess($exeсutor, $owner, "Задача $name завершена", $text, $db);
                }
                elseif($next_state == '5'){
                    $text = "одобрил результат работы";
                    $this->modmail = new Model_mail();
                    $this->modmail->send_mess($owner, $exeсutor, "Задача $name одобрена", $text, $db);
                }
                
                break;
            }
        }
    }
    
    public function pause_ticket($param) {
        
    }
    
    public function send_ticket($param) {
        
    }

    private function get_user_info($db, $uid) {
        $query = "SELECT `display_name` FROM `wp_users` where `id`='$uid'";
        $res = mysqli_query($db, $query);
        $user_info = mysqli_fetch_array($res);
        return $user_info;
    }

    private function get_executors($db) {
        $query = "SELECT * FROM `executors_group`";
        $res = mysqli_query($db, $query);
        $i = 0;
        while ($row = mysqli_fetch_array($res)) {
            $spis[$i][] = 'g' . $row[0];
            $spis[$i][] = $row[1];
            $i++;
        }


        $query = "SELECT `id`,`display_name` FROM `wp_users` ORDER BY `display_name`";
        $res = mysqli_query($db, $query);
        while ($row = mysqli_fetch_array($res)) {
            $spis[$i][] = $row[0];
            $spis[$i][] = $row[1];
            $i++;
        }

        return $spis;
    }

    private function get_task_of_user($db, $uid) {
        $query = $this->big_query($uid, '1');

        $res = mysqli_query($db, $query);
        $i = 0;
        $j = 0;

        while ($row = mysqli_fetch_row($res)) {

            foreach ($row as $value) {
                $struct[$i][$j] = $value;
                $j++;
            }
            $j = 0;
            $i++;
        }
        //echo "<pre>";
        //print_r($struct);
        //echo "</pre>";
        //echo $i;
        return $struct;
    }

    private function get_task_for_user($db, $uid) {
        $query = $this->big_query($uid, '2');

        $res = mysqli_query($db, $query);
        $i = 0;
        $j = 0;

        while ($row = mysqli_fetch_row($res)) {

            foreach ($row as $value) {
                $struct[$i][$j] = $value;
                $j++;
            }
            $j = 0;
            $i++;
        }
        return $struct;
    }
    
    private function big_query($u_id, $role_id) {
        $query = "
            SELECT 
                `mtu`.`user_id`,
                `t`.`id`,
                `t`.`name`,
                `t`.`start`,
                `ticket_state_table`.`last_state`,
                `ticket_terms_table`.`deadline`,
                `ticket_terms_table`.`priority`,
                group_concat(distinct concat_ws(':',date_format(`ticket_comments`.`comment_date`,'%d.%m.%Y'),`ticket_comments`.`disp_name`,`ticket_comments`.`comment_for_ticket`) ORDER BY `ticket_comments`.`comment_date` ASC separator '::') AS `comments`,
                group_concat(distinct concat_ws(':',`ticket_users`.`role_name`,`ticket_users`.`display_name`) separator '; ') AS `users`
            FROM 
                `tickets_users` AS `mtu`
            LEFT OUTER JOIN    
                `tickets` AS `t`
            ON
                `t`.`id` = `mtu`.`ticket_id`
            LEFT OUTER JOIN
                (
                SELECT
                    `state_tbl_1`.`ticket` AS `last_ticket`,
                    `state_tbl_1`.`std`,
                    `state_tbl_2`.`st` AS `last_state`
                FROM
                    (
                    SELECT
                        `ticket`,
                        max(`state_date`) AS `std`
                    FROM
                        `tickets_state`
                    GROUP BY
                        `ticket`
                    ) AS `state_tbl_1`
                LEFT OUTER JOIN
                    (
                    SELECT
                        `state` AS `st`,
                        `state_date`
                    FROM
                        `tickets_state`
                    ) AS `state_tbl_2`
                ON
                    `state_tbl_2`.`state_date` = `state_tbl_1`.`std`
                ) AS `ticket_state_table`
            ON
                `ticket_state_table`.`last_ticket` = `mtu`.`ticket_id`
            LEFT OUTER JOIN
                (
                SELECT
                    `terms_table_1`.`ticket_id` AS `last_ticket`,
                    `terms_table_1`.`terms_date`,
                    `terms_table_2`.`deadline` AS `deadline`,
                    `terms_table_2`.`priority` AS `priority`
                FROM
                    (
                    SELECT
                        `ticket_id`,
                        max(`terms_date`) AS `terms_date`
                    FROM
                        `tickets_terms`
                    GROUP BY `ticket_id`
                    ) AS `terms_table_1`
                LEFT OUTER JOIN
                    (
                    SELECT
                        `deadline`,
                        `priority`,
                        `terms_date`
                    FROM
                        `tickets_terms`
                    ) AS `terms_table_2`
                ON
                    `terms_table_2`.`terms_date` = `terms_table_1`.`terms_date`
                ) AS `ticket_terms_table`
            ON
                `ticket_terms_table`.`last_ticket` = `mtu`.`ticket_id`
            LEFT OUTER JOIN
                (
                SELECT
                    `tc`.`comment_date`,
                    `tc`.`comment_for_ticket`,
                    `tc`.`ticket_id`,
                    `wpu`.`display_name` AS `disp_name`
                FROM
                    `tickets_comments` AS `tc`
                LEFT OUTER JOIN
                    `wp_users` AS `wpu`
                ON
                    `wpu`.`id` = `tc`.`user_id`
                ) AS `ticket_comments`
            ON
                `ticket_comments`.`ticket_id` = `mtu`.`ticket_id`
            LEFT OUTER JOIN
                (
                SELECT
                    `ticket_id`,
                    `role_name`,
                    group_concat(distinct `display_name`) AS `display_name`
                FROM
                    `tickets_users` AS `tu`
                LEFT OUTER JOIN
                    `tickets_roles` AS `tr`
                ON
                    `tr`.`id` = `tu`.`role`
                LEFT OUTER JOIN
                    `wp_users` AS `wpu`
                ON
                    `wpu`.`id` = `tu`.`user_id`
                GROUP BY `ticket_id`, `role_name`
                ) AS `ticket_users`
            ON
                `ticket_users`.`ticket_id` = `mtu`.`ticket_id`
            WHERE 
                `mtu`.`user_id`='$u_id'
            AND 
                `mtu`.`role` = '$role_id'";
		if($_COOKIE['active_task'] == 'off'){
			$query .= "AND `ticket_state_table`.`last_state` NOT IN('1','2','3','4')";
		}
		if($_COOKIE['complite_task'] == 'off'){
			$query .= "AND `ticket_state_table`.`last_state`<>'5'";
		}
		$query .= "GROUP BY `mtu`.`ticket_id`,`mtu`.`user_id`,
                `t`.`id`,
                `t`.`name`,
                `t`.`start`,
                `ticket_state_table`.`last_state`,
                `ticket_terms_table`.`deadline`,
                `ticket_terms_table`.`priority`";
		switch($_COOKIE['order_by']){
			case 'priority':
				$query .= "ORDER BY `ticket_terms_table`.`priority`";
				break;
			case 'deadline':
				$query .= "ORDER BY `ticket_terms_table`.`deadline`";
				break;
			default:				
				break;
		}
		//echo $query;        
        return $query;
    }


	private function set_all_cookie(){
		foreach ($_COOKIE as $key=>$cuca){
			setcookie($key, $cuca, time() + (3600 * 24 * 365));
		}
	}
}
?>