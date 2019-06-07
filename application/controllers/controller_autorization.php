<?php
// Получает разрешение на доступ к сайту
class Controller_Autorization extends Controller{
    function __construct() {
        $this->model = new Model_autorization();	// работа с сервером и бд
        $this->view = new View();				// показывает страницу
    }
    // Вызвается в первую очередь
    function action_index() {
        $data = $this->model->get_data();	//Получить информацию о пользователе
	   $this->select_action($data);        
    }
    
    // Пользователь ввел логин и пароль на странице авторизации
    function action_input() {
        $data = $this->model->input();
        $this->select_action($data);
    }
    // Пользователь нажал кнопку выхода
    function action_output() {
        $data = $this->model->output();
        header('Location: ?page_1?');// проверка, пользователь должен быть перемещен на страницу авторизации а не на главную страницу
    }
    
    // Определимся, куда отправить пользователя
    function select_action($data) {
    		if ($data == "bind_false" || $data == "unknown_user"){	//Пользователь не идентифицирован
        												// предложим ему ввести свои данные
          	$this->view->generate(	'autorization_view.php',
            						'autorization_style.css',
            						'autorization.js',
            						'template_view.php',
            						$data);
        	}else{											// Этот пользователь известен
          	header('Location: ?page_1?');
        	}
    }
}
?>
