<?php
include_once '../common.php';

function patch_group($POST)
{
    if (!isset($POST['id']))
    {
        throw new InvalidJsonValues('Empty JSON');
    }

    $in_id = $POST['id'];

    ft_check_id($in_id);
    if (!ft_db_select_check("t_groups",  "group_id = " . $in_id))
    {
        throw new InvalidJsonValues("no such group - " . $in_id);
    } 
    $possible_keys = array(
        'name',
        'l_type',
    );
    foreach ($POST as $key => $value)
    {
        if ($key == 'id' || $key == 'type')
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
                ft_check_groupname($value);
                $set_statement = $set_statement . " group_name = '" . $value ."',"; 
                break;
            case ($possible_keys[1]):
                ft_check_learning_type($value);
                $set_statement = $set_statement . " learning_type = '" . $value ."',"; 
                break;
            default:
                break;
        }
    }
    $set_statement = substr($set_statement, 0, -1);
    ft_db_update('t_groups', $set_statement, "group_id = " . $in_id);
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
