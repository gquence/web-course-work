<?php
include_once '../db_common.php';
include_once 'validator.php';

function delete_user($POST)
{
    if (!isset($POST['login']))
    {
        throw new InvalidJsonValues('Empty JSON');
    }
    $in_login = $POST['login'];
    

    ft_check_login($in_login);
    if (!ft_db_select_check('t_users', "login = '" . $in_login . "'"))
    {
        throw new InvalidJsonValues("no such user - " . $in_login);
    }
    ft_db_delete('t_users', "login = '" . $in_login . "'");
}
?>
