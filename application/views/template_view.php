<?php
session_start();

?>
<!DOCTYPE html>
<html>
<head>
    <title>Корпоративный сайт</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/css/template.css"/>
    <link rel="stylesheet" href="/css/for_all.css"/>
    <link rel="stylesheet" href="/css/<?php echo $content_css; ?>"/>
    <script src="/js/template.js" type="text/javascript"></script>
    
</head>
<body onload="init_page();">
    <?php
    if(isset($_SESSION['user_id'])){
    	echo $uid;
        $uid = $_SESSION['user_id'];
        if(($uid == 'v.laptev@ecomilk.ru') or ($uid == 's.sudneko@ecomilk.ru') or ($uid == 'm.kovalevsky@ecomilk.ru') or ($uid == 'it@ecomilk.ru')){
            echo '<input type="checkbox" id="adminim" ';
            if ($_COOKIE['adminim']=='ok') {
                echo 'checked ';
            }
            echo 'onchange="reg_cook_adm(this);">';
        }
    }
    ?>
    <div id="main_pole">
        <img src="./images/logo_big2.png">
        <div id = "main_menu_conteiner">
            <?php require_once 'main_menu_view.php';?>
		</div>
        <?php include 'application/views/'.$content_view;?>
        <div id="footer" alt="Сайт сделан вручную :)">
            
        </div>
    </div>
</body>
<script src="/js/<?php echo $content_js; ?>" type="text/javascript"></script>
<html>

