<?php

include_once '../common.php';

function auth_user($POST)
{
if (!array_key_exists('login', $POST) || !array_key_exists('pass', $POST)
    || !isset($POST['sOp']))
    {
        throw new InvalidJsonValues("Empty login or pass or sOc");
        exit(1);
    }

    $in_login = $POST['login'];
    $in_password = $POST['pass']; 
    ft_check_login($in_login); 
    ft_check_password($in_password);
    $in_stud_or_pedago = $POST['sOp'];
    if (strcmp($in_stud_or_pedago,'true') && strcmp($in_stud_or_pedago, 'false'))
    {
        throw new InvalidJsonValues('sOc must be true or false');
        exit(1);
    }

    
    ft_auth($in_login, $in_password);
    $sOc = ft_db_select("stud_or_pedago", "t_users", "login = '" . $in_login . "'")[0];
    if ((!strcmp($sOc['stud_or_pedago'], "t") && !strcmp($in_stud_or_pedago,'true')) ||
        (!strcmp($sOc['stud_or_pedago'], "f") && !strcmp($in_stud_or_pedago,'false')))
    {
        return "true";
    }
    else
        return "false";
}
?>