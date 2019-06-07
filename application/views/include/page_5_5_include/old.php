<div id="shadow_form"></div>

<div id="form_for_r_task_red">
	<div id="not_save" class="sys_butt" onclick="close_frm(0);">
		X
	</div>
	<input type="text" id="task_name" oninput="allow_button();">
	<br>
	<br>
	<select name="task_owner" id="task_owner" onchange="allow_button();">
		<option value="0">Выбрать исполнителя</option>
		<?php
			foreach ($data[2] as $string) {
				echo '<option value="'.$string['id'].'">'.$string['display_name'].'</option>';
			}
		?>
	</select>
	
	<input type="checkbox" name="mon" id="mon" class="days" onchange="allow_button();">Пн
	<input type="checkbox" name="tue" id="tue" class="days" onchange="allow_button();">Вт
	<input type="checkbox" name="wed" id="wed" class="days" onchange="allow_button();">Ср
	<input type="checkbox" name="thu" id="thu" class="days" onchange="allow_button();">Чт
	<input type="checkbox" name="fri" id="fri" class="days" onchange="allow_button();">Пт
	<br>
	
	<div id="last_comments">
		<p class="comm_cont" style="display: none;">
			<span>
				<u>
					<small>
						<i>
						</i>
					</small>
				</u>
				<br>
				<span>
				</span>
				<br>
				<br>
			</span>
		</p>
	</div>


	<textarea id="comment" oninput ="allow_button();">
		
	</textarea>
	<br>

	<button id="ok_button" onclick="close_frm(1);" disabled="true">OK</button>
</div>