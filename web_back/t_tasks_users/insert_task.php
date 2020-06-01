<?php

include_once '../common.php';

function insert_task($POST)
{
	if (!isset($POST['task_id']) || !isset($POST['uid']) ||
		!isset($POST['correct']) || !isset($POST['users_ans']))
	{
        throw new InvalidJsonValues('Empty JSON');
	}
    $in_task_id             = $POST['task_id'];
    $in_uid                 = $POST['uid'];
    $in_correct             = $POST['correct'];
    $in_users_ans           = $POST['users_ans'];

    
    ft_check_id($in_task_id);
    ft_check_id($in_uid);
    ft_check_corrans($in_users_ans);
    $in_correct = strtolower($in_correct);
    if (strcmp($in_correct,'true') && strcmp($in_correct, 'false'))
    {
        throw new InvalidJsonValues('(correct) must be true or false');
        exit(1);
    }
    if (!ft_db_select_check("t_users", "uid = " . $in_uid)){
        throw new InvalidJsonValues('No such user');
        exit(1);
    }
    if (!ft_db_select_check("t_tasks", "task_id = " . $in_task_id )){
        throw new InvalidJsonValues('No such task');
        exit(1);
    }

    
    ft_db_insert('t_tasks_result',
        "task_id, uid, correct, users_ans",
        $in_task_id . ", " . $in_uid  . ", " .  $in_correct   . ", '" . 
        $in_users_ans . "'");
}

?>
