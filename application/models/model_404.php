<?php

require_once('./application/core/base.php');

class Model_404 extends Model {

    public function get_data() {
        $db = conn_to_base();
        if (!$db) {
            echo "error of connect to db";
            return;
        }
        $data[0] = get_main_menu();
        
        mysqli_close($db);
        return $data;
    }
    

}

?>