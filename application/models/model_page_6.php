<?php

class Model_page_6 extends Model{
    public function logout(){
        unset($_SESSION['user_id']);
        setcookie('login', '', 0);
        setcookie('password', '', 0);
        session_destroy();
    	echo "string_111";
    }
}
?>
