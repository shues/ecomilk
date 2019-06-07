function change_content_page_1(par) {
    var flag = document.getElementById('adminim');
    if (!flag.checked) {
        return;
    }
    show_mod_win();
    var cont_id = par.id;
    var header = par.children[0].textContent;
    var body = par.children[1].innerHTML;
    var win = document.getElementById('modW');
    win.setAttribute("data-id_el", cont_id);
    win.children[0].children[0].value = header;
    win.children[1].children[0].value = body;
}

function update_href_page_1(par) {
    var href_el = par.parentElement;
    var par = href_el.parentElement;

    var href_str = '&id=' + par.getAttribute('data-id_el');
    href_str += '&header=' + par.children[0].children[0].value;
    href_str += '&body=' + par.children[1].children[0].value;

    href_el.href += href_str;
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