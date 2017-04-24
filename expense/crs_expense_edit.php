<?php require_once('Connections/expenses.php'); ?>
<?php
//convert vars
$EXPID = $_GET[EXPID];

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE expensecrs SET excDate=%s, excCompany=%s, excType=%s, excValue=%s, excWorkorder=%s, excDetail=%s WHERE excID=%s",
                       GetSQLValueString($_POST['excDate'], "date"),
                       GetSQLValueString($_POST['excCompany'], "int"),
                       GetSQLValueString($_POST['excType'], "int"),
                       GetSQLValueString($_POST['excValue'], "double"),
                       GetSQLValueString($_POST['excWorkorder'], "int"),
                       GetSQLValueString($_POST['excDetail'], "text"),
                       GetSQLValueString($_POST['excID'], "int"));

  mysql_select_db($database_expenses, $expenses);
  $Result1 = mysql_query($updateSQL, $expenses) or die(mysql_error());

  $updateGoTo = "crs_expense_edit.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_expenses, $expenses);
$query_expenseEntry = "SELECT * FROM expensecrs WHERE expensecrs.excID =$EXPID";
$expenseEntry = mysql_query($query_expenseEntry, $expenses) or die(mysql_error());
$row_expenseEntry = mysql_fetch_assoc($expenseEntry);
$totalRows_expenseEntry = mysql_num_rows($expenseEntry);

mysql_select_db($database_expenses, $expenses);
$query_expenseType = "SELECT expensetype.extID, expensetype.extName FROM expensetype ORDER BY expensetype.extName";
$expenseType = mysql_query($query_expenseType, $expenses) or die(mysql_error());
$row_expenseType = mysql_fetch_assoc($expenseType);
$totalRows_expenseType = mysql_num_rows($expenseType);

mysql_select_db($database_expenses, $expenses);
$query_expenseCompany = "SELECT company.c_id, company.c_name FROM company ORDER BY company.c_name";
$expenseCompany = mysql_query($query_expenseCompany, $expenses) or die(mysql_error());
$row_expenseCompany = mysql_fetch_assoc($expenseCompany);
$totalRows_expenseCompany = mysql_num_rows($expenseCompany);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Edit an Expense</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="main.css" rel="stylesheet" type="text/css">
</head>

<body class="sitemain">
<p><?php include('navbar.php'); ?></p>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="left" class="sitemain">
    <tr valign="baseline">
      <td nowrap align="right">DATE</td>
      <td><input name="excDate" type="text" class="sitemain" value="<?php echo $row_expenseEntry['excDate']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">COMPANY</td>
      <td>
        <select name="excCompany" class="sitemain">
          <?php 
do {  
?>
          <option value="<?php echo $row_expenseCompany['c_id']?>" <?php if (!(strcmp($row_expenseCompany['c_id'], "$row_expenseEntry[excCompany]"))) {echo "SELECTED";} ?>><?php echo $row_expenseCompany['c_name']?></option>
          <?php
} while ($row_expenseCompany = mysql_fetch_assoc($expenseCompany));
?>
        </select>
      </td>
    <tr>
    <tr valign="baseline">
      <td nowrap align="right">TYPE</td>
      <td>
        <select name="excType" class="sitemain">
          <?php 
do {  
?>
          <option value="<?php echo $row_expenseType['extID']?>" <?php if (!(strcmp($row_expenseType['extID'], "$row_expenseEntry[excType]"))) {echo "SELECTED";} ?>><?php echo $row_expenseType['extName']?></option>
          <?php
} while ($row_expenseType = mysql_fetch_assoc($expenseType));
?>
        </select>
      </td>
    <tr>
    <tr valign="baseline">
      <td nowrap align="right">VALUE</td>
      <td><input name="excValue" type="text" class="sitemain" value="<?php echo $row_expenseEntry['excValue']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">WORKORDER</td>
      <td><input name="excWorkorder" type="text" class="sitemain" value="<?php echo $row_expenseEntry['excWorkorder']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" valign="top">DETAIL</td>
      <td>
        <textarea name="excDetail" cols="50" rows="5" class="sitemain"><?php echo $row_expenseEntry['excDetail']; ?></textarea>
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Update Expense"></td>
    </tr>
  </table>
  <input type="hidden" name="excID2" value="<?php echo $row_expenseEntry['excID']; ?>">  
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="excID" value="<?php echo $row_expenseEntry['excID']; ?>">
</form>
<p>&nbsp;</p>
</body>
</html>
sql: 
<?php
echo $query_expenseEntry ;

mysql_free_result($expenseEntry);

mysql_free_result($expenseType);

mysql_free_result($expenseCompany);
?>
