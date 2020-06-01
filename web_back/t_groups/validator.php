<?php


include_once '../ERRS.php';
#   COMMON DESCRIPTION:
#   return values: 
#                 TRUE:
#                       all db-parameter constraints are satisfied
#                 FALSE:
#                       otherwise

function ft_check_learning_type(string $str = "")
{
    if ($str == "")
        return TRUE;
    $var_arr = array(
        "full time",
        "distance",
        "evening"
    );
    if (!in_array($str,$var_arr))
        throw new InvalidJsonValues("Invalid learning type");
    return TRUE;
}

function ft_check_groupname(string $name = "")
{
    if ($name == "") {
        throw new InvalidJsonValues('Empty JSON');
    }
    if (strlen($name) > 19 || strlen($name) < 4) {
        throw new InvalidJsonValues('Invalid name lenght');
    }
    return TRUE;
}

function ft_check_date(string $vdate = "")
{
    if ($vdate == "")
        return TRUE;
    if (date('d-m-Y',strtotime($vdate)) != $vdate)
        throw new InvalidJsonValues('Invalid date format');
    return TRUE;
}

?>