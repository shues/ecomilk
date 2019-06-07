
<table>

	<thead>
		<tr>
			<th id="t_num">№</th>
			<th id="t_name">Имя задачи</th>
			<th id="t_time">Выполнить</th>
			<th id="t_ok">OK</th>
			<th id="t_comm">Комментарии к задаче</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$i = 1;
//			echo '<pre>';
//			print_r($data[1]);
//			echo '</pre>';
			foreach ($data[1] as $string) {
					echo '<tr data-id="'.$string['r_ticket'].'" 
							data-own="'.$string['owner'].'"
							data-mon="'.$string['mon'].'"
							data-tue="'.$string['tue'].'"
							data-wed="'.$string['wed'].'"
							data-thu="'.$string['thu'].'"
							data-fri="'.$string['fri'].'">';
				 	echo '<td class="col_num">'.$i.'</td>';
				 	echo '<td class="col_name" onclick="show_form_task_red(0,this);">'.$string['name'].'</td>';
				 	echo '<td class="col_time">'.$string['deadline'].'</td>';
				 	if ($string['time_ok'] == NULL) {
				 		echo '<td class="col_ok" onchange="r_task_ok(this);"><input type="checkbox" name="1"></td>';		 		
				 	}else{
				 		echo '<td class="col_ok" onchange="r_task_ok(this);">OK</td>';	
				 	}
				 	echo '<td class="col_comm">'.$string['comm'].'</td>';
				 echo '</tr>';
				 $i++;
			}
		?>
	</tbody>

</table>

<br>

<div id="regl_menu">
	<button id="add_button" class="sys_button_1" title="Новая задача">+</button>
	<!-- <input type="checkbox" name="show_all" <?php if($_COOKIE['all_task']=="show"){echo "checked";} ?> onchange="show_all_task(this);">Показать все-->
</div>

<?php
/*			echo '<pre>';
			print_r($data[2]);
			echo '</pre>';*/
	require_once("./application/views/include/page_5_5_include/add_task_master.php");
?>