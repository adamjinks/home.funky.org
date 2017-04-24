<?php require_once('Connections/expenses.php'); ?>
<?php

$mileage = $_POST['mileage'];
$date = $_POST['date'];
$price = $_POST['price'];
$litres = $_POST['litres'];
$company = $_POST['company'];
$comment = $_POST['comment'];

mysql_select_db($database_expenses, $expenses); 
$query_gasload = "INSERT INTO vehicle (v_mileage,v_date,v_price,v_litres,c_id,v_comment) VALUES ('$mileage','$date','$price','$litres','$company','$comment');";

$gasload = mysql_query($query_gasload, $expenses) or die(mysql_error());


?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>LOAD GAS DATA</title>
<link href="main.css" rel="stylesheet" type="text/css">
</head>

<body class="sitemain">
<p><?php include('navbar.php'); ?></p>
<p>date: <?php echo $date; ?> </p>
<p>mileage: <?php echo $mileage; ?></p>
<p>price: <?php echo $price; ?></p>
<p>litres: <?php echo $litres; ?></p>
<p>cid: <?php echo $company; ?></p>
<p>comment: <?php echo $comment; ?></p>
<p>&nbsp;</p>


</body>
</html>
