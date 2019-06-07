<?php
/**
 * @return mysqli|null
 */
function conn_to_base() {
    $db = mysqli_connect("localhost", "root", "root", 'corpecomilk');
    if (!$db) {
        $db = null;
    }
    
    mysqli_set_charset($db,"utf8");
    return $db;
}

function get_main_menu() {
    $db = conn_to_base();
    $main_menu = "";
    $query = "SELECT * FROM `main_menu` ORDER BY `code`";
    $res = mysqli_query($db, $query);
    $sch1 = 0;
    $sch2 = 1;
    while ($count = mysqli_fetch_assoc($res)) {
        if ($count['parent'] == 0) {
            $main_menu[$count['id']][0] = $count['name'] . "!" . $count['code'];
            $sch1++;
            $sch2 = 1;
        } else {
            $main_menu[$count['parent']][$sch2] = $count['name'] . "!" . $count['code'];
            $sch2++;
        }
    }
    return $main_menu;
}

?>
