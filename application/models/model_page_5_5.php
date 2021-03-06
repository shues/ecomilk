<?php
require_once('./application/core/base.php');
require_once('./application/models/model_mail.php');

class Model_page_5_5 extends Model{

       
    function get_data() {
        $db = conn_to_base();
        if (!$db) {
            echo "error of connect to db";
            return;
        }
        $data[0] = get_main_menu();
         //print_r($data[0]);
         $today = strtolower(date('D'));
         $nw = date('Y-m-d');
         $my_num = $_SESSION['user_num'];
			//select `display_name`, `dept`, `name` from `wp_users` right outer join (select `departament` as `dept` from `wp_users` where `id` = '132') as `my_dept` on `departament`=`dept` right outer join `r_tickets` ON `owner`=`wp_users`.`id`;
         $query = "
            SELECT
  					`display_name`,
  					`dept`,
  					`name`,
  					`time_ok`,
  					`r_tickets_plan`.*,
  					GROUP_CONCAT(
    					DISTINCT CONCAT_WS(
      					':',
      					`r_tickets_comm`.`date`,
      					`r_tickets_comm`.`autor`,
      					`r_tickets_comm`.`text`
    					) SEPARATOR ';'
  					) AS `comm`
				FROM
  					`wp_users`
				RIGHT OUTER JOIN
  					(
  						SELECT
    						`departament` AS `dept`
  						FROM
    						`wp_users`
  						WHERE
    						`id` = '$my_num'
					) AS `my_dept` ON `departament` = `dept`
				RIGHT OUTER JOIN
  					`r_tickets` ON `owner` = `wp_users`.`id`
				LEFT OUTER JOIN
  					(
  						SELECT
    						*
  						FROM
    						`r_task_log`
  						WHERE
    						`time_ok` = '$nw'
					) AS `r_task_log` ON `r_task_log`.`t_id` = `r_tickets`.`id`
				LEFT OUTER JOIN
  					`r_tickets_plan` ON `r_ticket` = `r_tickets`.`id`
				LEFT OUTER JOIN
  					(
  						SELECT
    						`r_tickets_comm`.`t_id`,
    						`r_tickets_comm`.`text`,
    						`r_tickets_comm`.`date`,
    						`wp_users`.`display_name` AS `autor`
  						FROM
    						`r_tickets_comm`
  						LEFT OUTER JOIN
    						`wp_users` ON `wp_users`.`ID` = `r_tickets_comm`.`autor`
					) AS `r_tickets_comm` ON `r_tickets_comm`.`t_id` = `r_tickets`.`id`
				WHERE
  					`".$today."` = '1'
				GROUP BY
					`display_name`,
    				`dept`,
  					`name`,
  					`time_ok`,
    				`r_tickets_plan`.`r_ticket`,
    				`r_tickets_plan`.`mon`,
					`r_tickets_plan`.`tue`,
    				`r_tickets_plan`.`wed`,
    				`r_tickets_plan`.`thu`,
    				`r_tickets_plan`.`fri`
            ";



          //echo $query;
        if($_COOKIE['all_task']=="show"){
            echo "checked";
        }
        
         $res = mysqli_query($db,$query);
         $tasks = "";
         while ($count = mysqli_fetch_assoc($res)) {
             $count['deadline'] = date('d.m.y');
             $tasks[] = $count;
         }
         $data[1] = $tasks;

         $query = "
             SELECT 
               `wp_users`.`id`, 
               `display_name`,
               `depts`.`name` 
             FROM 
               `wp_users`
             LEFT OUTER JOIN
             	`depts`
             ON 
             	`depts`.`id` = `departament`
             WHERE
             	`display_name`<>''
             AND
             	`depts`.`name` IS NOT NULL
             ";
         $res = mysqli_query($db, $query);
         $users = "";
         while ($count = mysqli_fetch_assoc($res)) {
             $users[array_pop($count)][] = $count;
         }

         $data[2] = $users;
        mysqli_close($db);

        return $data;
    }

