<div id="shadow_form">

<div id="form_for_r_task_red">
	<div id="not_save" class="sys_butt">
		X
	</div>
	<h2>Мастер добавления новой задачи</h2>
	<div id="page_name" class="content_box">
		<h3>Введите название для новой задачи</h3>
		<input type="text" id="task_name">
		<h3>Введите комментарий для новой задачи</h3>
		<textarea id="comment">
		</textarea>
	</div>
	
	<div id="page_exequtor" class="content_box">
		<h3>Выберите исполнителя задачи</h3>
		<p>
		<select id="department" class="sys_select_1">
			<?php
				echo '<option selected>Все отделы</option>';
				foreach($data[2] as $key => $value){
					$dep_name = $key;
					if(strpos($dep_name, '(')) {
						$dep_name = substr($dep_name, 0, strpos($dep_name, '('));
					}
					echo '<option value="'.$key.'">'.$dep_name.'</option>';			
				}
			?>
		</select>
		</p>
		<p>
			<select id="users" hidden="true" class="sys_select_1">
				<option selected data-parent="0">Все сотрудники</option>
			</select>
			<select id="users_show" class="sys_select_1">
				<?php
					echo '<option selected data-parent="0">Все сотрудники</option>';
					foreach($data[2] as $key => $value){
						foreach($value as $key_1 => $value_1){
							echo '<option value="'.$value_1['id'].'" data-parent="'.$key.'">'.$value_1['display_name'].'</option>';
						}
					}
				?>
			</select>
			
		</p>
		
	</div>
	
	<div id="page_time" class="content_box">
		<h3>График запуска задачи</h3>
		<fieldset>
			<legend>Время запуска</legend>
			<label>
				Старт:
				<select></select> 
				<input type="text" id="start_date">
				<select>
					<?php
						for($i = 0; $i < 23; $i++) {
							echo "<option>$i:00</option>";
							echo "<option>$i:30</option>";
						}
					?>
				</select> 
			</label>
			<label>  
				Финиш:
				<input type="text" id="finish_date"> 
			</label>
		</fieldset>
		<br>
		<fieldset>
			<legend>Повторять</legend>
			<div id="radiobox">
				<input type="radio" name="repeat" value="everyday_set" checked> Ежедневно
				<br>
				<input type="radio" name="repeat" value="everyweek_set" > Еженедельно
				<br>
				<input type="radio" name="repeat" value="everymonth_set" > Ежемесячно
				<br>
				<input type="radio" name="repeat" value="everyyear_set" > Ежегодно
			</div>
			<div id="everyday_set" class="repeat_page">
				<input type="radio" name="everyday" value="1" checked>  Каждый <input type="text" id="day_num" class="day_week_num" value="1"> день
				<br><br>
				<input type="radio" name="everyday" value="2" > Каждый рабочий день
			</div>
			<div id="everyweek_set" class="repeat_page">
				Повторять каждую <input type="text" id="week_num" class="day_week_num" value="1"> неделю в следующие дни:
				<br>
				<br>
				<input type="checkbox" class="day_of_week"> Пн 
				<input type="checkbox" class="day_of_week"> Вт 
				<input type="checkbox" class="day_of_week"> Ср
				<input type="checkbox" class="day_of_week"> Чт
				<input type="checkbox" class="day_of_week"> Пт
			</div>
			
			<div id="everymonth_set" class="repeat_page">
				<input type="radio" name="everymonth" value="1" checked> повторять <input type="text" class="day_week_num" id="day_month_num" value="<?php echo date('d')?>"> числа каждого <input type="text" class="day_week_num" id="month_num" value="1"> месяца
				<br>
				<br>
				<input type="radio" name="everymonth" value="2"> в: 
					<select>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">последн.</option>
					</select>
					<select>
						<option value="day">день</option>
						<option value="work_day">рабочий день</option>
						<option value="weekend">выходной день</option>
						<option value="sunday">Воскресенье</option>
						<option value="monday">Понедельник</option>
						<option value="tusday">Вторник</option>
						<option value="wednsday">Среда</option>
						<option value="thursday">Четверг</option>
						<option value="friday">Пятница</option>
						<option value="saturday">Суббота</option>
					</select>
					каждого <input type="text" class="day_week_num" id="month_num_1" value="1"> месяца
			</div>
			<div id="everyyear_set" class="repeat_page">
				повторять каждые <input type="text" class="day_week_num" id="year_num" value="1"> г.
				<br>
				<br>
				<input type="radio" name="everyyear" value="1" checked> Дата: 
				<select>
					<option value="january">Январь</option>
					<option value="fabruary">Февраль</option>
					<option value="march">Март</option>
					<option value="april">Апрель</option>
					<option value="may">Май</option>
					<option value="june">Июнь</option>
					<option value="july">Июль</option>
					<option value="awgust">Август</option>
					<option value="september">Сентябрь</option>
					<option value="october">Октябрь</option>
					<option value="november">Ноябрь</option>
					<option value="december">Декабрь</option>
				</select>
				<input type="text" class="day_week_num" id="day_month_num_1" value="1">
				<br>
				<br>
				<input type="radio" name="everyyear" value="2"> в:
				<select>
					<option>1</option>
					<option>2</option>
					<option>3</option>
					<option>4</option>
					<option>последн.</option>
				</select>
				<select>
					<option>день</option>
					<option>рабочий день</option>
					<option>выходной день</option>
					<option>Воскресенье</option>
					<option>Понедельник</option>
					<option>Вторник</option>
					<option>Среда</option>
					<option>Четверг</option>
					<option>Пятница</option>
					<option>Суббота</option>
				</select>
				месяца 
				<select>
					<option>Январь</option>
					<option>Февраль</option>
					<option>Март</option>
					<option>Апрель</option>
					<option>Май</option>
					<option>Июнь</option>
					<option>Июль</option>
					<option>Август</option>
					<option>Сентябрь</option>
					<option>Октябрь</option>
					<option>Ноябрь</option>
					<option>Декабрь</option>
				</select> 
			</div>
		</fieldset>
	</div>
	
	<div class="button_section">
		<button id="back_button" class="navi_buttons"><< НАЗАД </button>
		<button id="forward_button" class="navi_buttons">ДАЛЕЕ >></button>
	</div>
</div>
</div>