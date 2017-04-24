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
  $insertSQL = sprintf("INSERT INTO company (c_name, c_address, c_distance, c_phone, c_comment) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['c_name'], "text"),
                       GetSQLValueString($_POST['c_address'], "text"),
                       GetSQLValueString($_POST['c_distance'], "double"),
                       GetSQLValueString($_POST['c_phone'], "double"),
                       GetSQLValueString($_POST['c_comment'], "text"));

  mysql_select_db($database_expenses, $expenses);
  $Result1 = mysql_query($insertSQL, $expenses) or die(mysql_error());

  $insertGoTo = "company_list.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Add A Company</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="main.css" rel="stylesheet" type="text/css">
</head>

<body class="sitemain">
<p><?php include('navbar.php'); ?></p>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="left">
    <tr valign="baseline">
      <td nowrap align="right">Company Name</td>
      <td><input name="c_name" type="text" class="sitemain" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Distance</td>
      <td><input name="c_distance" type="text" class="sitemain" value="" size="5" maxlength="3"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Phone</td>
      <td><input name="c_phone" type="text" class="sitemain" value="" size="14" maxlength="10"></td>
    </tr>
    <tr valign="top">
      <td nowrap align="right">Address</td>
      <td><textarea name="c_address" cols="32" rows="5" class="sitemain"></textarea></td>
    </tr>
    <tr valign="top">
      <td nowrap align="right">Comment</td>
      <td><textarea name="c_comment" cols="32" rows="5" class="sitemain"></textarea></td>
    </tr>
    <tr valign="top">
      <td nowrap align="right">&nbsp;</td>
      <td><input name="submit" type="submit" class="headings" value="Insert record"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
</form>
<p>&nbsp;</p>
</body>
</html>
