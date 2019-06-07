<?php
class Controller_page_2 extends Controller{
    function __construct() {
        $this->model = new Model_page_2();
        $this->view = new View();
    }

    function action_index() {
        $data = $this->model->get_data();
        $this->view->generate('page_2_view.php','page_1_style.css', 'page_1.js','template_view.php',$data);
    }

    function action_del_data() {
        $this->model->del_data();
        $url = '?page_2';
        header("Location: $url");
    }

    function action_new_data() {
        $this->model->new_data();
        $url = '?page_2';
        header("Location: $url");
    }

    function action_update_data() {
        $this->model->update_data();
        $url = '?page_2';
        header("Location: $url");
    }
}

?>
