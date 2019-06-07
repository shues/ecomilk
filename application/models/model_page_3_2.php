<?php

require_once('./application/core/base.php');

class Model_page_3_2 extends Model {

    public function get_data() {
        $db = conn_to_base();
        if (!$db) {
            echo 'error of db connection';
        }

        $main_menu = "";
        $query = "SELECT * FROM `main_menu` ORDER BY `code`";
        $res = mysqli_query($db, $query);
        $sch1 = 0;
        $sch2 = 1;
        while ($count = mysqli_fetch_assoc($res)) {
            if ($count['parent'] == 0) {
                $main_menu[$count['id']][0] = $count['name'] . "!" . $count['code'];
                $sch1++;
                $sch2 = 1;
            } else {
                $main_menu[$count['parent']][$sch2] = $count['name'] . "!" . $count['code'];
                $sch2++;
            }
        }

        $data[] = $main_menu;

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
                `d`.`name` AS `dept`
            FROM 
                `contacts` AS `c`
            LEFT OUTER JOIN
                `depts` AS `d`
            ON
                `d`.`id`=`c`.`department`
            WHERE 
                `inner_phone` 
            LIKE 
                '3%'
            ORDER BY 
                `dept`,
                `c`.`inner_phone`,
                `c`.`fio`,
                `c`.`id`,
                `c`.`role`,
                `c`.`mobile_phone`,
                `c`.`email`
        ";
        $res = mysqli_query($db, $query);
        
        while ($count = mysqli_fetch_assoc($res)) {
            $contacts[] = $count;
        }
        
        $data[] = $contacts;
        
        return $data;
    }

}

?>