<?php


include_once '../ERRS.php';
#   COMMON DESCRIPTION:
#   return values: 
#                 TRUE:
#                       all db-parameter constraints are satisfied
#                 FALSE:
#                       otherwise
function ft_check_control_type(string $str = "")
{
    if ($str == "")
        return TRUE;
    $var_arr = array(
        "Homework",
        "Exam"
    );
    if (!in_array($str,$var_arr))
        throw new InvalidJsonValues("Invalid control_type");
    return TRUE;
}

function ft_check_bigtext(string $name = "")
{
    if ($name == "") {
        throw new InvalidJsonValues('Empty JSON');
    }
    if (strlen($name) > 255 || strlen($name) < 1) {
        throw new InvalidJsonValues('Invalid text lenght');
    }
    return TRUE;
}

?>