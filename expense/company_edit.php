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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE company SET c_name=%s, c_distance=%s, c_address=%s, c_phone=%s, c_comment=%s WHERE c_id=%s",
                       GetSQLValueString($_POST['c_name'], "text"),
                       GetSQLValueString($_POST['c_distance'], "double"),
					   GetSQLValueString($_POST['c_address'], "text"),
					   GetSQLValueString($_POST['c_phone'], "int"),
                       GetSQLValueString($_POST['c_comment'], "text"),
                       GetSQLValueString($_POST['c_id'], "int"));

  mysql_select_db($database_expenses, $expenses);
  $Result1 = mysql_query($updateSQL, $expenses) or die(mysql_error());

  $updateGoTo = "company_list.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

// convert variables
$COMPID = $_GET['COMPID'];

mysql_select_db($database_expenses, $expenses);
$query_companyData = "SELECT * FROM company WHERE c_id=$COMPID";
$companyData = mysql_query($query_companyData, $expenses) or die(mysql_error());
$row_companyData = mysql_fetch_assoc($companyData);
$totalRows_companyData = mysql_num_rows($companyData);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Edit A Company</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="main.css" rel="stylesheet" type="text/css">
</head>

<body class="sitemain">
<p><?php include('navbar.php'); ?></p>

<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="left">
    <tr valign="baseline">
      <td nowrap align="right">Company Name</td>
      <td><input name="c_name" type="text" class="sitemain" value="<?php echo $row_companyData['c_name']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Distance (km)</td>
      <td><input name="c_distance" type="text" class="sitemain" value="<?php echo $row_companyData['c_distance']; ?>" size="5" maxlength="3"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Phone</td>
      <td><input name="c_phone" type="text" class="sitemain" id="c_phone" value="<?php echo $row_companyData['c_phone']; ?>" size="14" maxlength="10"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap>Address</td>
      <td><textarea name="c_address" cols="32" rows="4" class="sitemain" id="c_address"><?php echo $row_companyData['c_address']; ?></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Comment</td>
      <td><textarea name="c_comment" cols="32" rows="5" class="sitemain"><?php echo $row_companyData['c_comment']; ?></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input name="submit" type="submit" class="headings" value="Update record"></td>
    </tr>
  </table>
  <input type="hidden" name="c_id" value="<?php echo $row_companyData['c_id']; ?>">
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="c_id" value="<?php echo $row_companyData['c_id']; ?>">
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($companyData);
?>
