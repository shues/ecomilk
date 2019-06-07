var flag_for_deadline = 0;
var rejim;

// Функция обрабатывает открытие формы для редактирования задачи
function not_start_task(id) {
    // Сначала прячем образ задачи, и встраиваем в нужное место форму редактирования
    var task_obj = document.getElementById(id); //Получим объект задачи
    var task_cont = task_obj.parentElement;     //Контейнер задачи
    var task_opis = task_cont.children[1];      //Контейнер описания задачи
    var parent = task_cont.parentElement;       //Родитель контейнера - глобальный контейнер

    var task_form = document.getElementById('red_new_task_form');//    выбираем форму с которой будем работать
    var shadow = document.getElementById('shadow_page');

    //parent.insertBefore(task_form, task_cont);  // поставим форму на нужное место.
	//task_cont.appendChild(task_form);
    task_form.style.display = "block";          // Покажем форму редактирования задачи
    shadow.style.display = "block";
    //task_obj.style.display = "none";            // Спрячем образ задачи
    //task_opis.style.display = "none";           // Спрячем описание задачи
    //task_cont.style.height = 2 + "px";          // Изменим высоту контейнера задачи
	//task_cont.style.width = "auto";
	//task_cont.style.height = "auto";

    // Убираем у других образов задач возможность открыть форму.
    // var spis = document.getElementsByClassName('task');
    // for (var i = 0; i < spis.length; i++) {
    //     spis[i].onclick = null;
    // }
    // Переносим данные задачи на форму                 

    var task_owner = task_obj.children[9].textContent;          //Хозяин задачи
    var start_date = task_obj.children[10].textContent;         //Дата старта задачи
    var task_name = task_obj.children[7].textContent;           //Название задачи
    var task_deadline = task_obj.children[5].textContent;       //Срок окончания задачи
    var task_value = task_opis.innerHTML; //Описание и комментарии к задаче
    var execut = task_obj.getAttribute('data-executor');        // номер исполнителя
    var task_priority = task_obj.getAttribute('data-priority');
    var exec_spis = document.getElementsByTagName('option');
//    for (i = 0; i < exec_spis.length; i++) {
//        if (exec_spis[i].value == execut) {
//            var execut_name = exec_spis[i].textContent;
//        }
//    }
    var obj_id = task_obj.id;                                   //Получим номер задачи

    var header = document.getElementById('ft_header_new');
    header.innerHTML = 'Задача: <b>' + task_name + '</b> от <b>' + start_date + '</b>    Автор: <b>' + task_owner + '</b> Исполнитель: <b>' + execut + '</b>';
    task_form.setAttribute('data-obj_id', obj_id);
    var form_deadline = document.getElementById('ft_time_new');
    form_deadline.value = task_deadline;

    var form_priority = document.getElementById('ft_priority_new');
    for (var i = 0; i < form_priority.children.length; i++) {
        if (form_priority.children[i].value == task_priority) {
            form_priority.children[i].selected = true;
        }
    }
    var form_value = document.getElementById('ft_comments_bufer_new');
    form_value.innerHTML = task_value;

    var comment = document.getElementById('ft_comment_new');
    comment.value = '';
    comment.autofocus = 'true';
}

//Открываем форму редактирования новой задачи
function new_task(id) {
    //alert(document.cookie);
    // Сначала прячем образ задачи, и встраиваем в нужное место форму редактирования
    var task_obj = document.getElementById(id); //Получим объект задачи
    var task_cont = task_obj.parentElement;     //Контейнер задачи
    var task_opis = task_cont.children[1];      //Контейнер описания задачи
    var parent = task_cont.parentElement;       //Родитель контейнера - глобальный контейнер

    var task_form = document.getElementById('add_new_task_form');//    выбираем форму с которой будем работать
    var shadow = document.getElementById('shadow_page');

    //parent.insertBefore(task_form, task_cont);  // поставим форму на нужное место.
	// task_cont.appendChild(task_form);
    task_form.style.display = "block";          // Покажем форму редактирования задачи
    shadow.style.display = "block";
    //task_obj.style.display = "none";            // Спрячем образ задачи
    //task_opis.style.display = "none";           // Спрячем описание задачи
    //task_cont.style.height = 2 + "px";          // Изменим высоту контейнера задачи
	// task_cont.style.height = "auto";
	// task_cont.style.width = "auto";

    // Убираем у других образов задач возможность открыть форму.
    // var spis = document.getElementsByClassName('task');
    // for (var i = 0; i < spis.length; i++) {
    //     spis[i].onclick = null;
    // }
    // Переносим данные задачи на форму                 

    task_form.setAttribute('data-obj_id', id);

    var today = new Date;
    var today_num = '';
    var buf = today.getDate();
    if (buf < 10) {
        buf = '0' + buf;
    }
    today_num += buf + ".";
    buf = today.getMonth() + 1;
    if (buf < 10) {
        buf = '0' + buf;
    }
    today_num += buf + ".";
    today_num += today.getFullYear();
    document.getElementById('ft_name').value = '';
    document.getElementById('ft_name').disabled = false;
    document.getElementById('ft_opis').value = '';
    document.getElementById('ft_opis').disabled = false;
    document.getElementById('ft_time').value = '';
    document.getElementById('ft_time').type = "date";
    document.getElementById('ft_priority').value = 1;
    document.getElementById('ft_executor').value = 1;
}


