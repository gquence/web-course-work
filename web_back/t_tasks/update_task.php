<?php
include_once '../common.php';

function patch_task($POST)
{
    if (!isset($POST['id']))
    {
        throw new InvalidJsonValues('Empty JSON');
    }

    $in_id = $POST['id'];

    ft_check_id($in_id);
    if (!ft_db_select_check('t_tasks', "task_id = " . $in_id))
    {
        throw new InvalidJsonValues("no such subject - " . $in_id);
    }   
    $possible_keys = array(
        'quest',
        'corr_ans',
        'ans'
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
                ft_check_bigtexttasks($value);
                $set_statement = $set_statement . " question_path  = '" . $value ."',"; 
                break;
            case ($possible_keys[1]):
                ft_check_corrans($value);
                $set_statement = $set_statement . " corr_answer = '" . $value ."',";
                break;
            case ($possible_keys[2]):
                ft_check_ans($value);
                $set_statement = $set_statement . "answers  = '" . $value ."',"; 
                break;
            default:
                break;
        }
    }
    $set_statement = substr($set_statement, 0, -1);
    ft_db_update('t_tasks', $set_statement, "task_id = " . $in_id);
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
