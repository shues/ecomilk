<?php
require_once('./application/core/base.php');
class Model_page_5_1 extends Model{

    var $user;
    var $db_wp, $db_1c;

    function __construct() {
        $this->db_wp = new PDO('mysql:host=localhost;dbname=wordpress612', 'root', 'dontcare161211');
        $this->db_1c = new PDO('mysql:host=localhost;dbname=my1c', 'root', 'dontcare161211');

        // $stmt=$this->db_wp2->prepare("SELECT * FROM wp_users");
        // $stmt->execute();
        // $rs=$stmt->fetchAll();
        // print_r( $rs);
    }
    
        
    function authorize() {
        ?>	
        <center>
            <form method='post' action='http://wc.ecomilk.ru/?page_id=492'>
                <table style='width:250px'>
                    <tr><td>login: </td><td><input style='width:160px' type='text' name='buyer_login'></td></tr>
                    <tr><td>password: </td><td><input style='width:160px' type='text' name='buyer_password'></td></tr>
                    <tr><td colspan="2"><input type='hidden' name='action' value='authorization'>
                    <center><input style='width:230px' type='submit' value="войти"></td></tr></center>
                </table>
        </center>	
        <?php

    }

    function chekAuthorization() {


        $buyer_login = mysql_real_escape_string(trim($_POST['buyer_login']));
        $buyer_password = mysql_real_escape_string(trim($_POST['buyer_password']));

        if (strlen($buyer_login) == 0 || strlen($buyer_password) == 0) {
            echo "НЕ ЗАДАН ЛОГИН ИЛИ ПАРОЛЬ";
            exit;
        }

        $stmt = $this->db_1c->prepare("SELECT buyer_password FROM buyers WHERE buyer_login='$buyer_login'");
        $stmt->execute();
        $res = $stmt->fetchAll();
        if (count($res) > 1) {
            echo "Что то пошло не так ВАС БОЛЬШЕ ОДНОГО В СИСТЕМЕ";
            exit;
        } elseif (count($res) == 0) {
            echo "ПОЛЬЗОВАТЕЛЯ $buyer_login НЕТ В СИСТЕМЕ";
            exit;
        } else {
            if (md5($buyer_password) == $res[0][0]) {
                $_SESSION['ses_buyer_login'] = $buyer_login;
                echo "АВТОРИЗАЦИЯ $buyer_login ПРОШЛА УСПЕШНО!!!! " . $_SESSION['ses_buyer_login'];
                echo "<br/><a href='http://wc.ecomilk.ru/?page_id=492'>проверка</a>";
            } else {
                echo "<br>!!!! Не правильный пароль";
            }
        }
    }

    function printAdminMenu() {
        $html = '';
        $stmt = $this->db_1c->prepare("SELECT * FROM buyers $html");
        $stmt->execute();
        $html = "<form method='post' action='http://wc.ecomilk.ru/?page_id=495'><select name='buyer_id'>";

        while ($res = $stmt->fetch()) {
            //print_r($res);
            $html = $html . "<option value='" . $res['id'] . "'>" . $res['name'] . "</option>";
        }
        $html = $html . "</select><table style='width:250px'>
			<tr><td>login: </td><td><input style='width:160px' type='text' name='buyer_login'></td></tr>
			<tr><td>password: </td><td><input style='width:160px' type='text' name='buyer_password'></td></tr>
			<tr><td colspan='2'><input type='hidden' name='action' value='buyer_edit'>
			<center><input style='width:230px' type='submit' value='Сохранить'></td></tr></center>
				</table></form>";

        return $html;
    }

    function saveAccount() {

        $buyer_login = mysql_real_escape_string(trim($_POST['buyer_login']));
        $buyer_password = mysql_real_escape_string(trim($_POST['buyer_password']));
        $buyer_id = mysql_real_escape_string(trim($_POST['buyer_id']));

        if (strlen($buyer_login) == 0 || strlen($buyer_password) == 0) {
            echo "НЕ ЗАДАН ЛОГИН ИЛИ ПАРОЛЬ" . $buyer_login . " - " . $buyer_password;
            exit;
        }
        $hashstr = md5($buyer_password);

        $stmt = $this->db_1c->prepare("UPDATE buyers SET buyer_login='$buyer_login', buyer_password='$hashstr' WHERE id='$buyer_id'");
        if (!$stmt->execute()) {
            echo "ВНИМАНИЕ ПАРОЛЬ НЕ СОХРАНИЛСЯ";
            exit;
        } else {
            echo "ALL OK";
        }
    }

    function printNewOrder($buyer_login) {
        $html = "<form method='post' action='http://wc.ecomilk.ru/?page_id=492'>
		<input type='hidden' name='buyer_login' value='" . $buyer_login . "'>
		<label for='order_date'>Дата заказа: </label><input type='date' name='order_date' id='order_date' value='" . date('Y-m-d') . "'>
		<label for='order_number'>Номер заказа: </label><input type='input' name='order_number' id='order_number' style='width:40px'>
		<table class='order' style='width:550px;padding:0px'><tr><td>Номенклатура</td><td>Кол-во</td><td>Ед.</td><td>Цена</td><td>Сумма</td></tr>";

        $stmt = $this->db_1c->prepare("SELECT t1.tovar id, t1.tovar_name name,t2.unit_name, t2.price price FROM tovar_matrix As t1 LEFT JOIN price_list AS t2 ON (t1.tovar=t2.tovar)" .
                " WHERE t1.buyer IN (SELECT id from buyers where buyer_login='$buyer_login') AND " .
                " t2.price_type IN (SELECT price_type from contracts WHERE buyer IN (SELECT id from buyers where buyer_login='$buyer_login') AND main=1) ORDER  BY name");


        $stmt->execute();

        while ($res = $stmt->fetch()) {
            $html = $html . "<tr class='order_list_item' id='" . $res['id'] . "'><td>" . $res['name'] . "</td><td><input  type='text' style='width:40px'  id='count-" . $res['id'] . "'/></td><td>" . $res['unit_name'] .
                    "</td><td id='price-" . $res['id'] . "'>" . $res['price'] . "</td><td><input id='summ-" . $res['id'] . "'  type='text' style='width:40px' disabled /></td></tr>";
        }
        $html = $html . "</table><input type='submit' id='submit_order'></form>";
        return $html;
    }
    
    function get_data() {
        $buyer_login = 'akkord';
        $db = conn_to_base();
        if (!$db) {
            echo 'error of db connection';
        }

        $data[0] = get_main_menu();
        
        $stmt = $this->db_1c->prepare("SELECT t1.tovar id, t1.tovar_name name,t2.unit_name, t2.price price FROM tovar_matrix As t1 LEFT JOIN price_list AS t2 ON (t1.tovar=t2.tovar)" .
                " WHERE t1.buyer IN (SELECT id from buyers where buyer_login='$buyer_login') AND " .
                " t2.price_type IN (SELECT price_type from contracts WHERE buyer IN (SELECT id from buyers where buyer_login='$buyer_login') AND main=1) ORDER  BY name");


        $stmt->execute();
        
        while ($res = $stmt->fetch()) {
            $mas_res[] = $res;
        }        
        $data[1] = $mas_res;
        return $data;
    }

}
?>