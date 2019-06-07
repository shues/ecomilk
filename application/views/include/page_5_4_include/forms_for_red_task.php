<!--    это форма для редактирования задачи
    которая была создана, но еще не стартовала-->
<div id="red_new_task_form" class="task_red_form">
    <p id="ft_header_new">
        Здесь будет название задачи, имя хозяина задачи, имя исполнителя задачи, имя контролера задачи
    </p>
    <!--<div class="stolbik">-->
    <table>
    <tbody>
    <tr>
    <td>
        <label class="medium"> Срок выполнения:
            <br>
            <input id="ft_time_new" class="short" onchange="set_flag_of_change(this);">
        </label>
        
        <label class="medium"> Приоритет:
            <br>
            <select id="ft_priority_new" class="short" onchange="set_flag_of_change(this);">
                <option value="1">Высокий</option>
                <option value="2">Средний</option>
                <option value="3">Низкий</option>
            </select>
        </label>
        <br>
        <br>
        <label class="long">Новые комментарии к задаче:
            <br>
            <textarea id="ft_comment_new" class="long">                
            </textarea>
        </label>
    <!-- </div> -->
    </td>
    <td>

   <!--  <div class="stolbik"> -->
        <label class="long"> Описание и комментарии к задаче:
            <div id="ft_comments_bufer_new">
                тут будет описание задачи
            </div>
        </label>
    <!-- </div>         -->
    </td>
    </tr>
    </tbody>
    </table>
    <div class="button_section">
    <button id="close_button" onclick="close_form(this);">Отменить</button>
    <button id="del_button" onmousedown="update_del_href_page_5_4(this);">Удалить</button>
    <button id="save_button" onclick="update_save_href_task_page_5_4(this);">Сохранить</button>
    </div>
</div>

<!--    Это форма для добавления новой задачи-->
<div id="add_new_task_form" class="task_red_form">
    <p id="ft_header_add">
        <b><?php echo date('d.m.Y') . '  ' . $cun; ?></b>
    </p>
    <!--<div class="stolbik">-->
    <table>
    <tr>
    <td>
        <label class="long"> Название задачи:
            <br>
            <input id="ft_name" type="text" class="long" placeholder="Название задачи">
        </label>

        <br><br>

        <label class="long"> Описание и комментарии к задаче:
            <br>
            <textarea id="ft_opis" class="long">
                
            </textarea>
        </label>
    
    <!--</div>-->
    </td>
    <td>


    <!--<div class="stolbik">-->
    
        <label id="for_ft_time" for="ft_time" class="medium"> Срок выполнения:
            <br>
            <input id="ft_time" type="date" class="short" placeholder="Срок выполнения">
        </label>

        <label for="ft_priority" class="medium"> Приоритет:
            <br>
            <select id="ft_priority" class="short">
                <option value="1">Высокий</option>
                <option value="2">Средний</option>
                <option value="3">Низкий</option>
            </select>
        </label>
        <br>
        <br>
        <div id="members">
            <label for="ft_executor" class="short"> Исполнитель:</label>

            <select id="ft_executor" class="long">
                <?php
                   include './application/views/include/page_5_4_include/spiski_for_forms.php';
                ?>
            </select>

            <br>
            <br>
            <label for="ft_controller" class="short"> Контролер:</label>

            <select id="ft_controller" class="long">
                <?php
                   include './application/views/include/page_5_4_include/spiski_for_forms.php';
                ?>
            </select>

            <br>
            <br>
            <label for="ft_consultant" class="short"> Консультант:</label>                
            <select id="ft_consultant" class="long">
                <?php
                   include './application/views/include/page_5_4_include/spiski_for_forms.php';
                ?>
            </select>
        </div>
        
    <!--</div>-->
    </td>
    </tr>
    </table>
    <div class="button_section">
    <button id="set_task" onmousedown="update_href_page_5_4(this);">Назначить</button>
    <button onclick="close_form(this);">Отменить</button>
    </div>
</div>

<div id="shadow_page">
    
</div>