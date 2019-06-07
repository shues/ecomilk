<?php

require_once('./application/core/base.php');

class Model_page_3_3 extends Model {

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
        $query = "SELECT * FROM `contacts` WHERE `inner_phone` LIKE '2%' ORDER BY `inner_phone`, `fio`";
        $res = mysqli_query($db, $query);
        $sch1 = 0;
        $sch2 = 0;
        while ($count = mysqli_fetch_array($res)) {
            $contacts[$sch1][$sch2] = $count[1];
            $sch2++;
            $contacts[$sch1][$sch2] = $count[2];
            $sch2++;
            $contacts[$sch1][$sch2] = $count[3];
            $sch2++;
            $contacts[$sch1][$sch2] = $count[4];
            $sch2++;
            $contacts[$sch1][$sch2] = $count[5];
            $sch1++;
            $sch2 = 0;
        }
        
        $data[] = $contacts;
        
        return $data;
    }

}

?>