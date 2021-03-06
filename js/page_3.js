function search_string() {
    var value = document.getElementById("search_string").value;
    value = value.toLowerCase();
    var table = document.getElementById("table_cont");
    var flag;
    var tbody = table.children[2];
    for (var i = 0; i < tbody.children.length; i++) {
        var tab_str = tbody.children[i];
        flag = false;
        for (var j = 0; j < tab_str.children.length; j++) {
            var tab_pole = tab_str.children[j].outerText;
            var ua = navigator.userAgent;
            if(ua.indexOf('fox') > -1){
                tab_pole = tab_str.children[j].textContent;
            }
            tab_pole = tab_pole.toLowerCase();
            if (tab_pole.indexOf(value) != -1) {
                flag = true;
            }
        }
        if (flag == false) {
            if (tab_str.id.indexOf('dept_')!=0) {
                tab_str.style.display = "none";
            }
        } else {
            tab_str.style.display = "table-row";
        }
    }
}

function change_content_page_3(par) {
    var flag = document.getElementById('adminim');
    if (!flag.checked) {
        return;
    }
    show_mod_win();
    var cont_id = par.id;
    var fio = par.children[0].textContent;
    var role = par.children[1].textContent;
    var inner_phone = par.children[2].textContent;
    var mobile_phone = par.children[3].textContent;
    var email = par.children[4].textContent;
    var dept = par.getAttribute('data-dept');
    var boss = par.getAttribute('data-boss');
    if (cont_id == boss) {
    		boss = true;
    }else {
    		boss = false;
    }

    var win = document.getElementById('modW');

    win.setAttribute("data-id_el", cont_id);
    win.children[0].children[0].value = fio;
    win.children[1].children[0].value = role;
    win.children[2].children[0].value = inner_phone;
    win.children[3].children[0].value = mobile_phone;
    win.children[4].children[0].value = email;
    win.children[5].children[0].value = dept;
    win.children[6].children[0].checked = boss;
}

function update_href_page_3(elem) {
    var href_el = elem.parentElement;
    var par = document.getElementById('modW');

    var href_str = '&id=' + par.getAttribute('data-id_el');
    href_str += '&fio=' + par.children[0].children[0].value;
    href_str += '&role=' + par.children[1].children[0].value;
    href_str += '&inner_phone=' + par.children[2].children[0].value;
    href_str += '&mobile_phone=' + par.children[3].children[0].value;
    href_str += '&email=' + par.children[4].children[0].value;
    href_str += '&dept=' + par.children[5].children[0].value;
    href_str += '&boss=' + par.children[6].children[0].checked;
	 
    href_el.href += href_str;

    //alert(href_str);
}

function show_mod_win() {
    var mass = document.getElementsByName('modW');
    for (var i = 0; i < mass.length; i++) {
        mass[i].style.display = "block";
    }
}

function hide_mod_win() {
    var mass = document.getElementsByName('modW');
    for (var i = 0; i < mass.length; i++) {
        mass[i].style.display = "none";
    }
}