<?php
include_once '../common.php';

function patch_lesson($POST)
{
    if (!isset($POST['id']))
    {
        throw new InvalidJsonValues('Empty JSON');
    }

    $in_id = $POST['id'];

    ft_check_id($in_id);
    if (!ft_db_select_check('t_lessons', "lesson_id = '" . $in_id . "'"))
    {
        throw new InvalidJsonValues("no such lesson - " . $in_id);
    }   
    $possible_keys = array(
        'name',
        'description',
        'l_type',
        'theory',
        'recomend'
        
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
                ft_check_subjname($value);
                $set_statement = $set_statement . " ". $possible_keys[0] ." = '" . $value ."',"; 
                break;
            case ($possible_keys[1]):
                ft_check_subdescr($value);
                $set_statement = $set_statement . " ". $possible_keys[1] ." = '" . $value ."',"; 
                break;
            case ($possible_keys[2]):
                ft_check_control_type($value);
                $set_statement = $set_statement . " lesson_control_type = '" . $value ."',"; 
                break;
            case ($possible_keys[3]):
                ft_check_bigtext($value);
                $set_statement = $set_statement . " theory_path = '" . $value ."',"; 
                break;
            case ($possible_keys[4]):
                ft_check_bigtext($value);
                $set_statement = $set_statement . " recomendations_for_solving_path = '" . $value ."',"; 
                break;
            default:
                break;
        }
    }
    $set_statement = substr($set_statement, 0, -1);
    ft_db_update('t_lessons', $set_statement, "lesson_id = " . $in_id);
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
