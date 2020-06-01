<?php
include_once '../db_common.php';
include_once 'validator.php';

function delete_subject($POST)
{
    if (!isset($POST['id']))
    {
        throw new InvalidJsonValues('Empty JSON');
    }

    $in_id = $POST['id'];

    ft_check_id($in_id);
    if (!ft_db_select_check("t_tasks",  "task_id = " . $in_id))
    {
        throw new InvalidJsonValues("no such subject - " . $in_id);
    }
    ft_db_delete("t_tasks",  "task_id = " . $in_id);
}
?>
