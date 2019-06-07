<div id="search-form">
    <h2>Озерецкое</h2>
    <input type="text" id="search_string" autofocus="true" placeholder="Поиск" onkeyup="search_string();"><br>
  <!--   Для использования этой страницы необходимо пройти <a href="">авторизацию.</a> -->
</div>

<table id="table_cont">
    <caption>Общие контакты</caption>
    <thead>
        <tr>
            <th>ФИО</th>
            <th>Должность</th>
            <th>Внутренний</th>
            <th>Мобильный</th>
            <th>Почта</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $contacts = $data[1];
        foreach ($contacts as $value) {
            if ($value['dept']!=$tek_dept) {
                echo '  
                    <tr id="dept_1">
                        <td class="dept_name" colspan="5">'.$value['dept'].'</td>
                    </tr>';
                $tek_dept = $value['dept'];
            }
            echo '<tr id='.$value['id'].' data-dept="'.$value['department'].'" onclick="change_content_page_3(this);">';
                echo '<td class="td_0">' . $value['fio'] . '</td>';
                echo '<td class="td_1">' . $value['role'] . '</td>';
                echo '<td class="td_2">' . $value['inner_phone'] . '</td>';
                echo '<td class="td_3">' . $value['mobile_phone'] . '</td>';
                echo '<td class="td_4">' . $value['email'] . '</td>';
            echo '</tr>';
        }
        ?>
    </tbody>
</table>