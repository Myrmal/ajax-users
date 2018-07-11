<?php
include('MysqlClass.php');
include('FilterData.php');
$db = new MysqlClass();
$filter = new FilterData();

$error = false;

$dataName = $_POST["dataName"];
$id = $_POST["id"];
$value = $_POST["value"];

$dataName = $filter->filterName($dataName);
$id = $filter->filterNumbers($id);
$value = $filter->filterName($value);

if ($error)
{
    if ($dataName === 'new_city')
    {
        $db->resultCitiesTable();
    }
    else $db->resultUsersTable();
}
else {
    $db ->changeData($dataName, $id, $value);
    if ($dataName === 'new_city')
    {
        $db->resultCitiesTable();
    }
    else $db ->resultUsersTable();
}