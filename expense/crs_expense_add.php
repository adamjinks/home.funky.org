<?php require_once('Connections/expenses.php'); ?>
<?php
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO expensecrs (excDate, excCompany, excType, excValue, excWorkorder, excDetail) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['excDate'], "date"),
                       GetSQLValueString($_POST['excCompany'], "int"),
                       GetSQLValueString($_POST['excType'], "int"),
                       GetSQLValueString($_POST['excValue'], "double"),
                       GetSQLValueString($_POST['excWorkorder'], "int"),
                       GetSQLValueString($_POST['excDetail'], "text"));

  mysql_select_db($database_expenses, $expenses);
  $Result1 = mysql_query($insertSQL, $expenses) or die(mysql_error());

  $insertGoTo = "crs_expense_add.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_expenses, $expenses);
$query_expenseTypes = "SELECT expensetype.extID, expensetype.extName FROM expensetype ORDER BY expensetype.extName";
$expenseTypes = mysql_query($query_expenseTypes, $expenses) or die(mysql_error());
$row_expenseTypes = mysql_fetch_assoc($expenseTypes);
$totalRows_expenseTypes = mysql_num_rows($expenseTypes);

mysql_select_db($database_expenses, $expenses);
$query_expenseCompany = "SELECT company.c_id, company.c_distance, company.c_name FROM company ORDER BY company.c_name";
$expenseCompany = mysql_query($query_expenseCompany, $expenses) or die(mysql_error());
$row_expenseCompany = mysql_fetch_assoc($expenseCompany);
$totalRows_expenseCompany = mysql_num_rows($expenseCompany);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Add Expense</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="main.css" rel="stylesheet" type="text/css">
</head>

<body class="sitemain">
<p><?php include('navbar.php'); ?></p>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="left">
    <tr valign="top">
      <td align="right" nowrap>DATE</td>
      <td><input name="excDate" type="text" class="sitemain" value="<?php echo date('Y-m-d'); ?>" size="32"></td>
    </tr>
    <tr valign="top">
      <td align="right" nowrap>COMPANY</td>
      <td>
        <select name="excCompany" class="sitemain">
          <?php 
do {  
?>
          <option value="<?php echo $row_expenseCompany['c_id']?>" ><?php echo $row_expenseCompany['c_name']?></option>
          <?php
} while ($row_expenseCompany = mysql_fetch_assoc($expenseCompany));
?>
      </select>      </td>
    <tr>
    <tr valign="top">
      <td align="right" nowrap>TYPE</td>
      <td>
        <select name="excType" class="sitemain">
          <?php 
do {  
?>
          <option value="<?php echo $row_expenseTypes['extID']?>" ><?php echo $row_expenseTypes['extName']?></option>
          <?php
} while ($row_expenseTypes = mysql_fetch_assoc($expenseTypes));
?>
      </select>      </td>
    <tr>
    <tr valign="top">
      <td align="right" nowrap>VALUE</td>
      <td><input name="excValue" type="text" class="sitemain" value="" size="32"></td>
    </tr>
    <tr valign="top">
      <td align="right" nowrap>WORKORDER</td>
      <td><input name="excWorkorder" type="text" class="sitemain" value="" size="32"></td>
    </tr>
    <tr valign="top">
      <td align="right" nowrap>DETAIL</td>
      <td><textarea name="excDetail" cols="32" rows="10" class="sitemain"></textarea></td>
    </tr>
    <tr valign="top">
      <td align="right" nowrap>&nbsp;</td>
      <td><input type="submit" class="sitemain" value="Insert record"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($expenseTypes);

mysql_free_result($expenseCompany);
?>
