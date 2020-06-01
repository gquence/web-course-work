<?php

include_once 'db_common.php';
include_once 't_users/validator.php';
include_once 't_subjects/validator.php';

function ft_auth(string $in_login, string $in_password)
{
    if (($in_login == '') || ($in_password == ''))
        return FALSE;
    ft_check_login($in_login);
    ft_check_password($in_password);
    $query_res = ft_db_select('login, password_salt , password_hash ', 't_users', "login = '" . $in_login . "'");
    if (is_null($query_res))
    {
        throw new InvalidJsonValues("no such user - " . $in_login);
        exit(1);
    }
    $in_hash = substr("SHA-512: ".crypt($in_password, $query_res[0]['password_salt']), 9);
    #echo $query_res[0]['password_hash'], $in_hash;
    if (!hash_equals($query_res[0]['password_hash'], $in_hash))
    {
        throw new InvalidJsonValues("wrong password");
        exit(1);
    }
    return TRUE;
}

function ft_gen_salt()
{
    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    return substr(str_shuffle($permitted_chars), 0, 16);
}
?>
