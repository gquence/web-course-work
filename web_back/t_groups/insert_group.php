<?php

include_once '../common.php';

function insert_group($POST)
{
	if ((!isset($POST['name']) ||  ($POST['type'] !== "")) && (!isset($POST['type']) && !isset($POST['start_date']) && !isset($POST['end_date'])))
	{
        throw new InvalidJsonValues('Empty JSON');
    }
    $VALUES = "group_name";
    $in_name = $POST['name'];
    ft_check_groupname($in_name);
    $SET_VALUES = "'" . $in_name . "'";
    
    if (isset($POST['l_type']) && $POST['l_type'] !== "")
    {
        $in_type = $POST['l_type'];
        ft_check_learning_type($in_type);
        $VALUES = $VALUES . ", learning_type";
        $SET_VALUES = $SET_VALUES . ",'" . $in_type . "'";
    }
    if (isset($POST['start_date']) && $POST['start_date'] !== "")
    {
        $in_start_date = $POST['start_date'];
        ft_check_date($in_start_date);
        $VALUES = $VALUES . ", start_date";
        $SET_VALUES = $SET_VALUES .",'" . $in_start_date . "'";
    }
    if (isset($POST['end_date']) && $POST['end_date'] !== "")
    {
        $in_end_date = $POST['end_date'];
        ft_check_date($in_end_date);
        $VALUES = $VALUES . ", end_date";
        $SET_VALUES = $SET_VALUES .",'" . $in_end_date . "'";
    }
    
    if (ft_db_select_check("t_groups", "group_name = '" . $in_name . "'")){
        throw new InvalidJsonValues('Group_name must be unique');
        exit(1);
    }

    ft_db_insert('t_groups', $VALUES, $SET_VALUES);
}

?>
