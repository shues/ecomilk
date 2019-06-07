<?php

require_once('./application/core/base.php');

class Model_autorization extends Model {

    public function get_data() {
        // проверка куки
        //echo 'string';
        if (isset($_COOKIE['login'])) {
            $login = $_COOKIE['login'];
            $db = conn_to_base();
            $query = "
            	SELECT
            		`password`
            	FROM
            		`autorization`
            	WHERE
            		`login`='$login'
            ";
            echo $query;
            $res = mysqli_query($db,$query);
        		$buf = mysqli_fetch_assoc($res);
        		print_r($buf);
        		$num = $buf['password'];
        		echo $num;
            if($num == '') {
            	return 'unknown_user';
            }else {
            	$buf = mysqli_fetch_assoc($res);
            	$password = $buf['password'];
            }
            
          //  $password = $_COOKIE['password'];
        } else {
            // если куки нет, то спросим как же зовут пользователя
            return 'unknown_user';
        }
        // отправка данных на сервер для проверки
        $res = $this->send_ldap_request($login, $password);
        return $res;
    }

    public function input() {
        $login = $_POST['login'];
        $password = $_POST['password'];
        $res = $this->send_ldap_request($login, $password);
        return $res;
    }

    public function output(){
        unset($_SESSION['user_id']);
        setcookie('login', '', 0);
        //setcookie('password', '', 0);
        session_destroy();
        //echo "string_111";
    }

    private function send_ldap_request($log, $pass) {
        $ldaphost = "192.168.1.23";
        $ldapport = "389";
        $login = $log;
        $password = $pass;
        $log_name = urldecode($login);
        $ldap = ldap_connect($ldaphost, $ldapport);
        //echo ldap_error($ldap);
        if ($ldap) {
            
            $bind = ldap_bind($ldap, $login, $password);
            //echo $bind;
            if ($bind) {
            //echo $login;
                if ($login == '') {
                //    return "bind_false";
                }

                $_SESSION['user_id'] = $login;
                setcookie('login', $login, time() + (3600 * 24 * 365));
                $db = conn_to_base();
        			 if (!$db) {
            		echo 'error of connect to db';
        			 }
        			 $query = "
        			 	SELECT
        			 		COUNT(`login`)
        			 	FROM
        			 		`autorization`
        			 	WHERE
        			 		`login`='$login'
        			 ";
        			 $res = mysqli_query($db,$query);
        			 $buf = mysqli_fetch_array($res);
        			 $num = $buf[0];
        			 //echo $num;
        			 if($num != 0) {
        			 	if($password!='') {
                	$query = "
                		UPDATE
                			`autorization`
                		SET
                			`password`='$password'
                		WHERE
                			`login`='$login'
                	";
                	$res = mysqli_query($db,$query);
                	}
                }
                else {
                	$query = "
                		INSERT INTO
                			`autorization`
                		VALUES(
                			'$login',
                			'$password')
                	";
                	mysqli_query($db,$query);
                }
        //        setcookie('password', $password, time() + (3600 * 24 * 365));

                return $this->get_user_name($log_name);
            } else {
//                return "bind_false";
                return "test";
            }
        }
    }

    private function get_user_name($param) {
        $db = conn_to_base();
        if (!$db) {
            echo 'error of connect to db';
        }
        if (strpos($param, '@')) {
            $param = substr($param, 0, strpos($param, '@'));
        }

        $query = "SELECT `id`, `display_name` FROM `wp_users` WHERE `user_login`='$param'";

        $res = mysqli_query($db, $query);
        $name = mysqli_fetch_array($res);
        if (mysqli_num_rows($res)==0) {
            $param1 = $param.'@ecomilk.ru';
            $dat = date('Y-m-d H:m:s');
            $query = "
                INSERT INTO
                    `wp_users`(
                        `id`,
                        `user_login`,
                        `user_email`,
                        `user_registered`
                    )
                VALUES
                    (
                        default,
                        '$param',
                        '$param1',
                        '$dat'
                    )

            ";
            echo $query;
            mysqli_query($db,$query);
        }
        $_SESSION['user_num'] = $name[0];
        return $name[1];
    }

}

?>
