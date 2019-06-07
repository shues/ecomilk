function init_page(){
	document.getElementById('add_printer_button').onclick = init_form;
}

function init_form(){
	document.getElementById('add').onclick = add_printer;
	document.getElementById('del').onclick = del_printer;
	document.getElementById('firma').onchange = sort_models;
	document.getElementById('close_form').onclick = close_form;
	sort_models();
	show_form();
}

function show_form(){
	document.getElementById('shadow').style.display = "block";
}

function add_printer(){
	var url = "?page_2_1?add_printer?&dept="+document.getElementById('dept').value;
	url += "&ip=" + document.getElementById('ip_addr').value;
	url += "&login=" + document.getElementById('login').value;
	url += "&password=" + document.getElementById('password').value;
	url += "&firma=" + document.getElementById('firma').value;
	url += "&model=" + document.getElementById('model').value;
	document.location.href = url;
}

function del_printer(){

}

function sort_models(){
	var firma_id = document.getElementById('firma').value;
	var mass_mod = document.getElementById('model').children;
	for(var i=0; i<=mass_mod.length-1; i++){
		if (mass_mod[i].getAttribute('data-firma')==firma_id) {
			mass_mod[i].style.display = 'block';
		}else{
			mass_mod[i].style.display = 'none';
		}
	}
	document.getElementById('model').selectedIndex = 0;
}

function close_form(){
	document.getElementById('add_printer').style.display = "none";
	document.getElementById('shadow').style.display = "none";
}