<?php
// Контроллер главной страницы
class Controller_page_1 extends Controller{
    function __construct() {
        $this->model = new Model_page_1();	// работа с бд
        $this->view = new View();			//Отображение данных на экране
    }
    // Запускается в первую очередь
    function action_index() {
        $data = $this->model->get_data();	// получает данные с сервера
        //echo $data;
        // выводит страницу
        $this->view->generate('page_1_view.php',
        					'page_1_style.css', 
        					'page_1.js',
        					'template_view.php',
        					$data);
    }
    
    // Удалить пост
    function action_del_data() {
        $this->model->del_data();		//удалить пост из базы
        $url = '?page_1';			//Обновить страницу
        header("Location: $url");
    }
    
    // Добавить пост
    function action_new_data() {
        $this->model->new_data();
        $url = '?page_1';
        header("Location: $url");
    }
    
    // Обновить пост
    function action_update_data() {
        $this->model->update_data();
        $url = '?page_1';
        header("Location: $url");
    }
}
?>
