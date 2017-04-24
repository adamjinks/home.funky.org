<?php require_once('Connections/expenses.php'); ?>
<?php
mysql_select_db($database_expenses, $expenses);
$query_FirstDate = "SELECT MIN(v_date) FROM vehicle";
$FirstDate = mysql_query($query_FirstDate, $expenses) or die(mysql_error());
$row_FirstDate = mysql_fetch_assoc($FirstDate);
$totalRows_FirstDate = mysql_num_rows($FirstDate);

mysql_select_db($database_expenses, $expenses);
$query_LastDate = "SELECT MAX(v_date) FROM vehicle";
$LastDate = mysql_query($query_LastDate, $expenses) or die(mysql_error());
$row_LastDate = mysql_fetch_assoc($LastDate);
$totalRows_LastDate = mysql_num_rows($LastDate);

mysql_select_db($database_expenses, $expenses);
$query_AllDates = "SELECT v_date FROM vehicle ORDER BY v_date ASC";
$AllDates = mysql_query($query_AllDates, $expenses) or die(mysql_error());
$row_AllDates = mysql_fetch_assoc($AllDates);
$totalRows_AllDates = mysql_num_rows($AllDates);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>View Gas Data</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="main.css" rel="stylesheet" type="text/css">
</head>

<body bgcolor="#EEEEEE" text="#000066" class=".sitemain">
<p><?php include('navbar.php'); ?></p>
<form action="vehicle_gas_view2.php" method="post" enctype="application/x-www-form-urlencoded" name="ViewDateRange">
 <p class="sitemain">Start Date
   <select name="StartDate" size="5">
     <?php
do {  
?>
     <option value="<?php echo $row_AllDates['v_date']?>" <?php if (!(strcmp($row_AllDates['v_date'], $row_FirstDate['MIN(v_date)']))) {echo "SELECTED";} ?> ><?php echo $row_AllDates['v_date']?></option>
     <?php
} while ($row_AllDates = mysql_fetch_assoc($AllDates));
  $rows = mysql_num_rows($AllDates);
  if($rows > 0) {
      mysql_data_seek($AllDates, 0);
	  $row_AllDates = mysql_fetch_assoc($AllDates);
  }
?>
   </select>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;End Date
<select name="EndDate" size="5" id="EndDate">
      <?php
do {  
?>
      <option value="<?php echo $row_AllDates['v_date']?>" <?php if (!(strcmp($row_AllDates['v_date'], $row_LastDate['MAX(v_date)']))) {echo "SELECTED";} ?> ><?php echo $row_AllDates['v_date']?></option>
      <?php
} while ($row_AllDates = mysql_fetch_assoc($AllDates));
  $rows = mysql_num_rows($AllDates);
  if($rows > 0) {
      mysql_data_seek($AllDates, 0);
	  $row_AllDates = mysql_fetch_assoc($AllDates);
  }
?>
   </select>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input class="sitemain" type="submit" name="Submit" value="Submit"> 
 </p>
</form>
 <p>&nbsp;</p>
 <p class="sitemain">Highest Gas Price</p>
 <p><span class="sitemain">Lowest Gas Price </span> </p>
</body>

</html>
<?php
mysql_free_result($FirstDate);

mysql_free_result($LastDate);

mysql_free_result($AllDates);
?>
