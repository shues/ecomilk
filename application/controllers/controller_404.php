<?php
class Controller_404 extends Controller{
	function __construct() {
        $this->model = new Model_404(); //работа с сервером и бд
        $this->view = new View();		// показ страницы
    }
            

	// Метод просто выводит страницу ошибки 404
    function action_index() {
    	$data = $this->model->get_data(); //Забрать необходимые данные с сервера
        $this->view->generate('404_view.php','page_404_style.css','404.js','template_view.php',$data);
    }
}
?>