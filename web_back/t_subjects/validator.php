<?php


include_once '../ERRS.php';
#   COMMON DESCRIPTION:
#   return values: 
#                 TRUE:
#                       all db-parameter constraints are satisfied
#                 FALSE:
#                       otherwise

function ft_check_id(string $in_id)
{
    if (!ctype_digit($in_id))
        throw new InvalidJsonValues('id must be positive int');

    $in_id = intval($in_id);
    if ($in_id != abs($in_id))
    {
        throw new InvalidJsonValues('id must be positive int');
    }
    return true;
}


function ft_check_subjname(string $name = "")
{
    if ($name == "") {
        throw new InvalidJsonValues('Empty JSON');
    }
    if (strlen($name) > 30 || strlen($name) < 4) {
        throw new InvalidJsonValues('Invalid name lenght');
    }
    return TRUE;
}

function ft_check_subdescr(string $name = "")
{
    if ($name == "") {
        throw new InvalidJsonValues('Empty JSON');
    }
    if (strlen($name) > 100 || strlen($name) < 1) {
        throw new InvalidJsonValues('Invalid name lenght');
    }
    return TRUE;
}

?>