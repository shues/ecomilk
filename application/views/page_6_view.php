<?php

print '
        <form action="" method="GET">
            <p>
                <input id="login" name="login" type="text" placeholder="login">
            </p>
            <p>
                <input id="password" name="password" type="password" placeholder="password" onblur="update_href();">
            </p>
            <a id="href" href="http://www.beta-corp.com/?autorization?input?"><input type="button" value="Войти"></a>
        </form>
    ';
?>
