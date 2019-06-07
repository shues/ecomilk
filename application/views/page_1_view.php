<?php
$news = $data[1];
 // echo "<pre>";
 // print_r($news);
 // echo "</pre>";
for ($i=count($news)-1; $i >= 0 ; $i--) { 
    $post = $news[$i];
    $date_str = substr($post['news_date'], 8) . '.' . substr($post['news_date'], 5, 2) . '.' . substr($post['news_date'], 0, 4);
    echo '<div id=' . $post['id'] . ' class="news" onclick="change_content_page_1(this);">';
    echo "<h2>" . $post['header'] . '  <i>'. $date_str.'</i>'. "</h2>";
    echo '<p>' . $post['news_body'] . '</p>';

    echo '</div>';
}

foreach ($news as $value) {
    
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