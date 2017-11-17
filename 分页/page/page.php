<?php

//根据页面调取数据
$page = isset($_GET["page"])?$_GET["page"]:1;

//获取每页调取的条数
$num = 3;



$con = mysqli_connect("localhost", "root", "root", "huaban");
$arr =array();
$data = array("countpage"=>1,"list"=>$arr,"page"=>$page);
if(!$con){
    echo json_encode($data);
    exit();
}

mysqli_set_charset($con, "utf8");

$start = ($page-1)*$num;

//查询每页的内容
$sql = "select * from image limit {$start},{$num}";

$result = mysqli_query($con, $sql);

if(!$result){
    echo json_encode($data);
    exit();
}

while($row = mysqli_fetch_assoc($result)){
    $arr[] = $row;
}

//总页数
$sql = "select count(*) as num from image";
$result = mysqli_query($con,$sql);
$row = mysqli_fetch_assoc($result);
$count = $row["num"];

$countpage = ceil($count/$num);

$data = array("countpage"=>$countpage,"list"=>$arr,"page"=>$page);
echo json_encode($data);
