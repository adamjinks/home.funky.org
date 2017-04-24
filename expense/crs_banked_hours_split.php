<?php require_once('Connections/expenses.php'); ?>
<?php
mysql_select_db($database_expenses, $expenses);
$query_totalCurrent = "SELECT ROUND((SUM(bhTime))/7.5,2) AS totalCurrentDays, ROUND(SUM(bhTime),2) AS totalCurrentHours FROM bankedhours ";
$totalCurrent = mysql_query($query_totalCurrent, $expenses) or die(mysql_error());
$row_totalCurrent = mysql_fetch_assoc($totalCurrent);
$totalRows_totalCurrent = mysql_num_rows($totalCurrent);

mysql_select_db($database_expenses, $expenses);
$query_lieuCurrent = "SELECT  ROUND((SUM(bhTime))/7.5,2) AS lieuCurrentDays, ROUND(SUM(bhTime),2) AS lieuCurrentHours FROM bankedhours  WHERE bhType=2";
$lieuCurrent = mysql_query($query_lieuCurrent, $expenses) or die(mysql_error());
$row_lieuCurrent = mysql_fetch_assoc($lieuCurrent);
$totalRows_lieuCurrent = mysql_num_rows($lieuCurrent);

mysql_select_db($database_expenses, $expenses);
$query_vacationCurrent = "SELECT  ROUND((SUM(bhTime))/7.5,2) AS vacationCurrentDays, ROUND(SUM(bhTime),2) AS vacationCurrentHours FROM bankedhours  WHERE bhType=1";
$vacationCurrent = mysql_query($query_vacationCurrent, $expenses) or die(mysql_error());
$row_vacationCurrent = mysql_fetch_assoc($vacationCurrent);
$totalRows_vacationCurrent = mysql_num_rows($vacationCurrent);

$maxRows_listVacation = 20;
$pageNum_listVacation = 0;
if (isset($_GET['pageNum_listVacation'])) {
  $pageNum_listVacation = $_GET['pageNum_listVacation'];
}
$startRow_listVacation = $pageNum_listVacation * $maxRows_listVacation;

mysql_select_db($database_expenses, $expenses);
$query_listVacation = "SELECT *, (SELECT bhtName FROM bhtypes WHERE bankedhours.bhType=bhtypes.bhtID) AS bhtName FROM bankedhours WHERE bhType=1 ORDER BY bankedhours.bhDate DESC";
$query_limit_listVacation = sprintf("%s LIMIT %d, %d", $query_listVacation, $startRow_listVacation, $maxRows_listVacation);
$listVacation = mysql_query($query_limit_listVacation, $expenses) or die(mysql_error());
$row_listVacation = mysql_fetch_assoc($listVacation);

if (isset($_GET['totalRows_listVacation'])) {
  $totalRows_listVacation = $_GET['totalRows_listVacation'];
} else {
  $all_listVacation = mysql_query($query_listVacation);
  $totalRows_listVacation = mysql_num_rows($all_listVacation);
}
$totalPages_listVacation = ceil($totalRows_listVacation/$maxRows_listVacation)-1;

$maxRows_listLieu = 30;
$pageNum_listLieu = 0;
if (isset($_GET['pageNum_listLieu'])) {
  $pageNum_listLieu = $_GET['pageNum_listLieu'];
}
$startRow_listLieu = $pageNum_listLieu * $maxRows_listLieu;

mysql_select_db($database_expenses, $expenses);
$query_listLieu = "SELECT *, (SELECT bhtName FROM bhtypes WHERE bankedhours.bhType=bhtypes.bhtID) AS bhtName, (SELECT c_name FROM company WHERE bankedhours.bhCompany=company.c_id) AS cName FROM bankedhours WHERE bhType=2 ORDER BY bankedhours.bhDate DESC";
$query_limit_listLieu = sprintf("%s LIMIT %d, %d", $query_listLieu, $startRow_listLieu, $maxRows_listLieu);
$listLieu = mysql_query($query_limit_listLieu, $expenses) or die(mysql_error());
$row_listLieu = mysql_fetch_assoc($listLieu);

if (isset($_GET['totalRows_listLieu'])) {
  $totalRows_listLieu = $_GET['totalRows_listLieu'];
} else {
  $all_listLieu = mysql_query($query_listLieu);
  $totalRows_listLieu = mysql_num_rows($all_listLieu);
}
$totalPages_listLieu = ceil($totalRows_listLieu/$maxRows_listLieu)-1;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Lieu/Vacation Data</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="main.css" rel="stylesheet" type="text/css">
<link href="general.css" rel="stylesheet" type="text/css">
</head>

