<?php

class InvalidQuery extends Exception { }

$db_params = "user=gquence password=aspid0911 dbname=lms_db";


#return values: false:
#                       NULL src_db or where_statement
#                       empty result of src_db or db_query
#                       src_db or where_statement are empty string 
#               true:
#                       not empty result of db_query
function ft_db_select_check(string $src_db, string $where_statement)
{
    if ((!isset($src_db)) || (!isset($where_statement)) || ($src_db == '') || ($where_statement == ''))
        return FALSE;
    $resource = pg_connect("user=gquence password=aspid0911 dbname=lms_db");
    if (!$resource)
    {
        throw new InvalidQuery("DB connection error");
    }

    $query = "select * from " . $src_db . " where " . $where_statement; 
    $result = pg_query($resource, $query);

    if (!$result)
    {
        throw new InvalidQuery(("Query error. Query = " . $query));
    }
    $arr = pg_fetch_all($result);
    if (is_bool($arr))
    {
        return FALSE;
    }
    pg_close($resource);
    return TRUE;
}

#return values: NULL:
#                       NULL src_db or where_statementor select_statement
#                       empty result of db_query
#                       src_db or where_statement or select_statementare empty string
#               arr_res:
#                       not empty result of db_query
function ft_db_select(string $select_statement,string $src_db, string $where_statement)
{
    if ((!isset($src_db)) || (!isset($where_statement)) || (!isset($select_statement)) || ($src_db == '') || ($select_statement == ''))
        return NULL;
    $resource = pg_connect("user=gquence password=aspid0911 dbname=lms_db");
    if (!$resource)
    {
        throw new InvalidQuery("DB connection error");
    }

    $query = "select ". $select_statement . " from " . $src_db ; 
    if  ($where_statement !== '')
    {
        $query = $query . " where " . $where_statement;
    }
    $result = pg_query($resource, $query);

    if (!$result)
    {
        throw new InvalidQuery(("Query error. Query = " . $query));
    }
    $arr = pg_fetch_all($result);
    if (is_bool($arr))
    {
        return NULL;
    }
    pg_close($resource);
    return $arr;
}


#return values: false:
#                       NULL src_db or where_statement
#                       src_db or where_statement are empty string
#               true:
#                       not empty result of db_query
function ft_db_delete(string $src_db, string $where_statement)
{
    if ((!isset($src_db)) || (!isset($where_statement)) ||  ($src_db == '') || ($where_statement == ''))
        return FALSE;
    $resource = pg_connect("user=gquence password=aspid0911 dbname=lms_db");
    if (!$resource)
    {
        throw new InvalidQuery("DB connection error");
    }

    $query = "delete from " . $src_db . " where " . $where_statement; 
    $result = pg_query($resource, $query);

    if (!$result)
    {
        throw new InvalidQuery(("Query error. Query = " . $query));
    }
    pg_close($resource);
    return TRUE;
}

#return values: false:
#                       NULL src_db or where_statement or set_statement
#                       src_db or where_statement or set_statement are empty string
#               true:
#                       not empty result of db_query
function ft_db_update(string $src_db, string $set_statement, string $where_statement)
{
    if ((!isset($src_db)) || (!isset($set_statement)) ||  (!isset($where_statement)) || ($src_db == '') || ($set_statement == '') ||($where_statement == ''))
        return FALSE;
    $resource = pg_connect("user=gquence password=aspid0911 dbname=lms_db");
    if (!$resource)
    {
        throw new InvalidQuery("DB connection error");
    }

    $query = "UPDATE " . $src_db . " set " . $set_statement . " where " . $where_statement; 
    $result = pg_query($resource, $query);
    if (!$result)
    {
        throw new InvalidQuery(("Query error. Query = " . $query));
    }
    pg_close($resource);
    return TRUE;
}


#return values: false:
#                       NULL src_db or fields or values
#                       src_db or fields or values are empty string
#               true:
#                       not empty result of db_query
function ft_db_insert(string $src_db, string $fields, string $values)
{
    if ((!isset($src_db)) || (!isset($fields))|| (!isset($values)))
        return FALSE;
    if (($src_db == '') || ($fields == '') || ($values == ''))
        return FALSE;
    $resource = pg_connect("user=gquence password=aspid0911 dbname=lms_db");
    if (!$resource)
    {
        throw new InvalidQuery("DB connection error");
    }

    $query = "INSERT INTO " . $src_db ." (" . $fields . ") VALUES (" . $values . ");"; 
    $result = pg_query($resource, $query);

    if (!$result)
    {
        throw new InvalidQuery(("Query error. Query = " . $query));
    }
    
    pg_close($resource);
    return TRUE;
}

?>