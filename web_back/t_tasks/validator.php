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
    if (strlen($name) > 40 || strlen($name) < 0) {
        throw new InvalidJsonValues('Invalid correct answer lenght');
    }
    return TRUE;
}

function ft_check_ans(string $name = "")
{
    if ($name == "") {
        throw new InvalidJsonValues('Empty JSON');
    }
    if (strlen($name) < 2 || (preg_match_all("{[a-zA-Z0-9_]*[,]?}i", $name) == 0)) {
        throw new InvalidJsonValues('Invalid answers format');
    }
    return TRUE;
}

function ft_check_bigtexttasks(string $name = "")
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