    function save_data() {
        $db = conn_to_base();
        if (!$db) {
            echo "error of connect to db";
            return;
        }

        $t_name = $_GET['tn'];
        $t_id = $_GET['tid'];
        $t_owner = $_GET['town'];
        $t_autor = $_SESSION['user_num'];
        $t_mon = $_GET['tmon'];
        $t_tue = $_GET['ttue'];
        $t_wed = $_GET['twed'];
        $t_thu = $_GET['tthu'];
        $t_fri = $_GET['tfri'];
        $t_comm = $_GET['tcomm'];
        
        if ($t_id == 0) {

            $query = "
                INSERT INTO 
                    `r_tickets` 
                VALUES (
                    default,
                    '$t_name',
                    '$t_owner',
                    '$t_autor'
                    )
                    ";

            $res = mysqli_query($db,$query);
            if (!$res) {
                return;
            }

            $query = "SELECT LAST_INSERT_ID()";


            $res = mysqli_query($db, $query);
            $id = mysqli_fetch_array($res)[0];

            $query = "
                INSERT INTO 
                    `r_tickets_plan` 
                VALUES (
                    '$id',
                    '$t_mon',
                    '$t_tue',
                    '$t_wed',
                    '$t_thu',
                    '$t_fri'
                    )
                    ";
        }else{
            $query = "
                UPDATE 
                    `r_tickets` 
                SET 
                    `name`='$t_name',
                    `owner`='$t_owner' 
                WHERE 
                    `id`='$t_id'
                    ";

            mysqli_query($db,$query);
            $query = "
                UPDATE 
                    `r_tickets_plan` 
                SET 
                    `mon`='$t_mon',
                    `tue`='$t_tue',
                    `wed`='$t_wed',
                    `thu`='$t_thu',
                    `fri`='$t_fri'
                WHERE
                    `r_ticket`='$t_id'
                "; 
            mysqli_query($db,$query);
            
            mysqli_query($db,$query);
            
            if ($t_comm) {
                echo "comment ".$t_comm;
                $data = date('Y-m-d');
                $query = "
                INSERT INTO 
                    `r_tickets_comm` 
                VALUES (
                    '$t_id',
                    '$t_comm',
                    '$data',
                    '$t_autor'
                    )
                ";
                echo $query;
                mysqli_query($db,$query);
            }
        }

        mysqli_close($db);
    }

    function ok_task(){
        $db = conn_to_base();
        if (!$db) {
            echo "error of connect to db";
            return;
        }

        $t_id = $_GET['tid'];
        $data = date('Y-m-d');
        $query = "
            INSERT INTO
                `r_task_log`
            VALUES
                (
                    '$t_id',
                    '$data'
                )
            ";
        mysqli_query($db,$query);
        
        $query = "
        		SELECT
        			`name`,
        			`owner`,
        			`autor`
        		FROM
        			`r_tickets`
        		WHERE
        			`id`='$t_id'
        ";
        $res = mysqli_query($db,$query);
        while($count = mysqli_fetch_assoc($res)) {
        		$name = $count['name'];
        		$owner = $count['owner'];
        		$autor = $count['autor'];
        }
        $this->modmail = new Model_mail();
        $this->modmail->send_mess($owner, $autor, 'Task complite', "task $name complite", $db);
        mysqli_close($db);
    }

    function all_task() {
        $db = conn_to_base();
        if (!$db) {
            echo "error of connect to db";
            return;
        }
        $data[0] = get_main_menu();

        $today = strtolower(date('D'));
        $nw = date('Y-m-d');
        $my_num = $_SESSION['user_num'];

        $query = "
            SELECT
                `r_tickets`.`id`,
                `r_tickets`.`name`,
                `r_tickets`.`owner`,
                `r_tickets_plan`.`mon`,
                `r_tickets_plan`.`tue`,
                `r_tickets_plan`.`wed`,
                `r_tickets_plan`.`thu`,
                `r_tickets_plan`.`fri`,
                GROUP_CONCAT(
                    DISTINCT CONCAT_WS(
                        ':',
                        `r_tickets_comm`.`date`,
                        `r_tickets_comm`.`display_name`,
                        `r_tickets_comm`.`text`
                    ) SEPARATOR ';'
                ) AS `comm`
            FROM
                `r_tickets`
            LEFT OUTER JOIN
                `r_tickets_plan` ON `id` = `r_ticket`
            LEFT OUTER JOIN
                `r_task_log` ON `t_id` = `id`
            LEFT OUTER JOIN
                ( 
                    SELECT
                        `r_tickets_comm`.`t_id`,
                        `r_tickets_comm`.`text`,
                        `r_tickets_comm`.`date`,
                        `wp_users`.`display_name`
                    FROM
                        `r_tickets_comm`
                    LEFT OUTER JOIN
                        `wp_users`
                    ON `wp_users`.`ID`=`r_tickets_comm`.`autor`
                ) 
            AS `r_tickets_comm` ON `r_tickets_comm`.`t_id` = `id`
            WHERE
                `r_tickets`.`owner` = '$my_num'
            GROUP BY
                `r_tickets`.`id`,
                `r_tickets`.`name`,
                `r_tickets`.`owner`,
                `r_tickets_plan`.`mon`,
                `r_tickets_plan`.`tue`,
                `r_tickets_plan`.`wed`,
                `r_tickets_plan`.`thu`,
                `r_tickets_plan`.`fri`
        ";
        

        $res = mysqli_query($db,$query);
        $tasks = "";
        while ($count = mysqli_fetch_assoc($res)) {
            $count['deadline'] = date('d.m.y');
            $tasks[] = $count;
        }
        $data[1] = $tasks;

        $query = "
            SELECT 
                `id`, 
                `display_name` 
            FROM 
                `wp_users`
            ";
        $res = mysqli_query($db, $query);
        $users = "";
        while ($count = mysqli_fetch_assoc($res)) {
            $users[] = $count;
        }

        $data[2] = $users;
        mysqli_close($db);

        return $data;
    }

}
?>