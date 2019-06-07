function add_like(par){
    var parent = par.parentElement;
    //var str_like = parent.children[1];
    //str_like.textContent = parseInt(str_like.textContent)+1;
    // if VoutedId+parent.parentElement.getAttribute("data-id") {
                            //
    	if (window[String("VoutedId"+String(parent.parentElement.getAttribute("data-id")))]) {
    		alert("Вы уже голосовали за эту картинку, см выше список ваших голосов");
    		return;
    	}
    	//alert(VoutedId22);
    	//alert("VoutedId"+parent.parentElement.getAttribute("data-id"));
    	// alert("Уже проголосовали за"+parentElement.getAttribute("data-id")  );
    url = "?page_5_2?like?&id="+ parent.parentElement.getAttribute("data-id");
    alert("Ваш голос принят!: "+ String(parent.parentElement.getAttribute("data-name")));
    document.location.href = url;
    par.onclick = null;
}

function you_ok(par){
	alert("Вы УЖЕ проголосовали за " + par);
}

function close_img(){
	document.getElementById('shadow').style.display = 'none';
}

function show_img(par){
	var shadow = document.getElementById('shadow');
	var CurImg = document.getElementById('CurImg');
	shadow.style.display = 'block';
	currentImgNumber = par;
	CurImg = ImgUrls[currentImgNumber];
}

function next_img_show() {
	 //alert(ImgUrls.length);
	if (currentImgNumber==ImgUrls.length) {
		//alert(currentImgNumber);
		currentImgNumber=0;
	}
	var CurImg = document.getElementById('CurImg');
	currentImgNumber = currentImgNumber + 1;
	// alert(ImgUrls[currentImgNumber]);
	CurImg.src = ImgUrls[currentImgNumber];
}


function prev_img_show() {
	var CurImg = document.getElementById('CurImg');
	currentImgNumber = currentImgNumber -1;
	CurImg.src = ImgUrls[currentImgNumber];

}
