
<!-- <pre>
    <?php //print_r($data); ?>
</pre> -->
<table>
    <thead>
    <tr>
        <th id="dep_col">Отдел</th>
        <th id="ip_col">IP</th>
        <th id="auth_col">Логин:Пароль</th>
        <th id="model_col">Модель</th>
        <th id="model_col">стат</th>
    </tr>        
    </thead>
    <tbody>
        <?php
            $printers = $data['spis'];
//            echo '<pre>';
//            print_r($printers);
//            echo '</pre>';
            foreach ($printers as $print) {
            	//echo snmpget($print['ip'],'public','iso.3.6.1.2.1.43.11.1.1.9.1.1',100000,4);
                    $tonerPercent = (100*preg_replace("@INTEGER: @",'', snmpget($print['ip'],'public','iso.3.6.1.2.1.43.11.1.1.9.1.1',100000,4))/preg_replace("@INTEGER: @",'', snmpget($print['ip'],'public','iso.3.6.1.2.1.43.11.1.1.8.1.1',100000,4)));
               	//	$tonerPercent = 100;
                    if ($tonerPercent<20 && $tonerPercent>10){
                      echo '<tr style="background-color:#FFFFAA">'; 
                    }elseif($tonerPercent<10){
                      echo '<tr style="background-color:#FFCCAA">'; 
                    }else {
                    	 echo '<tr>';
                    }
                    echo '<td>'.$print['dept'].'</td>';
                    echo '<td>'.$print['ip'].'</td>';
                    echo '<td>'.$print['login'].':'.$print['password'].'</td>';
                    echo '<td><a href="http://'.$print['ip'].'" target="_blank">'.$print['name'].' '.$print['model'].'</a></td>';
                    echo '<td>';
                    echo $tonerPercent;
                    echo '</td></tr>';
            }
        ?>
                
    </tbody>
</table>
<button id="add_printer_button">+</button>

<?php
    require_once('include/page_2_1/form_for_add_printer.php');
?>