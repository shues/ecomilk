<?php

require_once('./application/core/base.php');

class Model_page_1 extends Model {

    public function get_data() {
        $db = conn_to_base();
        if (!$db) {
            echo "error of connect to db";
            return;
        }
        $data[0] = get_main_menu();
        
        $query = "
            SELECT 
                * 
            FROM 
                `news_table`
            ";

        $res = mysqli_query($db, $query);
        $news;
        while ($row = mysqli_fetch_assoc($res)) {
            $news[] = $row;
        }
        
        $data[] = $news;
        
        mysqli_close($db);
        return $data;
    }
    
    public function del_data() {
        $db = conn_to_base();
        if (!$db) {
            echo "error of connect to db";
            return;
        }
        
        $id = $_GET['id'];
        $query = "
            DELETE FROM 
                `news_table` 
            WHERE 
                `id`='$id'
            ";

        $res = mysqli_query($db, $query);
        
        mysqli_close($db);
    }
    
    public function new_data() {
        $db = conn_to_base();
        if (!$db) {
            echo "error of connect to db";
            return;
        }
        $header = $_GET['header'];
        $body = $_GET['body'];
        $date_mass = getdate();
        $date_str = $date_mass['year'].'-'.$date_mass['mon'].'-'.$date_mass['mday'];
        //echo $header;
        //echo $body;
        //echo $date_str;
        $query = "
            INSERT INTO 
                `news_table` 
            VALUES
                (
                    default,
                    '$header',
                    '$body',
                    '$date_str'
                )
            ";
        
        $res = mysqli_query($db, $query);
        
        mysqli_close($db);
    }
    
    public function update_data() {
        $db = conn_to_base();
        if (!$db) {
            echo "error of connect to db";
            return;
        }
        
        $id = $_GET['id'];
        $header = $_GET['header'];
        $body = $_GET['body'];
        $date_mass = getdate();
        $date_str = $date_mass['year'].'-'.$date_mass['mon'].'-'.$date_mass['mday'];
        $query = "
            UPDATE 
                `news_table` 
            SET 
                `header`='$header',
                `news_body`='$body', 
                `news_date`='$date_str' 
            WHERE 
                `id`='$id'
                ";
                
        $res = mysqli_query($db, $query);
        
        mysqli_close($db);
    }

}

?>