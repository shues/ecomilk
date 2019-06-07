<?php
class Controller_page_5_2 extends Controller{
    function __construct() {
        $this->model = new Model_page_5_2();
        $this->view = new View();
    }
    
    function action_index() {
        $data = $this->model->get_data();
    	//echo "string";
        $this->view->generate('page_5_2_view.php','page_5_2_style.css','page_5_2.js','template_view.php',$data);
    }

    function action_like(){
    	$this->model->like_img();
    	$url = '?page_5_2';
    	header('location: '.$url);
    }
}
?>
