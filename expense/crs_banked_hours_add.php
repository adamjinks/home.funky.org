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

// Convert Variables
$bhDate = $_POST['bhDate'];
$bhType = $_POST['bhType'];
$bhCompany = $_POST['bhCompany'];
$bhTime = $_POST['bhTime'];
$bhInfo = $_POST['bhInfo'];


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO bankedhours (bhDate, bhType, bhTime, bhPaid, bhCompany, bhInfo) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['bhDate'], "date"),
                       GetSQLValueString($_POST['bhType'], "int"),
                       GetSQLValueString($_POST['bhTime'], "double"),
                       GetSQLValueString($_POST['bhPaid'], "int"),
					   GetSQLValueString($_POST['bhCompany'], "int"),
                       GetSQLValueString($_POST['bhInfo'], "text"));

  mysql_select_db($database_expenses, $expenses);
  $Result1 = mysql_query($insertSQL, $expenses) or die(mysql_error());

  $insertGoTo = "crs_banked_hours_split.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_expenses, $expenses);
$query_bhTypes = "SELECT * FROM bhtypes ORDER BY bhtypes.bhtName";
$bhTypes = mysql_query($query_bhTypes, $expenses) or die(mysql_error());
$row_bhTypes = mysql_fetch_assoc($bhTypes);
$totalRows_bhTypes = mysql_num_rows($bhTypes);

mysql_select_db($database_expenses, $expenses);
$query_listCompanies = "SELECT company.c_id, company.c_name FROM company ORDER BY company.c_name";
$listCompanies = mysql_query($query_listCompanies, $expenses) or die(mysql_error());
$row_listCompanies = mysql_fetch_assoc($listCompanies);
$totalRows_listCompanies = mysql_num_rows($listCompanies);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Add LIEU / VACATION</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="general.css" rel="stylesheet" type="text/css">
<link href="main.css" rel="stylesheet" type="text/css">
</head>

<body class="sitemain">
<p><?php include('navbar.php'); ?></p>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="left">
    <tr valign="baseline">
      <td nowrap align="right">DATE</td>
      <td><input type="text" name="bhDate" value="<?php echo date('Y-m-d'); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Type</td>
      <td>
        <select name="bhType">
          <?php 
do {  
?>
          <option value="<?php echo $row_bhTypes['bhtID']?>" ><?php echo $row_bhTypes['bhtName']?></option>
          <?php
} while ($row_bhTypes = mysql_fetch_assoc($bhTypes));
?>
        </select>
      </td>
    <tr>
    <tr valign="baseline">
      <td nowrap align="right">Company</td>
      <td><select name="bhCompany" id="bhCompany">
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
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Hours</td>
      <td><input type="text" name="bhTime" value="0.00" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Paid $</td>
      <td><input type="text" name="bhPaid" value="0" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" valign="top">Info</td>
      <td>
        <textarea name="bhInfo" cols="50" rows="5"></textarea>
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Insert record"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($bhTypes);

mysql_free_result($listCompanies);
?>
