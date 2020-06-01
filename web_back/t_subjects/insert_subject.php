<?php

include_once '../common.php';

function insert_subject($POST)
{
	if ((!isset($POST['name']) || $POST['name'] === '') && 
        (!isset($POST['description']) || $POST['description'] === '') &&
        (!isset($POST['uid']) ||$POST['uid'] === ''))
	{
        throw new InvalidJsonValues('Empty JSON');
    }
    
    $in_name            = $POST['name'];
    $in_description     = $POST['description'];
    $in_uid             = $POST['uid'];
    
    ft_check_subjname($in_name);
    ft_check_id($in_uid);
    ft_check_subdescr($in_description);
    if (!ft_db_select_check("t_users", "uid = " . $in_uid)){
        throw new InvalidJsonValues('no such user');
        exit(1);
    }
    
    ft_db_insert('t_subjects',
        "name, description, author_uid",
        "'" . $in_name . "', '" . $in_description  . "', " .  $in_uid );
}

?>
