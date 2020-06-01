<?php
include_once '../common.php';

function patch_user($POST)
{
    if (!array_key_exists('login', $POST))
    {
        throw new InvalidJsonValues("Empty login");
        exit(1);
    }

    $in_login = $POST['login'];
    

    if (!ft_db_select_check("t_users", "login = '" . $in_login . "'")){
        throw new InvalidJsonValues('No user with this login');
        exit(1);
    }
    $possible_keys = array(
        'email',
        'new_pass',
        'name',
        'surname',
        'type'
    );
    foreach ($POST as $key => $value)
    {
        if ($key == 'login' || $key == 'pass')
            continue;
        if (!in_array($key, $possible_keys))
        {
            #echo "wrong json-field - " . $key;
            throw new InvalidJsonValues("wrong json-field - " . $key);
            exit(1);
        }
    }

    $set_statement = "";
    foreach ($POST as $key => $value)
    {
        switch ($key)
        {
            case ($possible_keys[0]):
                $set_statement = $set_statement . " ". $possible_keys[0] ." = '" . $value ."',"; 
                break;
            case ($possible_keys[1]):
                $in_salt = ft_gen_salt();
                $in_hash = substr("SHA-512: ".crypt($value, $in_salt), 9);
                $set_statement = $set_statement . " ". "password_salt = '" . $in_salt ."', password_hash = '" . $in_hash ."',";
                break;
            case ($possible_keys[2]):
                $set_statement = $set_statement . " ". $possible_keys[2] ." = '" . $value ."',"; 
                break;
            case ($possible_keys[3]):
                $set_statement = $set_statement . " ". $possible_keys[3] ." = '" . $value ."',"; 
                break;
            default:
                break;
        }
    }
    $set_statement = substr($set_statement, 0, -1);
    ft_db_update('t_users', $set_statement, "login = '" . $in_login . "'");
}



#$POST = array(
#
#    'name'   => 'testname',
#    'email'  => 'test@mai.ru',
#    'surname'=> 'testsurname',
#    #'sOp'    => '',
#    'login'  => 'monitoring_login',
#    'pass'   => 'monitoring'
#);
#patch_user($POST);
#exit(0);

?>
