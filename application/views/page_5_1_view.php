<?php $res_mass = $data[1]; ?>

<form method='post' action='http://wc.ecomilk.ru/?page_id=492'>
    <input type='hidden' name='buyer_login' value='" . $buyer_login . "'>
    <label for='order_date'>Дата заказа: </label>
    <input type='date' name='order_date' id='order_date' value=<?php echo date('Y-m-d'); ?>>
    <label for='order_number'>Номер заказа: </label>
    <input type='input' name='order_number' id='order_number' style='width:40px'>
    <table class='order'>
        <tr>
            <td class="name_col">Номенклатура</td>
            <td>Кол-во</td>
            <td>Ед.</td>
            <td>Цена</td>
            <td>Сумма</td>
        </tr>
        <?php
        foreach ($res_mass as $res) {
            echo "<tr class='order_list_item' id='" .$res['id'].  "'>"
                    . "<td class='name_col'>" .$res['name'].  "</td>"
                    . "<td><input  type='text' style='width:40px; text-align:right;'  id='count-" .$res['id'].  "' onkeyup = 'recount_order();'/></td>"
                    . "<td>" .$res['unit_name']."</td>"
                    . "<td id='price-" .$res['id'].  "'>" .$res['price'].  "</td>"
                    . "<td><input id='summ-" .$res['id'].  "'  type='text' style='width:80px; text-align:right;' disabled /></td>"
                . "</tr>";
        }
        ?>
    </table>
    <p>
        <input id="itog" type="text" disabled="disabled">
    </p>    
    <input type='submit' id='submit_order'>    
</form>