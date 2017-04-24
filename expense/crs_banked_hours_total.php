<?php require_once('Connections/expenses.php'); ?>
<?php
$maxRows_listHours = 4000;
$pageNum_listHours = 0;
if (isset($_GET['pageNum_listHours'])) {
  $pageNum_listHours = $_GET['pageNum_listHours'];
}
$startRow_listHours = $pageNum_listHours * $maxRows_listHours;

// Convert Variables
$company = $_POST['company'];
$startDate = $_POST['startDate'];
$endDate = $_POST['endDate'];
$type = $_POST['type'];
$time = $_POST['time'];

/* for DEBUG
echo "company = $company<br>";
echo "starDate = $startDate<br>";
echo "endDate = $endDate<br>";
echo "type = $type<br>";
echo "time = $time<br>";
*/

// parse incoming variables for SQL string
if ($company != 0) {$companySQL=" AND bhCompany=$company ";} else {$companySQL=" ";}
if ($type != 0) {$typeSQL=" AND bhType=$type ";} else {$typeSQL=" ";}

switch ($time) {
case "0":
    $timeSQL=" ";
    break;
case "1":
    $timeSQL=" AND bhTIme >=0 ";
    break;
case "2":
    $timeSQL=" AND bhTIme < 0 ";
    break;
}





mysql_select_db($database_expenses, $expenses);
$query_listHours = "SELECT *, (SELECT bhtName FROM bhtypes WHERE bankedhours.bhType=bhtypes.bhtID) AS bhtName, (SELECT c_name FROM company WHERE bankedhours.bhCompany=company.c_id) AS cName FROM bankedhours 
WHERE bhDate >= '$startDate' AND bhDate <= '$endDate' $typeSQL $companySQL $timeSQL ORDER BY bankedhours.bhDate DESC";
$query_limit_listHours = sprintf("%s LIMIT %d, %d", $query_listHours, $startRow_listHours, $maxRows_listHours);
$listHours = mysql_query($query_limit_listHours, $expenses) or die(mysql_error());
$row_listHours = mysql_fetch_assoc($listHours);

/* for DEBUG
echo "sql sring: $query_listHours<br>";
*/

if (isset($_GET['totalRows_listHours'])) {
  $totalRows_listHours = $_GET['totalRows_listHours'];
} else {
  $all_listHours = mysql_query($query_listHours);
  $totalRows_listHours = mysql_num_rows($all_listHours);
}
$totalPages_listHours = ceil($totalRows_listHours/$maxRows_listHours)-1;

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
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Overtime Data</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="main.css" rel="stylesheet" type="text/css">

</head>

<body class="sitemain">
<p><?php include('navbar.php'); ?></p>
<table width="800" border="0" cellpadding="4" cellspacing="0">
  <tr class="tableColumnTitle">
    <td colspan="9">Total Hours </td>
  </tr>
  <tr class="tableColumnTitle">
    <td>&nbsp;</td>
    <td colspan="2" align="center">Vacation</td>
    <td>&nbsp;</td>
    <td colspan="2" align="center">Time In Lieu </td>
    <td>&nbsp;</td>
    <td colspan="2" align="center">Combined</td>
  </tr>
  <tr class="tableColumnTitle">
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
<table border="0" cellpadding="4" cellspacing="0">
  <tr class="tableColumnTitle">
    <td>bhID</td>
    <td>Date</td>
    <td>Type</td>
    <td>Company</td>
    <td>Hours</td>
    <td>Paid</td>
    <td>Info</td>
  </tr>
  <?php do { 
  	$rowInfo = substr($row_listHours['bhInfo'],0,60);
  ?>
  <tr>
    <td><a href="crs_banked_hours_edit.php?BHID=<?php echo $row_listHours['bhID']; ?>"><?php echo $row_listHours['bhID']; ?></a></td>
    <td><?php echo $row_listHours['bhDate']; ?></td>
    <td><?php echo $row_listHours['bhtName']; ?></td>
    <td align="right"><?php echo $row_listHours['cName']; ?></td>
    <td align="right"><?php echo $row_listHours['bhTime']; ?></td>
    <td>$<?php echo $row_listHours['bhPaid']; ?></td>
    <td><?php echo $rowInfo; ?></td>
  </tr>
  <?php } while ($row_listHours = mysql_fetch_assoc($listHours)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($listHours);

mysql_free_result($totalCurrent);

mysql_free_result($lieuCurrent);

mysql_free_result($vacationCurrent);
?>
