<?php
class Controller_page_3 extends Controller{
    function __construct() {
        $this->model = new Model_page_3();
        $this->view = new View();
    }
            
    function action_index() {
        $data = $this->model->get_data();
        $this->view->generate('page_3_view.php','page_3_style.css', 'page_3.js','template_view.php',$data);
    }
    
    function action_new_data() {
        $this->model->new_data();
        $url = '?page_3';
        header("Location: $url");
    }
    
    function action_update_data() {
        $this->model->update_data();
        $url = '?page_3';
        header("Location: $url");
    }
    
    function action_del_data() {
        $this->model->del_data();
        $url = '?page_3';
        header("Location: $url");
    }
}
?>