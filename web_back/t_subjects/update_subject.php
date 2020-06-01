<?php
include_once '../common.php';

function patch_subject($POST)
{
    if (!isset($POST['id']) || ($POST['id'] === ""))
    {
        throw new InvalidJsonValues('Empty JSON');
    }

    $in_id = $POST['id'];

    ft_check_id($in_id);
    if (!ft_db_select_check('t_subjects', "subj_id = " . $in_id))
    {
        throw new InvalidJsonValues("no such subject - " . $in_id);
    }   
    $possible_keys = array(
        'name',
        'description'
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
            default:
                break;
        }
    }
    $set_statement = substr($set_statement, 0, -1);
    ft_db_update('t_subjects', $set_statement, "subj_id = " . $in_id);
}


?>
