<?php
ini_set('display_errors', 1);

include 'insert_subject.php';
include 'delete_subject.php';
include 'update_subject.php';
include 'get_subjects.php';

try
{
    if (!isset($_POST['type']))
    {
        throw new InvalidJsonValues("Invalid request type");
    }
    switch ($_POST['type'])
    {
        case "POST":
#curl -d "type=POST&login=test_ped_1&pass=pedago_pass&name=pedago&surname=sur_pedago&sOp=alse" localhost/t_users/CRUD_user.php 
            insert_subject($_POST);
            break;
        case "PATCH":
#curl -d "type=PATCH&login=monitoring_login&pass=monitoring&name=test_1" localhost/t_users/CRUD_user.php
            patch_subject($_POST);
            break;
        case "DELETE":
#curl -d "type=DELETE&login=test_ped_1" localhost/t_users/CRUD_user.php 
            delete_subject($_POST);
            break;
        case "GET":
#curl -d "type=GET&login=monitoring_login" localhost/t_users/CRUD_user.php
            $info = get_subject($_POST);
            if (isset($info[0]))
                $info_arr = $info;
            break;
        case "GETALL":
#curl -d "type=GETALL&sOp=true" localhost/t_users/CRUD_user.php
            $info_arr = get_all($_POST); 
            break;
        default:
            throw new InvalidJsonValues("Invalid request type");
            break;
    }
    echo "200". PHP_EOL;
    echo "Success" . PHP_EOL;
    echo $_POST['type'] . PHP_EOL;
    if (isset($info) && !isset($info_arr))
    {
        foreach ($info as $key => $value)
        {
            echo $key . ": " . $value . "&";
        }
    }
    if (isset($info_arr))
    {
        foreach ($info_arr as $key => $value)
        {
            echo  "[ ";

            foreach ($value as $key_1 => $value_1)
            {
                echo $key_1 . ": " . $value_1 . "&";
            }
            echo "]&";
        }
    }
}  catch (InvalidQuery $err)
{
    echo "302". PHP_EOL;
    echo "InvalidQuery: ", $err->getMessage(), "\n";
    echo $_POST['type'] . PHP_EOL;
    exit(1);
}
catch(InvalidJsonValues $err)
{
    echo "301". PHP_EOL;
    echo "InvalidJsonValues: ", $err->getMessage(), "\n";
    echo $_POST['type'] . PHP_EOL;
    exit (1);
}

?>
