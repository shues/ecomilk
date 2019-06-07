<?php
require_once('./application/core/base.php');
class Model_page_2_3 extends Model{
       
    function get_data() {
        $db = conn_to_base();
        if (!$db) {
            echo "error of connect to db";
            return;
        }
        $data[0] = get_main_menu();        
        return $data;
    }
}
?>