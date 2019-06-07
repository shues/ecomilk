<?php
class Controller_page_3_2 extends Controller{
    function __construct() {
        $this->model = new Model_page_3_2();
        $this->view = new View();
    }
            
    function action_index() {
        $data = $this->model->get_data();
        $this->view->generate('page_3_2_view.php','page_3_2_style.css','page_3.js','template_view.php',$data);
    }
}
?>