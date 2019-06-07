<?php
    $executors = $data[2];
    foreach ($executors as $value) {
        echo '<option value=' . $value[0] . '>' .  $value[1] . '</option>';
    }
?>
