<?php

include_once '../ERRS.php';

#   COMMON DESCRIPTION:
#   return values: 
#                 TRUE:
#                       all db-parameter constraints are satisfied
#                 FALSE:
#                       otherwise

function ft_check_login(string $login)
{
    if (is_string($login) != TRUE) {
        throw new InvalidJsonValues('Invalid login type');
    }
    if (strlen($login) > 30 || strlen($login) < 6) {
        throw new InvalidJsonValues('Invalid login lenght');
    }
    return TRUE;
}

function ft_check_password(string $password)
{
    if (is_string($password) != TRUE) {
        throw new InvalidJsonValues('Invalid password type');
    }
    if (strlen($password) > 32 || strlen($password) < 8) {
        throw new InvalidJsonValues('Invalid password lenght');
    }
    return TRUE;
}

function ft_check_surname(string $surname)
{
    if (is_string($surname) != TRUE) {
        throw new InvalidJsonValues('Invalid surname type');
    }
    if (strlen($surname) > 12) {
        throw new InvalidJsonValues('Invalid surname lenght');
    }
    return TRUE;
}

function ft_check_name(string $name)
{
    if (is_string($name) != TRUE) {
        throw new InvalidJsonValues('Invalid name type');
    }
    if (strlen($name) > 12 || strlen($name) < 6) {
        throw new InvalidJsonValues('Invalid name lenght');
    }
    return TRUE;
}

function ft_check_sOp(bool $sOp)
{
    if (is_bool($sOp) != TRUE) {
        throw new InvalidJsonValues('Invalid sOp type');
    }
    return TRUE;
}



?>