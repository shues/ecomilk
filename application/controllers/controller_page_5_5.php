<?php
	class Controller_page_5_5 extends Controller{
		
    	function __construct() {
            $this->model = new Model_page_5_5();
            $this->view = new View();
        }
        
        function action_index() {            
            $data = $this->model->get_data();
            $this->view->generate('page_5_5_view.php','page_5_5_style.css','page_5_5.js','template_view.php',$data);
        }

         function action_save_task(){
             $this->model->save_data();
             $url = '?page_5_5';
             header("Location: $url");

         }

         function action_ok_task(){
             $this->model->ok_task();
             $url = '?page_5_5';
             header("Location: $url");
         }

         function action_all_task(){
            $data = $this->model->all_task();
            $this->view->generate('page_5_5_view.php','page_5_5_style.css','page_5_5.js','template_view.php',$data);
         }
	}
?>