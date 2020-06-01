<?php
include_once '../common.php';

function patch_user($POST)
{
    if (!isset($POST['id']))
    {
        throw new InvalidJsonValues('Empty JSON');
    }

    $in_id = $POST['id'];

    ft_check_id($in_id);
    if (!ft_db_select_check('t_subjects', "subj_id = '" . $in_id . "'"))
    {
        throw new InvalidJsonValues("no such subject - " . $in_id);
    }   
    $possible_keys = array(
        'name',
        'description',
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
