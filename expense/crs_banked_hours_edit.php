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


// convert variables
$BHID = $_GET['BHID'];

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE bankedhours SET bhDate=%s, bhType=%s, bhCompany=%s, bhTime=%s, bhPaid=%s, bhInfo=%s WHERE bhID=%s",
                       GetSQLValueString($_POST['bhDate'], "date"),
                       GetSQLValueString($_POST['bhType'], "int"),
                       GetSQLValueString($_POST['bhCompany'], "int"),
                       GetSQLValueString($_POST['bhTime'], "double"),
                       GetSQLValueString($_POST['bhPaid'], "int"),
                       GetSQLValueString($_POST['bhInfo'], "text"),
                       GetSQLValueString($_POST['bhID'], "int"));

  mysql_select_db($database_expenses, $expenses);
  $Result1 = mysql_query($updateSQL, $expenses) or die(mysql_error());

  $updateGoTo = "crs_banked_hours_split.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}


mysql_select_db($database_expenses, $expenses);
$query_bankedDetail = "SELECT * FROM bankedhours WHERE bankedhours.bhID=$BHID";
$bankedDetail = mysql_query($query_bankedDetail, $expenses) or die(mysql_error());
$row_bankedDetail = mysql_fetch_assoc($bankedDetail);
$totalRows_bankedDetail = mysql_num_rows($bankedDetail);

mysql_select_db($database_expenses, $expenses);
$query_listCompanies = "SELECT * FROM company ORDER BY company.c_name";
$listCompanies = mysql_query($query_listCompanies, $expenses) or die(mysql_error());
$row_listCompanies = mysql_fetch_assoc($listCompanies);
$totalRows_listCompanies = mysql_num_rows($listCompanies);

mysql_select_db($database_expenses, $expenses);
$query_listBankedTypes = "SELECT * FROM bhtypes ORDER BY bhtypes.bhtName";
$listBankedTypes = mysql_query($query_listBankedTypes, $expenses) or die(mysql_error());
$row_listBankedTypes = mysql_fetch_assoc($listBankedTypes);
$totalRows_listBankedTypes = mysql_num_rows($listBankedTypes);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Edit TIL/Vacation Entry</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="main.css" rel="stylesheet" type="text/css">
</head>

<body class="sitemain">
<p><?php include('navbar.php'); ?></p>
 <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
   <table align="left">
     <tr valign="baseline">
       <td nowrap align="right">DATE</td>
       <td><input name="bhDate" type="text" class="sitemain" value="<?php echo $row_bankedDetail['bhDate']; ?>" size="32"></td>
     </tr>
     <tr valign="baseline">
       <td nowrap align="right">TYPE</td>
       <td>
         <select name="bhType" class="sitemain">
           <?php 
do {  
?>
           <option value="<?php echo $row_listBankedTypes['bhtID']?>" <?php if (!(strcmp($row_listBankedTypes['bhtID'], "$row_bankedDetail[bhType]"))) {echo "SELECTED";} ?>><?php echo $row_listBankedTypes['bhtName']?></option>
           <?php
} while ($row_listBankedTypes = mysql_fetch_assoc($listBankedTypes));
?>
         </select>
       </td>
     <tr>
     <tr valign="baseline">
       <td nowrap align="right">COMPANY</td>
       <td>
         <select name="bhCompany" class="sitemain">
           <?php 
do {  
?>
           <option value="<?php echo $row_listCompanies['c_id']?>" <?php if (!(strcmp($row_listCompanies['c_id'], "$row_bankedDetail[bhCompany]"))) {echo "SELECTED";} ?>><?php echo $row_listCompanies['c_name']?></option>
           <?php
} while ($row_listCompanies = mysql_fetch_assoc($listCompanies));
?>
         </select>
       </td>
     <tr>
     <tr valign="baseline">
       <td nowrap align="right">TIME</td>
       <td><input name="bhTime" type="text" class="sitemain" value="<?php echo $row_bankedDetail['bhTime']; ?>" size="32"></td>
     </tr>
     <tr valign="baseline">
       <td nowrap align="right">PAID</td>
       <td><input name="bhPaid" type="text" class="sitemain" value="<?php echo $row_bankedDetail['bhPaid']; ?>" size="32"></td>
     </tr>
     <tr valign="baseline">
       <td nowrap align="right" valign="top">INFO</td>
       <td>
         <textarea name="bhInfo" cols="50" rows="5" class="sitemain"><?php echo $row_bankedDetail['bhInfo']; ?></textarea>
       </td>
     </tr>
     <tr valign="baseline">
       <td nowrap align="right">&nbsp;</td>
       <td><input type="submit" class="sitemain" value="Update record"></td>
     </tr>
   </table>
   <input type="hidden" name="bhID" value="<?php echo $row_bankedDetail['bhID']; ?>">
   <input type="hidden" name="MM_update" value="form1">
   <input type="hidden" name="bhID" value="<?php echo $row_bankedDetail['bhID']; ?>">
 </form>
 <p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($bankedDetail);

mysql_free_result($listCompanies);

mysql_free_result($listBankedTypes);
?>
