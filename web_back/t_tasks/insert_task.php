<?php

include_once '../common.php';

function insert_task($POST)
{
	if ((!isset($POST['l_id']) || $POST['l_id'] === '') || 
        (!isset($POST['quest']) || $POST['quest'] === '') || 
        (!isset($POST['corr_ans']) || $POST['corr_ans'] === '')|| 
        (!isset($POST['ans']) || $POST['ans'] === ''))
	{
        throw new InvalidJsonValues('Empty JSON');
	}
    $in_l_id            = $POST['l_id'];
    $in_quest           = $POST['quest'];
    $in_corr_ans        = $POST['corr_ans'];
    $in_ans             = $POST['ans'];
    
    ft_check_id($in_l_id);
    ft_check_bigtexttasks($in_quest);
    ft_check_corrans($in_corr_ans);
    ft_check_ans($in_ans);
    if (!ft_db_select_check("t_lessons", "lesson_id = '" . $in_l_id . "'")){
        throw new InvalidJsonValues('No such lesson');
        exit(1);
    }

    ft_db_insert('t_tasks',
        "lesson_id, question_path, corr_answer, answers",
        $in_l_id . ", '" . $in_quest  . "', '" .  $in_corr_ans   . "', '" . 
        $in_ans . "'");
}

?>
