<?php require_once('Connections/expenses.php'); ?>
<?php
mysql_select_db($database_expenses, $expenses);
$query_listCompanies = "SELECT * FROM company ORDER BY company.c_name";
$listCompanies = mysql_query($query_listCompanies, $expenses) or die(mysql_error());
$row_listCompanies = mysql_fetch_assoc($listCompanies);
$totalRows_listCompanies = mysql_num_rows($listCompanies);



?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>List Companies</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="main.css" rel="stylesheet" type="text/css">
</head>

<body class="sitemain">
<?php include('navbar.php'); ?>
<p>List Companies </p>
<table border="0">
  <tr>
    <td>ID</td>
    <td>NAME</td>
    <td>DISTANCE</td>
	<td>PHONE</td>
    <td>COMMENT</td>
  </tr>
  <?php do { 
  //split up the phone number to make it prettier
  $rawphone = $row_listCompanies['c_phone'];
  $phone_a = substr($rawphone, 0, 3);
  $phone_p = substr($rawphone, 3, 3);
  $phone_n = substr($rawphone, 6, 4);
  if ($rawphone) {
  	$phoneNumber = "($phone_a) $phone_p-$phone_n"; 
  } else { 
  	$phoneNumber = "";
  }
  ?>
  
  <tr>
    <td><a href="company_edit.php?COMPID=<?php echo $row_listCompanies['c_id']; ?>"><?php echo $row_listCompanies['c_id']; ?></a></td>
    <td><a href="company_edit.php?COMPID=<?php echo $row_listCompanies['c_id']; ?>"><?php echo $row_listCompanies['c_name']; ?></a></td>
    <td><?php echo $row_listCompanies['c_distance']; ?> km</td>
	<td><?php echo $phoneNumber; ?></td>
    <td><?php echo $row_listCompanies['c_comment']; ?></td>
  </tr>
  <?php } while ($row_listCompanies = mysql_fetch_assoc($listCompanies)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($listCompanies);
?>
