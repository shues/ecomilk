<?php
session_start();
class Route {

        //echo 'string';
    static function start() {
        // контроллер и действие по умолчанию
        $controller_name = 'page_1';
        $action_name = 'index';

        $routes = explode('?', $_SERVER['REQUEST_URI']);

        // получаем имя контроллера
        if (!empty($routes[1])) {
            $controller_name = $routes[1];
        }

        // получаем имя экшена
        if (!empty($routes[2])) {
            $action_name = $routes[2];
        }
        
        if(!isset($_SESSION['user_id'])){
            $controller_name = 'Autorization';
        }
        
        // добавляем префиксы
        $model_name = 'Model_' . $controller_name;
        $controller_name = 'Controller_' . $controller_name;
        $action_name = 'action_' . $action_name;

        // подцепляем файл с классом модели (файла модели может и не быть)

        $model_file = strtolower($model_name) . '.php';
        $model_path = "application/models/" . $model_file;
        if (file_exists($model_path)) {
            //echo $model_file;
            include "application/models/" . $model_file;
            
        }

        // подцепляем файл с классом контроллера
        $controller_file = strtolower($controller_name) . '.php';
        $controller_path = "application/controllers/" . $controller_file;
        if (file_exists($controller_path)) {
            //echo $controller_path;
            //echo $controller_file;
            include "application/controllers/" . $controller_file;
        } else {
            /*
              правильно было бы кинуть здесь исключение,
              но для упрощения сразу сделаем редирект на страницу 404
             */
            Route::ErrorPage404();
        }

        // создаем контроллер
        //echo $controller_name;
        $controller = new $controller_name;
        $action = $action_name;
        //echo "$action";

        if (method_exists($controller, $action)) {
            // вызываем действие контроллера
            $controller->$action();
        } else {
            // здесь также разумнее было бы кинуть исключение
            Route::ErrorPage404();
        }
    }

    function ErrorPage404() {
        $host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
        // header('HTTP/1.1 404 Not Found');
        // header("Status: 404 Not Found");
        header('Location: ?404');
    }

}

?>
