<?php
include('db.php');
include('function.php');

if(isset($_POST["member_id"]))
{
    $statement = $connection->prepare(
        "DELETE FROM member WHERE id = :id"
    );
    $result = $statement->execute(
        array(
            ':id' => $_POST["member_id"]
        )
    );

    if(!empty($result))
    {
        echo 'Data Deleted';
    }
    else
    {
        echo 'Error';
    }
}


?>