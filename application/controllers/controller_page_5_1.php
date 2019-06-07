<?php
class Controller_page_5_1 extends Controller{
    function __construct() {
        $this->model = new Model_page_5_1();
        $this->view = new View();
    }
    
    function action_index() {
        $data = $this->model->get_data();
        $this->view->generate('page_5_1_view.php','page_5_1_style.css','page_5_1.js','template_view.php',$data);
    }
}
?>
