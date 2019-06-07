<div id="search-form">
    <h2>Контакты</h2>
    <input type="text" id="search_string" autofocus="true" placeholder="Поиск" onkeyup="search_string();"><br>
    <!-- Для использования этой страницы необходимо пройти <a href="">авторизацию.</a> -->
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
          // echo '<pre>';
          // print_r($data[1]);
          // echo '</pre>';
        $tek_dept = '';
        
        foreach ($contacts as $value) {
            if ($value['dept']!=$tek_dept) {
                echo '  
                    <tr id="dept_'.$value['department'].'">
                        <td class="dept_name" colspan="5">'.$value['dept'].'</td>
                    </tr>';
                $tek_dept = $value['dept'];
            }
            echo '<tr id='.$value['id'].' data-dept="'.$value['department'].'" data-boss="'.$value['boss'].'" onclick="change_content_page_3(this);">';
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

<div name="modW" class="shadow">
    <div id="modW" name="modW" class="modalW">
        <p>
            ФИО: <input id="fio" type="text">
        </p>
        <p>
            Роль: <input id="role" type="text">
        </p>
        <p>
            Внутр. тел: <input id="inner_phone" type="text">
        </p>
        <p>
            Моб. тел: <input id="mobile_phone" type="text">
        </p>
        <p>
            Почта: <input id="Email" type="text">
        </p>
        <p>
            Отдел: <select id="dept">
                <option value="0">...</option>
                <?php
                    $depts = $data[2];
                    foreach ($depts as $value) {
                        echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';
                    }
                ?>
            </select>
        </p>
        <p>
        		Boss: <input id="boss_flag" type="checkbox">
        </p>
        <a href="?page_3?new_data?"><button onmousedown="update_href_page_3(this);">ADD</button></a>
        <a href="?page_3?update_data?"><button onmousedown="update_href_page_3(this);">SAVE</button></a>
        <button onclick="hide_mod_win();">CANCEL</button>
        <a href="?page_3?del_data?"><button onmousedown="update_href_page_3(this);">DELETE</button></a>
    </div>
</div>