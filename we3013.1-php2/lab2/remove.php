<?php
require_once 'Category.php';
$id = $_GET['id'];
Category::destroy($id);
header("location: index.php");

?>