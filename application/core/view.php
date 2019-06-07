<?php
class View{
    //public $template_view;
    
    function generate($content_view, $content_css, $content_js, $template_view, $data=NULL) {
        /*
         if(is_array($data)){
            extract($data);
         }
         */
        include 'application/views/'.$template_view;
    }
}
?>