function started_task(id) {
    not_start_task(id);
    document.getElementById('del_button').disabled = true;
}

// Функция открытия формы редактирования задачи
function open_red_form(par) {
    var task_obj = par;
    var status = task_obj.getAttribute('data-status');
    var id = task_obj.id;
    switch (status) {
        case '0':   //Это запрос на создание новой задачи.
            new_task(id);
            break;
        case '1':   // эта задача была создана ранее, назначена исполнителю, но еще не взята в работу
            not_start_task(id);
            break;
        case '2':   // Эта задача была принята в работу. в данный момент выполняется
            started_task(id);
            break;
        case '4':   // Эта задача была принята в работу. в данный момент выполняется
            started_task(id);
            break;
        default:
            break;
    }
}

// функция закрытия формы задачи
function close_form(par) {
    var elem = par.parentElement.parentElement; // найдем форму которую нужно закрыть
    var obj_id = elem.getAttribute("data-obj_id");  // Возьмем из формы ид задачи
    var task_obj = document.getElementById(obj_id); // Получим объект задачи
    //task_obj.parentNode.style.height = 75 + "px";
    //task_obj.style.display = "block";

	//task_obj.parentNode.style.width = "100%";
    //task_obj.parentNode.children[1].style.display = "block";

    elem.style.display = "none";
    var shadow = document.getElementById("shadow_page");
    shadow.style.display = "none";

    // var spis = document.getElementsByClassName('task');
    // for (var i = 0; i < spis.length; i++) {
    //     spis[i].onclick = open_red_form;
    // }
	//rejim();
}

function set_flag_of_change() {
    flag_for_deadline = 1;
}

// Сохранение новой задачи на сервере
function update_href_page_5_4() {
    var mass_data = '';
    var buf;
    var sub_buf;
    buf = document.getElementById('ft_header_add').children[0].textContent;
    sub_buf = buf.substring(0, 10);
    mass_data += '&data=' + sub_buf;
    sub_buf = buf.substring(11, buf.length);
    mass_data += '&owner=' + sub_buf;
    buf = document.getElementById('ft_name').value;
    if (buf == '') {
        alert('Не все обязательные поля были заполнены');
        return;
    }
    mass_data += '&name=' + buf;
    buf = document.getElementById('ft_opis').value;
    if (buf == '') {
        alert('Не все обязательные поля были заполнены');
        return;
    }
    mass_data += '&opis=' + buf;

    buf = document.getElementById('ft_time').value;
    if (buf == '') {
        alert('Не все обязательные поля были заполнены');
        return;
    }
    mass_data += '&deadline=' + buf;

    buf = document.getElementById('ft_priority').value;
    mass_data += '&priority=' + buf;

    buf = document.getElementById('ft_executor').value;
    mass_data += '&executor=' + buf;

    buf = document.getElementById('ft_controller').value;
    mass_data += '&controller=' + buf;

    buf = document.getElementById('ft_consultant').value;
    mass_data += '&consultant=' + buf;

    var date = new Date();
    buf = date.getSeconds() + date.getMilliseconds();
    mass_data += '&metka=' + buf;

    document.location.href = '?page_5_4?add_ticket?' + mass_data;
}

//Удаление задачи с сервера
function update_del_href_page_5_4() {
    var task_id = document.getElementById('red_new_task_form').getAttribute('data-obj_id');
    var url = '?page_5_4?del_ticket?&id=' + task_id.substr(11, task_id.length);
    document.location.href = url;
}

