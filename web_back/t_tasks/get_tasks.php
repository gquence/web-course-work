<?php
include_once '../common.php';

function get_tasks($POST)
{
    $where = "";
    if (((isset($POST['id'])) && ($POST['id'] !== ""))){
        $in_id          = $POST['id'];
        ft_check_id($in_id);
        $where = "task_id = " . $in_id;
    }
    if ((isset($POST['l_id'])) && ($POST['l_id'] !== ""))
    {
        $in_l_id        = $POST['l_id'];
        ft_check_id($in_l_id);
        if ($where === "")
        {
            $where = "lesson_id = " . $in_l_id;
        }
        else
            $where = $where . " and lesson_id = " . $in_l_id;
    }
    if ($where === "")
        throw new InvalidJsonValues('Empty JSON');
    if (!ft_db_select_check("t_tasks",  $where )){
        return array('result' => "No tasks with this id or l_id");
    }

    return (ft_db_select("*", "t_tasks",  $where ));
}

function get_all($POST)
{   
    return (ft_db_select("*", "t_tasks", ""));
}


?>