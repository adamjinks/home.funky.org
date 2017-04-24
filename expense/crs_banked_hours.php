<?php require_once('Connections/expenses.php'); ?>
<?php



mysql_select_db($database_expenses, $expenses);
$query_listCompanies = "SELECT company.c_id, company.c_name FROM company ORDER BY company.c_name";
$listCompanies = mysql_query($query_listCompanies, $expenses) or die(mysql_error());
$row_listCompanies = mysql_fetch_assoc($listCompanies);
$totalRows_listCompanies = mysql_num_rows($listCompanies);

mysql_select_db($database_expenses, $expenses);
$query_listBankedTypes = "SELECT bhtypes.bhtID, bhtypes.bhtName FROM bhtypes ORDER BY bhtypes.bhtName";
$listBankedTypes = mysql_query($query_listBankedTypes, $expenses) or die(mysql_error());
$row_listBankedTypes = mysql_fetch_assoc($listBankedTypes);
$totalRows_listBankedTypes = mysql_num_rows($listBankedTypes);

mysql_select_db($database_expenses, $expenses);
$query_listMaxDate = "SELECT MAX(bankedhours.bhDate) AS MaxDate FROM bankedhours";
$listMaxDate = mysql_query($query_listMaxDate, $expenses) or die(mysql_error());
$row_listMaxDate = mysql_fetch_assoc($listMaxDate);
$totalRows_listMaxDate = mysql_num_rows($listMaxDate);

mysql_select_db($database_expenses, $expenses);
$query_listMinDate = "SELECT MIN(bankedhours.bhDate) AS MinDate FROM bankedhours";
$listMinDate = mysql_query($query_listMinDate, $expenses) or die(mysql_error());
$row_listMinDate = mysql_fetch_assoc($listMinDate);
$totalRows_listMinDate = mysql_num_rows($listMinDate);

mysql_select_db($database_expenses, $expenses);
$query_listAllDates = "SELECT bankedhours.bhDate FROM bankedhours ORDER BY bankedhours.bhDate";
$listAllDates = mysql_query($query_listAllDates, $expenses) or die(mysql_error());
$row_listAllDates = mysql_fetch_assoc($listAllDates);
$totalRows_listAllDates = mysql_num_rows($listAllDates);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Banked Hours</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="main.css" rel="stylesheet" type="text/css">
</head>

<body class="sitemain">

<p><?php include('navbar.php'); ?></p>
<form action="crs_banked_hours_total.php" method="post" name="chooseData" id="chooseData">
  <table border="0" width=600>
    <tr align="left" valign="top" class="tableColumnTitle">
      <td colspan="6">Select your options to limit data </td>
    </tr>
    <tr align="left" valign="top">
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr align="left" valign="top">
      <td>Company</td>
      <td><select name="company" size="6" class="sitemain" id="company">
	  <option value="0" selected>ANY</option>
        <?php
do {  
?>
        <option value="<?php echo $row_listCompanies['c_id']?>"><?php echo $row_listCompanies['c_name']?></option>
        <?php
} while ($row_listCompanies = mysql_fetch_assoc($listCompanies));
  $rows = mysql_num_rows($listCompanies);
  if($rows > 0) {
      mysql_data_seek($listCompanies, 0);
	  $row_listCompanies = mysql_fetch_assoc($listCompanies);
  }
?>
      </select></td>
      <td>Start Date </td>
      <td><select name="startDate" size="6" class="sitemain" id="startDate">
        <?php
do {  
?>
        <option value="<?php echo $row_listAllDates['bhDate']?>"<?php if (!(strcmp($row_listAllDates['bhDate'], $row_listMinDate['MinDate']))) {echo "SELECTED";} ?>><?php echo $row_listAllDates['bhDate']?></option>
        <?php
} while ($row_listAllDates = mysql_fetch_assoc($listAllDates));
  $rows = mysql_num_rows($listAllDates);
  if($rows > 0) {
      mysql_data_seek($listAllDates, 0);
	  $row_listAllDates = mysql_fetch_assoc($listAllDates);
  }
?>
      </select></td>
      <td>End Date </td>
      <td><select name="endDate" size="6" class="sitemain" id="endDate">
        <?php
do {  
?>
        <option value="<?php echo $row_listAllDates['bhDate']?>"<?php if (!(strcmp($row_listAllDates['bhDate'], $row_listMaxDate['MaxDate']))) {echo "SELECTED";} ?>><?php echo $row_listAllDates['bhDate']?></option>
        <?php
} while ($row_listAllDates = mysql_fetch_assoc($listAllDates));
  $rows = mysql_num_rows($listAllDates);
  if($rows > 0) {
      mysql_data_seek($listAllDates, 0);
	  $row_listAllDates = mysql_fetch_assoc($listAllDates);
  }
?>
      </select></td>
    </tr>
    <tr align="left" valign="top">
      <td>Type</td>
      <td><select name="type" class="sitemain" id="type">
	  <option value="0" selected>ANY</option>
        <?php
do {  
?>
        <option value="<?php echo $row_listBankedTypes['bhtID']?>"><?php echo $row_listBankedTypes['bhtName']?></option>
        <?php
} while ($row_listBankedTypes = mysql_fetch_assoc($listBankedTypes));
  $rows = mysql_num_rows($listBankedTypes);
  if($rows > 0) {
      mysql_data_seek($listBankedTypes, 0);
	  $row_listBankedTypes = mysql_fetch_assoc($listBankedTypes);
  }
?>
      </select></td>
      <td>Time</td>
      <td><select name="time" class="sitemain" id="time">
        <option value="0">ANY</option>
        <option value="1">Positive</option>
        <option value="2">Negative</option>
      </select></td>
      <td>&nbsp;</td>
      <td><input name="Submit" type="submit" class="sitemain" value="Submit"></td>
    </tr>
    <tr align="left" valign="top">
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($listCompanies);

mysql_free_result($listBankedTypes);

mysql_free_result($listMaxDate);

mysql_free_result($listMinDate);

mysql_free_result($listAllDates);
?>
