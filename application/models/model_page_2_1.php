<?php
require_once('./application/core/base.php');
class Model_page_2_1 extends Model{

       
    function get_data() {
        $db = conn_to_base();
        if (!$db) {
            echo "error of connect to db";
            return;
        }
        $data[0] = get_main_menu();
        //print_r($data[0]);

        $query = "
            SELECT 
                `rooms`.`name` as `dept`,
                `ip`,
                `login`,
                `password`,
                `printer_firma`.`name`,
                `printer_model`.`model`
            FROM
                `printers`
            Left outer join 
                `rooms` 
            ON 
                `rooms`.`id` = `printers`.`room`
            Left outer join 
                `printer_firma` 
            ON 
                `printer_firma`.`id` = `printers`.`firma`
            left outer join 
                `printer_model` 
            ON 
                `printer_model`.`id` = `printers`.`model`
            ORDER BY `dept`
            ";
        $res = mysqli_query($db,$query);
        while ($count = mysqli_fetch_assoc($res)) {
            $data['spis'][] = $count;
        }

        $query = "
            SELECT
                *
            FROM
                `rooms`
        ";

        $res = mysqli_query($db,$query);
        while ($count = mysqli_fetch_assoc($res)) {
            $data['rooms'][] = $count;
        }

        $query = "
            SELECT
                *
            FROM
                `printer_firma`
        ";

        $res = mysqli_query($db,$query);
        while ($count = mysqli_fetch_assoc($res)) {
            $data['firms'][] = $count;
        }

        $query = "
            SELECT
                *
            FROM
                `printer_model`
        ";

        $res = mysqli_query($db,$query);
        while ($count = mysqli_fetch_assoc($res)) {
            $data['models'][] = $count;
        }

        return $data;
    }

    function add_printer(){
        $db = conn_to_base();
        if (!$db) {
            echo "error of connect to db";
            return;
        }

        $dept = $_GET['dept'];
        $ip = $_GET['ip'];
        $login = $_GET['login'];
        $password = $_GET['password'];
        $firma = $_GET['firma'];
        $model = $_GET['model'];

        $query = "
            INSERT INTO
                `printers`
            VALUES
                (
                    default,
                    '$firma',
                    '$model',
                    '$dept',
                    '$ip',
                    '$login',
                    '$password'
                )
        ";

        mysqli_query($db, $query);
        mysqli_close($db);
    }

}
?>