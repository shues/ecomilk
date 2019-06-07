<div id="shadow" onload="init_form();">
	<div id="add_printer">
		<div id="close_form">x</div>
		<label for="dept">Отдел:</label>
		<select name="dept" id="dept">
			<?php
				foreach ($data['rooms'] as $dept) {
					echo '<option value="'.$dept['id'].'">'.$dept['name'].'</option>';
				}
			?>
		</select>
		<br>
		<br>
		<label for="ip_addr">IP адрес:</label>  <input type="text" name="ip_addr" id="ip_addr">
		<br>
		<br>
		<label for="login">Логин:</label>  <input type="text" name="login" id="login">
		<br>
		<br>
		<label for="password">Пароль:</label>  <input type="text" name="password" id="password">
		<br>
		<br>
		<label for="firma">Производитель:</label> 
		<select name="firma" id="firma">
			<?php
				foreach ($data['firms'] as $firm) {
					echo '<option value="'.$firm['id'].'">'.$firm['name'].'</option>';
				}
			?>
		</select>
		<br>
		<br>
		<label for="model">Модель:</label>  
		<select name="model" id="model">
			<option value="0">select model</option>
			<?php
				foreach ($data['models'] as $model) {
					echo '<option value="'.$model['id'].'" data-firma="'.$model['firma'].'">'.$model['model'].'</option>';
				}
			?>
		</select>
		<br>
		<br>
		<button id="add">+</button>
		<button id="del">-</button>
	</div>
</div>