<body class="sitemain">
<p>
  <?php include('navbar.php'); ?></p>
<table width="800" border="0" cellpadding="4" cellspacing="0">
  <tr  class="tableColumnTitle">
    <td colspan="9">Total Hours </td>
  </tr>
  <tr align="center"  class="tableColumnTitle">
    <td colspan="3">Vacation</td>
    <td colspan="3">Time In Lieu </td>
    <td colspan="3">Combined</td>
  </tr>
  <tr  class="tableColumnTitle">
    <td>&nbsp;</td>
    <td>Days</td>
    <td>Hours</td>
    <td>&nbsp;</td>
    <td>Days</td>
    <td>Hours</td>
    <td>&nbsp;</td>
    <td>Days</td>
    <td>Hours</td>
  </tr>
  <tr>
    <td>Current</td>
    <td><font color="#FF0000""><?php echo $row_vacationCurrent['vacationCurrentDays']; ?></font></td>
    <td><?php echo $row_vacationCurrent['vacationCurrentHours']; ?></td>
    <td>Current</td>
    <td><font color="#FF0000"><?php echo $row_lieuCurrent['lieuCurrentDays']; ?></font></td>
    <td><?php echo $row_lieuCurrent['lieuCurrentHours']; ?></td>
    <td>Current</td>
    <td><font color="#FF0000"><?php echo $row_totalCurrent['totalCurrentDays']; ?></font></td>
    <td><?php echo $row_totalCurrent['totalCurrentHours']; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
</table>
<br>
</p>
<table border="0" cellpadding="3" cellspacing="0">
  <tr align="left" valign="top"  class="tableColumnTitle">
    <td colspan="7">Time In Lieu (last 30 entries) </td>
  </tr>
    <tr align="left" valign="top"  class="tableColumnTitle">
    <td>ID</td>
    <td>DATE</td>
    <td>TYPE</td>
    <td>COMPANY</td>
    <td>TIME</td>
    <td>PAID</td>
    <td>INFO</td>
  </tr>
  <?php $rowHighlight = "tableRowLight";
  do { 
  	if ($rowHighlight == "tableRowLight") {$rowHighlight = "tableRowDark";} else {$rowHighlight = "tableRowLight";}
	$rowInfo = substr($row_listLieu['bhInfo'],0,60);
  ?>
  <tr align="left" valign="top" class="<?php echo $rowHighlight; ?>">
    <td><a href="crs_banked_hours_edit.php?BHID=<?php echo $row_listLieu['bhID']; ?>"><?php echo $row_listLieu['bhID']; ?></a></td>
    <td><?php echo $row_listLieu['bhDate']; ?></td>
    <td><?php echo $row_listLieu['bhtName']; ?></td>
    <td><?php echo $row_listLieu['cName']; ?></td>
    <td><?php echo $row_listLieu['bhTime']; ?></td>
    <td><?php echo $row_listLieu['bhPaid']; ?></td>
    <td><?php echo $rowInfo; ?></td>
  </tr>
  <?php } while ($row_listLieu = mysql_fetch_assoc($listLieu)); ?>
</table>
<p>&nbsp;</p>

<table border="0" cellpadding="3" cellspacing="0">
  <tr align="left" valign="top" class="tableColumnTitle">
    <td colspan="5">Vacation (last 20 entries) </td>
  </tr>
    <tr align="left" valign="top"  class="tableColumnTitle">
    <td>ID</td>
    <td>DATE</td>
    <td>TYPE</td>
    <td>TIME</td>
    <td>INFO</td>
  </tr>
  <?php $rowHighlight = "tableRowLight";
  do { 
  	if ($rowHighlight == "tableRowLight") {$rowHighlight = "tableRowDark";} else {$rowHighlight = "tableRowLight";}
  ?>
  <tr align="left" valign="top" class="<?php echo $rowHighlight; ?>">
    <td><a href="crs_banked_hours_edit.php?BHID=<?php echo $row_listVacation['bhID']; ?>"><?php echo $row_listVacation['bhID']; ?></a></td>
    <td><?php echo $row_listVacation['bhDate']; ?></td>
    <td><?php echo $row_listVacation['bhtName']; ?></td>
    <td><?php echo $row_listVacation['bhTime']; ?></td>
    <td><?php echo $row_listVacation['bhInfo']; ?></td>
  </tr>
  <?php } while ($row_listVacation = mysql_fetch_assoc($listVacation)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($totalCurrent);

mysql_free_result($lieuCurrent);

mysql_free_result($vacationCurrent);

mysql_free_result($listVacation);

mysql_free_result($listLieu);
?>
