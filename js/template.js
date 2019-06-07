var VoutedId22=false;

function show_submenu(elem) {
    elem.children[1].style.display = "block";
}

function hide_submenu(elem) {
    elem.children[1].style.display = "none";
}

function reg_cook_adm(par){
	if (par.checked) {
		document.cookie = "adminim=ok";
	}else{
		document.cookie = "adminim=no";
	}
}