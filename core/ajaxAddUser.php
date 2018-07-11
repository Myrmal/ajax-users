<?php
include('MysqlClass.php');
include('FilterData.php');
$db = new MysqlClass();
$filter = new FilterData();

$error = false;

if (empty($_POST["name"]) || empty($_POST["age"]))
{
    $error = true;
}
else {
    $name = $_POST["name"];
    $name = $filter->filterName($name);
    $age = $_POST["age"];
    $age = $filter->filterNumbers($age);
    $city = $_POST["city"];
    $city = $filter->filterName($city);
}

if ($error)
{
    $db->resultUsersTable();
}else {
    $db ->insertIntoTable($name,$age, $city);
    $db->resultUsersTable();
}