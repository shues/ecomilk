<!-- <form action="" method="POST">
    <input type="file" name="photo"> 
    <input type="text" name="name">
</form>
 -->

<div id="main_cont" >
<?php
    $photos = $data[1];
     // echo "<pre>";
     // print_r($photos);
     // echo "</pre>";
    $finish = $data[2];
	$ImgPath = $data[5][0];
	
	$strVoutedItems="";
	$JSurlsArray = '';
	$JSvarsString  = "";
		
	$JSvarsString .= "<script>"; 
	
	$i=0;             
		while($i<count($data[3])){
		$strVoutedItems.=$data[3][$i]['name']  .",";
		$JSvarsString .= "var VoutedId".$data[3][$i]['id']."=true ;\n";
		$i=$i+1;
	}
		$i=0;
		while($i<count($data[1])){
		$JSurlsArray .=	"'".$ImgPath.$data[1][$i]['file']."',";
		$i=$i+1;	
		}
		
	$JSurlsArray = substr($JSurlsArray, 0,strlen($JSurlsArray)-1);
	$JSurlsArray = "var ImgUrls = [".$JSurlsArray."]; \n";
	
    $strVoutedItems = substr($strVoutedItems, 0,strlen($strVoutedItems)-1);
	$JSvarsString .= $JSurlsArray."\n var currentImgNumber=0; \n</script>";
	
	echo $JSvarsString;

	
    $action = 'onclick="add_like(this);"';
	// $action = 'onclick="alert(VoutedId15)"';
    if ($finish) {
        $action = '';
        $action = 'onclick="you_ok(';
        $action .= "'".$strVoutedItems."'";
        $action .= ');"';
    }
    $i=0;

    echo "<h2>Вы можете проголосовать ".$data[4]." раза </br>"."Вы уже проголосовали за ".$strVoutedItems.".</h2>";
    while ($i < count($photos)) {
        //$show_num = $i + 1;
       // $show_name = 'Ёлка '.$show_num;
       $show_name = $photos[$i]['name'];
        echo '
            <div class="element_gal" data-name="'.$show_name.'" data-id = "'.$photos[$i]['id'].'">
                <h3><div title="Проголосовать" class="like" '.$action.'></div><div class="like_str"></div> '.$show_name.'</h3>
                <img src="'.$data[5][1].$photos[$i]['file'].'" class="gallery_pic" onclick="show_img('.$i.');">
            </div>
            ';                               //'.$photos[$i]['points'].'
        $i++;
    }
?>



    
</div>

<div id="shadow">
    <div id="close" onclick="close_img();">X</div>
    
    <img class="pointer" src="./images/prev.gif" onclick="prev_img_show();"/><img id="CurImg" src="" onclick="next_img_show();"/><img  class="pointer"  src="./images/next.gif" onclick="next_img_show();"/>
</div>
