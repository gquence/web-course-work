<?php

include_once '../common.php';

function insert_user($POST)
{
	if (!isset($POST['surname']) || !isset($POST['name']) ||
		!isset($POST['sOp']) || !isset($POST['login']) || !isset($POST['pass']))
	{
        throw new InvalidJsonValues('Empty JSON');
	}
    $in_surname         = $POST['surname'];
    $in_name            = $POST['name'];
    $in_stud_or_pedago  = $POST['sOp'];
    $in_login           = $POST['login'];
    $in_password        = $POST['pass'];


    #$in_surname         = 'testsurname';
    #$in_name            = 'testname';
    #$in_stud_or_pedago  = TRUE;
    #$in_login           = 'monitoring_login';
    #$in_password        = 'monitoring';

    $in_stud_or_pedago = strtolower($in_stud_or_pedago);
    if (strcmp($in_stud_or_pedago,'true') && strcmp($in_stud_or_pedago, 'false'))
    {
        throw new InvalidJsonValues('sOp must be true or false');
        exit(1);
    }

    
    ft_check_surname($in_surname);
    ft_check_name($in_name);
    ft_check_login($in_login);
    if (ft_db_select_check("t_users", "login = '" . $in_login . "'")){
        throw new InvalidJsonValues('Login must be unique');
        exit(1);
    }
    ft_check_password($in_password);


    $in_salt = ft_gen_salt();
    $in_hash = substr("SHA-512: ".crypt($in_password, $in_salt), 9);
    #echo $query . "\n";

    ft_db_insert('t_users',
        "surname, name, stud_or_pedago, login, password_salt, password_hash",
        "'" . $in_surname . "', '" . $in_name  . "', " .  $in_stud_or_pedago   . ", '" . 
        $in_login . "', '" . $in_salt . "', '" . $in_hash . "'");
}

?>
