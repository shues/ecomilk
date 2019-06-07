<div id="settings">
    <div class="menu_group">
        <div class="menu_button <?php if($_COOKIE['view_rej']=='stolbik'){echo 'active_menu_button';}?>" id="show_table" onclick="show_spis_of_ticket();">
            <div class="task_shape"></div>
            <div class="task_opis_shape"></div>
            <div class="task_shape"></div>
            <div class="task_opis_shape"></div>
            <div class="task_shape"></div>
            <div class="task_opis_shape"></div>
        </div>
        <div class="menu_button <?php if($_COOKIE['view_rej']=='plitka'){echo 'active_menu_button';}?>" id="show_plitka" onclick="show_plitka_of_ticket();">
            <div class="task_shape"></div>
            <div class="task_shape"></div>
            <div class="task_shape"></div>
            <div class="task_shape"></div>
            <div class="task_shape"></div>
            <div class="task_shape"></div>
        </div>
    </div>
    
    <div class="menu_group">
        <div class="menu_button <?php if($_COOKIE['order_by']=='priority'){echo 'active_menu_button';}?>" id="order_priority" onclick="order_ticket_by_priority();">
            <div class="alarm"></div>
        </div>
        <div class="menu_button <?php if($_COOKIE['order_by']=='deadline'){echo 'active_menu_button';}?>" id="order_deathline" onclick="order_ticket_by_deadline();">
            <div class="calendar"><div class="cal_day"></div></div>
        </div>
    </div>
    
    <div class="menu_group">
        <input id="active_checkbox" type="checkbox" onchange="show_active_ticket();" <?php if($_COOKIE['active_task']=='on'){echo 'checked';}?>> <span>Активные</span>
        <br>
        <input id="complite_checkbox" type="checkbox" onchange="show_complite_ticket();" <?php if($_COOKIE['complite_task']=='on'){echo 'checked';}?>> <span>Выполненные</span>
    </div>
    
    <div class="menu_group">
        <input id="for_me_checkbox" type="checkbox" onchange="show_ticket_for_me();" <?php if($_COOKIE['for_me_task']=='on'){echo 'checked';}?>> <span>Назначенные мне</span>
        <br>
        <input id="my_checkbox" type="checkbox" onchange="show_my_ticket();" <?php if($_COOKIE['my_task']=='on'){echo 'checked';}?>> <span>Назначенные мной</span>
    </div>
</div>