<?php
include_once '../common.php';

function get_subject($POST)
{
	if (!isset($POST['id']))
	{
        throw new InvalidJsonValues('Empty JSON');
	}
    $in_id = $POST['id'];
    ft_check_id($in_id);
    if (!ft_db_select_check("t_subjects",  "subj_id = " . $in_id)){
        return array('result' => "No subjects with this id");
    }

    return (ft_db_select("*", "t_subjects",  "subj_id = " . $in_id));
}




function get_all($POST)
{   
    return (ft_db_select("*", "t_subjects", ""));
}


?>