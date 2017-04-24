<?php require_once('Connections/expenses.php'); ?>
<?php
$MONTH =  date('m');

mysql_select_db($database_expenses, $expenses);
$query_expTypes = "SELECT expensetype.extID, expensetype.extName FROM expensetype ORDER BY expensetype.extName";
$expTypes = mysql_query($query_expTypes, $expenses) or die(mysql_error());
$row_expTypes = mysql_fetch_assoc($expTypes);
$totalRows_expTypes = mysql_num_rows($expTypes);
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
<form action="crs_expense_list2.php" method="get" name="listExpOpts">

<table border="0">
  <tr>
    <td colspan="5">List CRS Expenses </td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td>Start Date </td>
    <td>End Date </td>
    <td>Type</td>
    <td>Order</td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td><select name="dsYear" class="sitemain" id="dsYear">
      <option value="2007">2007</option>
      <option value="2008">2008</option>
    </select>
      <select name="dsMonth" class="sitemain" id="dsMonth">
        <option value="01" <?php if ($MONTH == 01) { echo " SELECTED "; }; ?> >JAN</option>
        <option value="02" <?php if ($MONTH == 02) { echo " SELECTED "; }; ?> >FEB</option>
        <option value="03" <?php if ($MONTH == 03) { echo " SELECTED "; }; ?> >MAR</option>
        <option value="04" <?php if ($MONTH == 04) { echo " SELECTED "; }; ?> >APR</option>
        <option value="05" <?php if ($MONTH == 05) { echo " SELECTED "; }; ?> >MAY</option>
        <option value="06" <?php if ($MONTH == 06) { echo " SELECTED "; }; ?> >JUN</option>
        <option value="07" <?php if ($MONTH == 07) { echo " SELECTED "; }; ?> >JUL</option>
        <option value="08" <?php if ($MONTH == 08) { echo " SELECTED "; }; ?> >AUG</option>
        <option value="09" <?php if ($MONTH == 09) { echo " SELECTED "; }; ?> >SEP</option>
        <option value="10" <?php if ($MONTH == 10) { echo " SELECTED "; }; ?> >OCT</option>
        <option value="11" <?php if ($MONTH == 11) { echo " SELECTED "; }; ?> >NOV</option>
        <option value="12" <?php if ($MONTH == 12) { echo " SELECTED "; }; ?> >DEC</option>
      </select>      <input name="dsDay" type="text" class="sitemain" id="dsDay3" size="2"></td>
    <td><select name="deYear" class="sitemain" id="deYear">
      <option value="2007">2007</option>
      <option selected value="2008">2008</option>
    </select>
      <select name="deMonth" class="sitemain" id="deMonth">
        <option value="01">JAN</option>
        <option value="02">FEB</option>
        <option value="03">MAR</option>
        <option value="04">APR</option>
        <option value="05">MAY</option>
        <option value="06">JUN</option>
        <option value="07">JUL</option>
        <option value="08">AUG</option>
        <option value="09">SEP</option>
        <option value="10">OCT</option>
        <option value="11">NOV</option>
        <option value="12">DEC</option>
      </select>      <input name="deDay" type="text" class="sitemain" id="dsDay22" size="2"></td>
    <td><select name="exptype" class="sitemain" id="exptype">
	   <option value="0">ALL TYPES</option>
      <?php
do {  
?>
      <option value="<?php echo $row_expTypes['extID']?>"><?php echo $row_expTypes['extName']?></option>
      <?php
} while ($row_expTypes = mysql_fetch_assoc($expTypes));
  $rows = mysql_num_rows($expTypes);
  if($rows > 0) {
      mysql_data_seek($expTypes, 0);
	  $row_expTypes = mysql_fetch_assoc($expTypes);
  }
?>
    </select></td>
    <td><select name="sortorder" class="sitemain" id="sortorder">
      <option value="ASC">Ascending</option>
      <option value="DESC">Descending</option>
    </select></td>
    <td><input name="Submit" type="submit" class="sitemain" value="GO!"></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
</table>
</form>

<p>

</p>
</body>
</html>
<?php
mysql_free_result($expTypes);
?>
