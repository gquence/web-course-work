<?php

include_once '../common.php';

function insert_lesson($POST)
{
	if ((!isset($POST['name']) || $POST['name'] === '') || 
        (!isset($POST['description']) || $POST['description'] === '') || 
        (!isset($POST['uid']) || $POST['uid'] === '') || 
        (!isset($POST['l_type']) || $POST['l_type'] === '')|| 
        (!isset($POST['subj_id']) || $POST['subj_id'] === '') || 
        (!isset($POST['theory']) || $POST['theory'] === '') || 
        (!isset($POST['recomend']) || $POST['recomend'] === '')
        )
	{
        throw new InvalidJsonValues('Empty JSON');
    }
    
    $in_name            = $POST['name'];
    $in_description     = $POST['description'];
    $in_uid             = $POST['uid'];
    $in_l_type          = $POST['l_type'];
    $in_subj_id         = $POST['subj_id'];
    $in_theory          = $POST['theory'];
    $in_recomend        = $POST['recomend'];

    ft_check_subjname($in_name);
    ft_check_id($in_uid);
    ft_check_id($in_subj_id);
    ft_check_control_type($in_l_type);
    ft_check_subdescr($in_description);
    ft_check_bigtext($in_recomend);
    ft_check_bigtext($in_theory);
    if (!ft_db_select_check("t_users", "uid = " . $in_uid)){
        throw new InvalidJsonValues('no such user');
        exit(1);
    }
    if (!ft_db_select_check("t_subjects", "subj_id = " . $in_subj_id)){
        throw new InvalidJsonValues('no such subject');
        exit(1);
    }
    ft_db_insert('t_lessons',
        "name ,  description    ,lesson_control_type, subj_id , theory_path  ,recomendations_for_solving_path,author_uid",
        "'" . $in_name . "', '" . $in_description  . "', '" . $in_l_type . "', " . $in_subj_id . ", '" . $in_theory . "', '" . $in_recomend . "', " .$in_uid );
}

?>
