<table>
    <thead>
    <tr>
        <th id="dep_col">Отдел</th>
        <th id="ip_col">IP</th>
        <th id="auth_col">Логин:Пароль</th>
        <th id="model_col">Модель</th>
    </tr>
    <tr><td colspan="4">
        <?php
        $html= file_get_contents('http://192.168.1.32/');
        if (preg_match("@DeepSleep.htm@", $html)) {
            echo "СПИТ";
            echo $html;
        }else{
            echo "НЕ СПИТ";
            echo $html;
        }
        
        ?>
        
        </td></tr>
            
    <tr><td colspan="4">
        <?php
        $html= file_get_contents('http://192.168.1.31/');   //<form action="/esu/set.cgi" id="deepsleepset" method="post" onSubmit="">
                $val = snmpget('192.168.1.79','public','iso.3.6.1.2.1.43.11.1.1.9.1.1');
        if (preg_match("@DeepSleep.htm@", $html)) {
            echo "СПИТ";
            echo $html;
        }else{
            echo "НЕ СПИТ";
            echo $html;
        }
        
        ?>
        
        </td></tr>
    </thead>
    <tbody>
        
    </tbody>
</table>
<button>+</button>