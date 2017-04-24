<?php require_once('Connections/expenses.php'); ?>
<?php
// Convert Variables
$sortorder = $_GET['sortorder'];
$exptype = $_GET['exptype'];
$expTotals = 0;


$sDate = $_GET['dsYear'] . "-" . $_GET['dsMonth'] . "-" . $_GET['dsDay'];
$eDate = $_GET['deYear'] . "-" . $_GET['deMonth'] . "-" . $_GET['deDay'];
if ($exptype != 0) { $limitType = " AND excType='$exptype' "; }

$maxRows_dataList = 50;
$pageNum_dataList = 0;
if (isset($_GET['pageNum_dataList'])) {
  $pageNum_dataList = $_GET['pageNum_dataList'];
}
$startRow_dataList = $pageNum_dataList * $maxRows_dataList;

mysql_select_db($database_expenses, $expenses);
$query_dataList = "SELECT *, (SELECT extName from expensetype WHERE excType=extID) AS expType, (SELECT c_name from company WHERE c_id=excCompany) AS expCompany FROM expensecrs WHERE excDate >= '$sDate' AND excDate <= '$eDate' $limitType ORDER BY expensecrs.excDate $sortorder";
$query_limit_dataList = sprintf("%s LIMIT %d, %d", $query_dataList, $startRow_dataList, $maxRows_dataList);
$dataList = mysql_query($query_limit_dataList, $expenses) or die(mysql_error());
$row_dataList = mysql_fetch_assoc($dataList);

if (isset($_GET['totalRows_dataList'])) {
  $totalRows_dataList = $_GET['totalRows_dataList'];
} else {
  $all_dataList = mysql_query($query_dataList);
  $totalRows_dataList = mysql_num_rows($all_dataList);
}
$totalPages_dataList = ceil($totalRows_dataList/$maxRows_dataList)-1;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>List Expenses</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="main.css" rel="stylesheet" type="text/css">
</head>

<body class="sitemain">

<p><?php include('navbar.php'); ?></p>
<table border="0" cellpadding="4" cellspacing="0">
  <tr>
    <td class="headings">COMPANY</td>
    <td class="headings">DATE</td>
    <td class="headings">VALUE</td>
    <td class="headings">TYPE</td>
    <td class="headings">W/O</td>
    <td class="headings">DETAIL</td>
  </tr>

  <?php do { ?>
  <?php 
  //display totals
  $expTotal += $row_dataList['excValue'];


  ?>
  <tr>
    <td class="sitemain"><?php echo $row_dataList['expCompany']; ?></td>
    <td><a href="crs_expense_edit.php?EXPID=<?php echo $row_dataList['excID']; ?>" class="sitemain"><?php echo $row_dataList['excDate']; ?></a></td>
    <td class="sitemain"><?php echo $row_dataList['excValue']; ?></td>
    <td class="sitemain"><?php echo $row_dataList['expType']; ?></td>
    <td class="sitemain"><?php echo $row_dataList['excWorkorder']; ?></td>
    <td class="sitemain"><?php echo $row_dataList['excDetail']; ?></td>
  </tr>
  <?php } while ($row_dataList = mysql_fetch_assoc($dataList)); ?>

</table>
	ExpTotal = <?php echo $expTotal; ?>km<br>
	TotValue = $<?php echo $expTotal*.45; ?>	
</body>
</html>
<?php
mysql_free_result($dataList);
?>
