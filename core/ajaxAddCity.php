<?php
include('MysqlClass.php');
include('FilterData.php');
$db = new MysqlClass();
$filter = new FilterData();

$error = false;

if (empty($_POST["city"]))
{
    $error = true;
}
else {
    $city = $_POST["city"];
    $city = $filter->filterName($city);
}

if ($error == true)
{
    $db->resultCitiesTable();
}else {
    $db ->insertIntoTableCity($city);
    $db->resultCitiesTable();
}