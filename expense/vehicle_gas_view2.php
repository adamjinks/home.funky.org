<?php require_once('Connections/expenses.php'); ?>
<?php require_once('Connections/functions.php'); ?>
<?php //convert vars
$StartDate = $_POST[StartDate];
$EndDate = $_POST[EndDate];
?>
<?php $date = checkDates($StartDate,$EndDate); ?>

<?php
mysql_select_db($database_expenses, $expenses);
$query_ViewDateRange = "SELECT * FROM vehicle,company WHERE vehicle.c_id=company.c_id AND v_date >= '$date[0]' AND v_date <= '$date[1]' ORDER BY v_date";
$ViewDateRange = mysql_query($query_ViewDateRange, $expenses) or die(mysql_error());
$row_ViewDateRange = mysql_fetch_assoc($ViewDateRange);
$totalRows_ViewDateRange = mysql_num_rows($ViewDateRange);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>View Date Range</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link href="main.css" rel="stylesheet" type="text/css">
</head>

<body class="sitemain">

<p><?php include('navbar.php'); ?></p>
<p>DATES: Start:<? echo $date[0]; ?> End:<? echo $date[1]; ?></p>
<p>&nbsp;</p>

<table border="0">
  <tr class="headings">
    <td><span>Date</span></td>
    <td><span>Mileage</span></td>
    <td><span>Total</span></td>
    <td><span>Price/L</span></td>
    <td><span>Litres</span></td>
    <td><span>Vendor</span></td>
    <td><span>Comment</span></td>
  </tr>
  <?php do { ?>
  <tr>
    <td><span><a href="vehicle_gas_edit.php?VID=<?php echo $row_ViewDateRange['v_id']; ?>"><?php echo $row_ViewDateRange['v_date']; ?></a></span></td>
    <td><div align="right"><span><?php echo $row_ViewDateRange['v_mileage']; ?> km</span></div></td>
    <td><span>$<?php echo $gasTotal = round((($row_ViewDateRange['v_price'] * $row_ViewDateRange['v_litres'])/1000000),2); ?> </span></td>
    <td><span>$<?php echo $row_ViewDateRange['v_price']/1000; ?></span></td>
    <td><div align="right"><span><?php echo $row_ViewDateRange['v_litres']/1000; ?> L</span></div></td>
    <td><span><?php echo $row_ViewDateRange['c_name']; ?></span></td>
    <td><span><?php echo $row_ViewDateRange['v_comment']; ?></span></td>
  </tr>
  <?php } while ($row_ViewDateRange = mysql_fetch_assoc($ViewDateRange)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($ViewDateRange);
?>
