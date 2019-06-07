<?php
$main_menu = $data[0];
if(!is_array($main_menu)){
    return;
}
foreach ($main_menu as $value) {
    $code = substr($value[0], strpos($value[0], "!") + 1, strlen($value[0]));
    $name = substr($value[0], 0, strpos($value[0], "!"));
    echo '<div id=' . $code;
    echo ' class="main_menu_item"';
    echo 'data-code=' . $code;
    echo ' onmouseenter="show_submenu(' . $code . ');"';
    echo 'onmouseleave="hide_submenu(' . $code . ');"';
    echo 'onclick="menu_event(' . $code . ');">';
    echo '<a href="?'.$code.'">'.$name.'</a>';
    if (count($value) > 1) {
        echo '<div class="sub_menu_conteiner">';
        foreach ($value as $subvalue) {
            $subcode = substr($subvalue, strpos($subvalue, "!") + 1, strlen($subvalue));
            if ($subcode != $code) {
                $subname = substr($subvalue, 0, strpos($subvalue, "!"));
                echo '<div id=' . $subcode . ' class="sub_menu_item" data-code=' . $subcode . ' >';
                echo '<a href="?'.$subcode.'">';
                echo $subname;
                echo '</a>';
                echo '</div>';
            }
        }
        echo '</div>';
    }
    echo "</div>";
}
?>