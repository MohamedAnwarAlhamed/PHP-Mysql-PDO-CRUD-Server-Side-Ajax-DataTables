<?php
include('db.php');
include('function.php');
$query = '';
$output = array();
$query .= 'SELECT * FROM member ';

// echo $_POST['search']['value'];

if(isset($_POST["search"]["value"]))
{
    $query .= 'WHERE name LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR email LIKE "%'.$_POST["search"]["value"].'%" ';
} 

if(isset($_POST["order"]))
{
    $query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
    $query .= 'ORDER BY id ASC ';
}

if($_POST["length"] != -1)
{
    $query .= 'limit '.$_POST["start"]. ', '.$_POST["length"];
}

$statement = $connection->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$data = array();
$filtered_rows = $statement->rowCount();
// echo '<pre>';
// print_r($result);
// echo '</pre>';
foreach($result as $row)
{
    $sub_array = array();

    $sub_array[] = $row['id'];
    $sub_array[] = $row['name'];
    $sub_array[] = $row['email'];
    $sub_array[] = $row['phone'];
    $sub_array[] = '<button type="button" name="update" id="'.$row["id"].'" class="btn btn-primary btn-sm update"><i class="glyphicon glyphicon glyphicon-pencil"></i>Edit</button>';
    $sub_array[] = '<button type="button" name"delete" id="'.$row['id'].'" class="btn btn-danger btn-sm delete">Delete</button>';
    // echo '<pre>';
    // print_r($sub_array);
    // echo '</pre>';
    $data[] = $sub_array;
}

// echo '<pre>';
// print_r($data);
// echo '</pre>';

$output = array(
    "draw" => intval($_POST["draw"]),
    "recordsTotal" => $filtered_rows,
    "recordsFiltered" => get_total_all_records(),
    "data" => $data
);

echo json_encode($output);
?>