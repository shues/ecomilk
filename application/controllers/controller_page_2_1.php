<?php
	/**
	* 
	*/
	class Controller_page_2_1 extends Controller{
		
    	function __construct() {
            $this->model = new Model_page_2_1();
            $this->view = new View();
        }
        
        function action_index() {
            $data = $this->model->get_data();
            $this->view->generate('page_2_1_view.php','page_2_1_style.css','page_2_1.js','template_view.php',$data);
        }

        function action_add_printer(){
            $this->model->add_printer();
            $url = '?page_2_1';
            header("Location: $url");
        }
	}
?>