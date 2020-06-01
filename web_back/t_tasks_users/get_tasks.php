<?php
include_once '../common.php';

function getreport($POST)
{
	if (!isset($POST['uid']))
	{
        throw new InvalidJsonValues('Empty JSON');
    }
    if ((isset($POST['uid'])) && ($POST['uid'] !== ""))
    {
        $in_uid          = $POST['uid'];
        ft_check_id($in_uid);
    }


    if (!ft_db_select_check("t_users", "uid = " .$in_uid)){
        return array('result' => "no such user");
    }

    $FROM = "t_lessons as tl 
    INNER JOIN (
            SELECT tt.lesson_id l_id, tt.question_path quest , ttr.correct, ttr.users_ans
            FROM t_tasks as tt 
            INNER JOIN t_tasks_result as ttr
                ON (tt.task_id = ttr.task_id)
            WHERE ttr.uid = ".$in_uid . ") as tr 
    ON (tr.l_id = tl.lesson_id)";
    return (ft_db_select("tl.name, tr.quest, tr.correct, tr.users_ans" , $FROM,   ""));
}

function get_user_tasks($POST)
{
	if ((!isset($POST['id']) && !isset($POST['uid'])))
	{
        throw new InvalidJsonValues('Empty JSON');
    }
    $where = "";
    if (((isset($POST['id'])) && ($POST['id'] !== ""))){
        $in_id          = $POST['id'];
        ft_check_id($in_id);
        $where = "task_id = " . $in_id;
    }
    if ((isset($POST['uid'])) && ($POST['uid'] !== ""))
    {
        $in_uid          = $POST['uid'];
        ft_check_id($in_uid);
        if ($where === "")
        {
            $where = "uid = " . $in_uid;
        }
        else
            $where = $where . " and uid = " . $in_uid;
    }
    if ($where === "")	{
        throw new InvalidJsonValues('Empty JSON');
    }

    if (!ft_db_select_check("t_tasks_result", $where)){
        return array('result' => "No tasks with this id and uid");
    }

    return (ft_db_select("*" , "t_tasks_result",   $where));
}

function get_all($POST)
{   
	if (isset($POST['id']))
	{
        $in_id          = $POST['id'];
        ft_check_id($in_id);
        $where = "task_id = '" . $in_id;
        if (!ft_db_select_check("t_tasks_result", $where)){
            return array('result' => "No tasks with this id");
        }
        return (ft_db_select("*", "t_tasks_result", $where));
    }
    return (ft_db_select("*", "t_tasks_result", ""));
}


?>