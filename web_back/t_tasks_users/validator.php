<?php


include_once '../ERRS.php';
#   COMMON DESCRIPTION:
#   return values: 
#                 TRUE:
#                       all db-parameter constraints are satisfied
#                 FALSE:
#                       otherwise


function ft_check_corrans(string $name = "")
{
    if ($name == "") {
        throw new InvalidJsonValues('Empty JSON');
    }
    if (strlen($name) > 40 || strlen($name) < 1) {
        throw new InvalidJsonValues('Invalid correct answer lenght');
    }
    return TRUE;
}
?>