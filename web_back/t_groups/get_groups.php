<?php
include_once '../common.php';

function get_groups($POST)
{
    $where = "";
    if (((isset($POST['id'])) && ($POST['id'] !== ""))){
        $in_id          = $POST['id'];
        ft_check_id($in_id);
        $where = "group_id = " . $in_id;
    }
    if ((isset($POST['name'])) && ($POST['name'] !== ""))
    {
        $in_name         = $POST['name'];
        ft_check_groupname($in_name);
        if ($where === "")
        {
            $where = "group_name = '" . $in_name . "'";
        }
        else
            $where = $where . " and group_name = '" . $in_name. "'";
    }
    if ($where === "")	{
        throw new InvalidJsonValues('Empty JSON');
    }

    if (!ft_db_select_check("t_groups", $where)){
        return array('result' => "No groups with this id or name");
    }

    return (ft_db_select("*" , "t_groups",   $where));


}

function get_all($POST)
{   
    return (ft_db_select("*", "t_groups", ""));
}


?>