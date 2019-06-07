<?php
	class Controller_page_2_3 extends Controller{
        function __construct() {
            $this->model = new Model_page_2_3();
            $this->view = new View();
        }
    
        function action_index() {
            $data = $this->model->get_data();
            //print_r($data[0]);
            $this->view->generate('page_2_3_view.php','page_2_2_style.css','page_2_2.js','template_view.php',$data);
        }
	}
?>