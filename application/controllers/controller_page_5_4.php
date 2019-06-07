<?php
class Controller_page_5_4 extends Controller{
    function __construct() {
        $this->model = new Model_page_5_4();
        $this->view = new View();
    }
    
    function action_index() {
        $data = $this->model->get_data();
        $this->view->generate('page_5_4_view.php','page_5_4_style.css','page_5_4.js','template_view.php',$data);
    }
    
    function action_add_ticket(){
        echo "string";
        $this->model->add_ticket();
		//$this->action_index();
        $url = '?page_5_4';
        header("Location: $url");
    }
    
    function action_del_ticket(){
        $this->model->del_ticket();
        $url = '?page_5_4';
        header("Location: $url");
		//$this->action_index();
    }
    
    function action_save_ticket() {
        $this->model->save_ticket();
        //$url = '?page_5_4';
        //header("Location: $url");
		$this->action_index();
    }
    
    function action_start_ticket() {
        $this->model->start_ticket();
        //$this->action_index();
        $url = '?page_5_4';
        header("Location: $url");
    }
    
    function action_ok_ticket() {
        $this->model->ok_ticket();
        //$this->action_index();
        $url = '?page_5_4';
        header("Location: $url");
    }
    
    function action_pause_ticket() {
        $this->model->pause_ticket();
        //$this->action_index();
        $url = '?page_5_4';
        header("Location: $url");
    }
    
    function action_send_ticket() {
        $this->model->send_ticket();
        //$this->action_index();
        $url = '?page_5_4';
        header("Location: $url");
    }
	
	function action_test(){
		$this->model->test();
	}
}
?>