function update_save_href_task_page_5_4() {
    var mass_data = '';
    var buf;
    buf = document.getElementById('red_new_task_form').getAttribute('data-obj_id');
    buf = buf.substr(11, buf.length);
    mass_data += '&task_id=' + buf;

    buf = document.getElementById('ft_comment_new').value;
    mass_data += '&opis=' + buf;
    if (flag_for_deadline === 1) {
        buf = document.getElementById('ft_time_new').value;
        if (buf === '') {
            alert('Не все обязательные поля были заполнены');
            return;
        }
        mass_data += '&deadline=' + buf;

        buf = document.getElementById('ft_priority_new').value;
        mass_data += '&priority=' + buf;
    }
    document.location.href = '?page_5_4?save_ticket?' + mass_data;
}

function start_ticket(par) {
    var ticket_id = par.parentElement.id;
    var ticket_obj = document.getElementById(ticket_id);
    var status = ticket_obj.getAttribute('data-status');
    ticket_obj.onclick = null;
    if (status == 1 || status == 3) {
        ticket_id = ticket_id.substr(11);
        var url = '?page_5_4?start_ticket?&id=' + ticket_id;
        document.location.href = url;
    }
}

function ok_ticket(par) {
    var ticket_id = par.parentElement.id;
    var ticket_obj = document.getElementById(ticket_id);
    var status = ticket_obj.getAttribute('data-status');
    ticket_obj.onclick = null;
    if (status == 2 || status == 4) {
        ticket_id = ticket_id.substr(11);
        var url = '?page_5_4?ok_ticket?&id=' + ticket_id;
        document.location.href = url;
    }
}

function pause_ticket(par) {
    var ticket_id = par.parentElement.id;
    var ticket_obj = document.getElementById(ticket_id);
    var status = ticket_obj.getAttribute('data-status');
    ticket_obj.onclick = null;
    if (status == 2) {
        ticket_id = ticket_id.substr(11);
        var url = '?page_5_4?pause_ticket?&id=' + ticket_id;
        document.location.href = url;
    }
}

function send_ticket(par) {
    var ticket_id = par.parentElement.id;
    var ticket_obj = document.getElementById(ticket_id);
    var status = ticket_obj.getAttribute('data-status');
    ticket_obj.onclick = null;
    if (status == 2) {
        ticket_id = ticket_id.substr(11);
        var url = '?page_5_4?send_ticket?&id=' + ticket_id;
        document.location.href = url;
    }
}

function show_spis_of_ticket(){
	document.cookie = 'view_rej=stolbik';
	document.location.href = "?page_5_4?";
	/* var spis_of_cont = document.getElementsByClassName('task_opis');
	for(var i=0; i<spis_of_cont.length; i++){
		spis_of_cont[i].style.display = 'block';
		spis_of_cont[i].parentElement.style.width = "100%";
	}
	rejim = show_spis_of_ticket; */
}

function show_plitka_of_ticket(){
	document.cookie = 'view_rej=plitka';
	document.location.href = "?page_5_4?";
	/* var spis_of_cont = document.getElementsByClassName('task_opis');
	for(var i=0; i<spis_of_cont.length; i++){
		spis_of_cont[i].style.display = 'none';
		spis_of_cont[i].parentElement.style.width = "32%";
	}
	rejim = show_plitka_of_ticket; */
}

function show_active_ticket(){
	var check_box = document.getElementById('active_checkbox');
	if(check_box.checked){
		document.cookie = 'active_task=on';
	}
	else{
		document.cookie = 'active_task=off';
	}	
	document.location.href = "?page_5_4?";
}

function show_complite_ticket(){
	var check_box = document.getElementById('complite_checkbox');
	if(check_box.checked){
		document.cookie = 'complite_task=on';
	}
	else{
		document.cookie = 'complite_task=off';
	}	
	document.location.href = "?page_5_4?";
}

function show_my_ticket(){
	var check_box = document.getElementById('my_checkbox');
	if(check_box.checked){
		document.cookie = 'my_task=on';
	}
	else{
		document.cookie = 'my_task=off';
	}	
	document.location.href = "?page_5_4?";	
}

function show_ticket_for_me(){
	var check_box = document.getElementById('for_me_checkbox');
	if(check_box.checked){
		document.cookie = 'for_me_task=on';
	}
	else{
		document.cookie = 'for_me_task=off';
	}	
	document.location.href = "?page_5_4?";
}

function order_ticket_by_priority(){
	document.cookie = 'order_by=priority';
	document.location.href = "?page_5_4?";
}

function order_ticket_by_deadline(){
	document.cookie = 'order_by=deadline';
	document.location.href = "?page_5_4?";
}