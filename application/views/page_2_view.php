<?php
$news = $data[1];

foreach ($news as $value) {
    $header = $value[0];
    $body = $value[1];
    $id = $value[2];

    echo '<div id=' . $id . ' class="news" onclick="change_content_page_1(this);">';
    echo "<h2>" . $header . "</h2>";
    echo '<p>' . $body . '</p>';
    echo '</div>';
}
?>

<div name="modW" class="shadow">
    <div id="modW" name="modW" class="modalW">
        <p>
            <input id="header" type="text">
        </p>
        <p>
            <textarea id="body"></textarea>
        </p>
        <a id="add" href="?page_1?new_data?"><button onmousedown="update_href_page_1(this);">ADD</button></a>
        <a id="save" href="?page_1?update_data?"><button onmousedown="update_href_page_1(this);">SAVE</button></a>
        <button onclick="hide_mod_win();">CANCEL</button>
        <a id="del" href="?page_1?del_data?"><button onmousedown="update_href_page_1(this);">DELETE</button></a>
    </div>
</div>