<?php

require_once('./application/core/base.php');

class Model_page_3 extends Model {

    public function get_data() {
        $db = conn_to_base();
        if (!$db) {
            echo 'error of db connection';
        }

        $data[0] = get_main_menu();

        $contacts;
        $query = "
            SELECT 
                `c`.`id`,
                `c`.`fio`,
                `c`.`role`,
                `c`.`inner_phone`,
                `c`.`mobile_phone`,
                `c`.`email`,
                `c`.`department`,
                `d`.`name` AS `dept`,
                `d`.`boss` AS `boss`
            FROM 
                `contacts` AS `c`
            LEFT OUTER JOIN
                `depts` AS `d`
            ON
                `d`.`id`=`c`.`department`
            ORDER BY 
                `dept`,
                `boss`,
                `c`.`inner_phone`,
                `c`.`fio`,
                `c`.`id`,
                `c`.`role`,
                `c`.`mobile_phone`,
                `c`.`email`
        ";
        //echo $query;

        $res = mysqli_query($db, $query);
        while ($count = mysqli_fetch_assoc($res)) {
            $contacts[] = $count;
        }
        $data[] = $contacts;


        $query = "
            SELECT 
                * 
            FROM 
                `depts`
            ";

        $res = mysqli_query($db, $query);
        $i = 0;
        while ($count = mysqli_fetch_assoc($res)) {
            $depts[$i]['id'] = $count['id'];
            $depts[$i]['name'] = $count['name'];
            $i++;
        }
        $data[] = $depts;
        return $data;
    }
    
    public function new_data() {
        $db = conn_to_base();
        if (!$db) {
            echo "error of connect to db";
            return;
        }
        
        $fio = $_GET['fio'];
        $role = $_GET['role'];
        $inner_phone = $_GET['inner_phone'];
        $mobile_phone = $_GET['mobile_phone'];
        $email = $_GET['email'];
        $dept = $_GET['dept'];

        $query = "
            INSERT INTO 
                `contacts` (
                    `id`,
                    `fio`,
                    `role`,
                    `inner_phone`,
                    `mobile_phone`,
                    `email`,
                    `department`
                )
            VALUES
                (
                default,
                '$fio',
                '$role',
                '$inner_phone',
                '$mobile_phone',
                '$email',
                '$dept'
                )";
        echo $query;
        $res = mysqli_query($db, $query);
        
        mysqli_close($db);
    }
    
    public function update_data(){
        $db = conn_to_base();
        if (!$db) {
            echo "error of connect to db";
            return;
        }
        
        $id = $_GET['id'];
        $fio = $_GET['fio'];
        $role = $_GET['role'];
        $inner_phone = $_GET['inner_phone'];
        $mobile_phone = $_GET['mobile_phone'];
        $email = $_GET['email'];
        $dept = $_GET['dept'];
        $boss = $_GET['boss'];

        $query = "
            UPDATE 
                `contacts` 
            SET 
                `fio`='$fio', 
                `role`='$role', 
                `inner_phone`='$inner_phone', 
                `mobile_phone`='$mobile_phone', 
                `email`='$email',
                `department`='$dept'
            WHERE 
                `id`='$id'";
            echo $query;
        $res = mysqli_query($db, $query);
        
        if($boss) {
        		$query = "
        			UPDATE
        				`depts`
        			SET
        				`boss`='$id'
        			WHERE
        				`id`='$dept'
        		";
        		mysqli_query($db, $query);
        }
        mysqli_close($db);
    }
    
    public function del_data(){
        $db = conn_to_base();
        if (!$db) {
            echo "error of connect to db";
            return;
        }
        
        $id = $_GET['id'];
        $query = "DELETE FROM `contacts` WHERE `id`='$id'";
        $res = mysqli_query($db, $query);
        
        mysqli_close($db);
    }
}

?>