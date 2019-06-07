<?php
unset($_GET);
$user_info = $data[1];
$executors = $data[2];

$task_for_user = $data[3];
$task_of_user = $data[4];

$cun = $user_info[0];




$ticket_name = 'Проверить обновление 1с';
$ticket_owner = 'Иван Арясов';
$ticket_start = date('d.m.Y');
$time_str = strtotime('+3 day');
$ticket_deadline = date('d.m.Y', $time_str);
$ticket_opisanie = 'это новая задача, созданная для тестирования странички '
        . 'это новая задача, созданная для тестирования странички '
        . 'это новая задача, созданная для тестирования странички '
        . 'это новая задача, созданная для тестирования странички '
        . 'это новая задача, созданная для тестирования странички';
?>

<div id="main_conteiner">
    <?php
    require_once ('./application/views/include/page_5_4_include/settings_of_tickets.php');
	if(count($task_of_user) > 0){
		echo "<h3>Задачи для вас</h3>";
	}
	
	function print_task($task,$rej_id){
		$ticket_id = $task[1];
        $ticket_name = $task[2];
        $ticket_start = substr($task[3], 8, 2) . '.' . substr($task[3], 5, 2) . '.' . substr($task[3], 0, 4);
        $classes = 'task ';
        $ticket_status = $task[4];
		$active_flag = $_COOKIE['active_task'];
		$complite_flag = $_COOKIE['complite_task'];
        $show_start = ' hider ';
        $show_ok = ' hider ';
        $show_send = ' hider ';
        $show_weit = ' hider ';
		
        switch ($ticket_status) {
            case '1':
                $classes .= ' not_start ';
                $show_start = ' shower ';
		//		if($active_flag == "off"){return;}
                break;
            case '2':
                $classes .= ' started ';
                $show_ok = ' shower ';
		//		if($active_flag == "off"){return;}
                break;
            case '3':
                $classes .= ' paused ';
		//		if($active_flag == "off"){return;}
                break;
            case '4':
                $classes .= ' waiting ';
                $show_ok = ' shower ';
		//		if($active_flag == "off"){return;}
                break;
            case '5':
                $classes .= ' complete ';
		//		if($complite_flag == "off"){return;}
                break;
            default:
                break;
        }
		if($_COOKIE['view_rej']=='plitka'){
			$conteiner_class .= ' plitka_view';
		}
		else{
			$conteiner_class .= ' spisok_view';
		}
        
        $ticket_deadline = substr($task[5], 8, 2) . '.' . substr($task[5], 5, 2) . '.' . substr($task[5], 0, 4);
        $ticket_priority = $task[6];
        switch ($ticket_priority) {
            case '1':
                $level = 'priority_hight';
                break;
            case '2':
                $level = 'priority_medium';
                break;
            case '3':
                $level = 'priority_low';
                break;
            default:
                break;
        }
        
        //$ticket_opisanie = str_replace(':', '<br>', $task[7]);
        $ticket_opisanie_bute = '';
        $ticket_opisanie = explode('::', $task[7]);
        foreach ($ticket_opisanie as $comment_struct) {
            $comment = explode(':', $comment_struct);
            $ticket_opisanie_bute .= '<u><small><i>'.$comment[0].' '.$comment[1].'</i></small></u><br>'.$comment[2].'<br><br>';
        }
        
        $ticket_users = explode(';', $task[8]);
        for($i=0; $i<count($ticket_users); $i++){
            $autor_count = strpos($ticket_users[$i], 'autor');
            $executor_count = strpos($ticket_users[$i], 'executor');
            $controller_count = strpos($ticket_users[$i], 'controller');
            $consultant_count = strpos($ticket_users[$i], 'consultant');
            
            if($autor_count >= 0 && $autor_count !== FALSE){
                $autors_list = substr($ticket_users[$i], $autor_count+6);
            }
            if($executor_count >= 0 && $executor_count !== FALSE){
                $executors_list = substr($ticket_users[$i], $executor_count+9);
            }
            if($controller_count >= 0 && $controller_count !== FALSE){
                $controllers_list = substr($ticket_users[$i], $controller_count+10);
            }
            if($consultant_count >= 0 && $consultant_count !== FALSE){
                $consultant_list = substr($ticket_users[$i], $consultant_count+10);
            }
        }
        
        $ticket_owner = $autors_list;
        $ticket_event = 'open_red_form(this);';
        
        $button_start_event = 'start_ticket(this);';
        $button_ok_event = 'ok_ticket(this);';
        $button_pause_event = 'pause_ticket(this);';
        $button_send_event = 'send_ticket(this);';
        
        // Это мы показываем задачу
        echo '
        <div class="task_conteiner '.$conteiner_class.'">
            <div id="' . $rej_id.$ticket_id . '"
                class="' . $classes . '"
                data-executor="' . $executors_list . '"
                data-controller="' . $controllers_list . '"
                data-consultant="' . $consultant_list . '"
                data-priority="' . $ticket_priority . '" 
                data-status="'.$ticket_status.'"
                onclick="' . $ticket_event . '">
                
                <div class="event_task start_task '.$show_start.'" onclick="'.$button_start_event.'"><div id="start"></div></div>
                <div class="event_task ok_task '.$show_ok.'" onclick="'.$button_ok_event.'">Ok</div>
                <div class="event_task send_task '.$show_send.'" onclick="'.$button_send_event.'">>></div>
                <div class="event_task weit_task '.$show_weit.'" onclick="'.$button_pause_event.'">ll</div>
                <div class="priority ' . $level . '"></div>
                <b>' . $ticket_deadline . '</b>

                <br>

                <u>' . $ticket_name . '</u><br>
                <span>' . $ticket_owner . ' ' . '</span>
                <span>' . $ticket_start . '</span>
            </div>';
        $show_opis = "";
		if($_COOKIE['view_rej'] == 'stolbik'){
            $show_opis = "_show";
        }
            echo '
			<div class="task_opis'.$show_opis.'">
				<p>
					<span>' . $ticket_opisanie_bute . '</span>
				</p>
			</div>';
        echo '</div>';
	}
	
    foreach ($task_of_user as $task) {
        // Это мы подготавливаем данные для каждой задачи
        
        print_task($task, "task_for_me");
		
    }
	
	if(count($task_for_user)>0){
		echo "<h3>Задачи выставленные вами</h3>";
	}
	
	foreach ($task_for_user as $task) {
        print_task($task, "task_frm_me");
    }
    ?>
    <?php
        require_once ('./application/views/include/page_5_4_include/forms_for_red_task.php');
    ?>
    <?php // Это значек для добавления новой задачи?>
    <div class="task_conteiner <?php if($_COOKIE['view_rej']=='plitka'){echo 'plitka_view';}else{echo 'spisok_view';}?>">
        <div id="task_0" class="task" data-status="0" onclick="open_red_form(this);">
            <div id="cross"></div>
        </div>
    </div> 
</div>