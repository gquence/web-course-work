<?php
include_once '../db_common.php';
include_once 'validator.php';

function delete_lesson($POST)
{
    if (!isset($POST['id']))
    {
        throw new InvalidJsonValues('Empty JSON');
    }

    $in_id = $POST['id'];

    ft_check_id($in_id);
    if (!ft_db_select_check("t_lessons",  "lesson_id = " . $in_id))
    {
        throw new InvalidJsonValues("no such lesson - " . $in_id);
    }
    ft_db_delete("t_lessons",   "lesson_id = " . $in_id);
}
?>
