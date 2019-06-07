<?php
class Controller_page_6 extends Controller{
    function __construct() {
    	echo "constr";
        $this->model = new Model_page_6();
        $this->view = new View();
    }
            
    function action_index() {
    	echo "string";
        $this->model->logout();
        $url = '?page_1';
        header("Location: $url");
    }
}
?>