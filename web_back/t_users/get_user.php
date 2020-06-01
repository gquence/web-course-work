<?php
include_once '../common.php';

function get_user($POST)
{
	if (!isset($POST['login']))
	{
        throw new InvalidJsonValues('Empty JSON');
	}
    $in_login           = $POST['login'];
    
    #$in_surname         = 'testsurname';
    #$in_name            = 'testname';
    #$in_stud_or_pedago  = TRUE;
    #$in_login           = 'monitoring_login';
    #$in_password        = 'monitoring';

    ft_check_login($in_login);
    if (!ft_db_select_check("t_users", "login = '" . $in_login . "'")){
        return array('result' => "No user with this login");
    }

    return (ft_db_select("uid, surname, name, stud_or_pedago, status, login, email", "t_users", "login = '" . $in_login . "'")[0]);
}

function get_all($POST)
{
	if (isset($POST['sOp']))
	{
        $in_stud_or_pedago  = $POST['sOp'];
        $in_stud_or_pedago = strtolower($in_stud_or_pedago);
        if (strcmp($in_stud_or_pedago,'true') && strcmp($in_stud_or_pedago, 'false'))
        {
            throw new InvalidJsonValues('sOp must be true or false');
            exit(1);
        }
        return (ft_db_select("uid, surname, name, stud_or_pedago, status, login, email", "t_users", "stud_or_pedago = '" . $in_stud_or_pedago . "'"));
    }
    return (ft_db_select("uid, surname, name, stud_or_pedago, status, login, email", "t_users", ""));
    
}


?>