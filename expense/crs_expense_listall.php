<?php require_once('Connections/expenses.php'); ?>
<?php
$maxRows_expenseList = 100;
$pageNum_expenseList = 0;
if (isset($_GET['pageNum_expenseList'])) {
  $pageNum_expenseList = $_GET['pageNum_expenseList'];
}
$startRow_expenseList = $pageNum_expenseList * $maxRows_expenseList;

mysql_select_db($database_expenses, $expenses);
$query_expenseList = "SELECT *, (SELECT extName from expensetype WHERE excType=extID) AS expType, (SELECT c_name from company WHERE c_id=excCompany) AS expCompany FROM expensecrs ORDER BY expensecrs.excDate";
$query_limit_expenseList = sprintf("%s LIMIT %d, %d", $query_expenseList, $startRow_expenseList, $maxRows_expenseList);
$expenseList = mysql_query($query_limit_expenseList, $expenses) or die(mysql_error());
$row_expenseList = mysql_fetch_assoc($expenseList);

if (isset($_GET['totalRows_expenseList'])) {
  $totalRows_expenseList = $_GET['totalRows_expenseList'];
} else {
  $all_expenseList = mysql_query($query_expenseList);
  $totalRows_expenseList = mysql_num_rows($all_expenseList);
}
$totalPages_expenseList = ceil($totalRows_expenseList/$maxRows_expenseList)-1;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>List All Expenses</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="main.css" rel="stylesheet" type="text/css">
</head>

<body class="sitemain">
<p><?php include('navbar.php'); ?></p>
<table border="0" cellpadding="4" cellspacing="0" class="sitemain">
  <tr align="left" valign="top">
    <td>COMPANY</td>
    <td>DATE</td>
    <td>VALUE</td>
    <td>TYPE</td>
    <td>WORKORDER</td>
    <td>DETAIL</td>
  </tr>
  <?php do { ?>
  <tr align="left" valign="top">
    <td><?php echo $row_expenseList['expCompany']; ?></td>
    <td><a href="crs_expense_edit.php?EXPID=<?php echo $row_expenseList['excID']; ?>"><?php echo $row_expenseList['excDate']; ?></a></td>
    <td><?php echo $row_expenseList['excValue']; ?></td>
    <td><?php echo $row_expenseList['expType']; ?></td>
    <td><?php echo $row_expenseList['excWorkorder']; ?></td>
    <td><?php echo $row_expenseList['excDetail']; ?></td>
  </tr>
  <?php } while ($row_expenseList = mysql_fetch_assoc($expenseList)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($expenseList);
?>
