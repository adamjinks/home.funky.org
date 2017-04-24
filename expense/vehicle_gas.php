<?php require_once('Connections/expenses.php'); ?>
<?php
mysql_select_db($database_expenses, $expenses);
$query_companies = "SELECT * FROM company ORDER BY c_name";
$companies = mysql_query($query_companies, $expenses) or die(mysql_error());
$row_companies = mysql_fetch_assoc($companies);
$totalRows_companies = mysql_num_rows($companies);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Add Gas expense</title>
<link href="main.css" rel="stylesheet" type="text/css">
</head>

<body class="sitemain">
<p><?php include('navbar.php'); ?></p>
<form name="form1" method="post" action="gas_load.php">
  <span class="sitemain">
  <label>mileage
  <input name="mileage" type="text" class="sitemain">
  </label>
  </span>
  <p>
    <span class="sitemain">
    <label>company
    <select name="company" class="sitemain">
      <?php
do {  
?>
      <option value="<?php echo $row_companies['c_id']?>"><?php echo $row_companies['c_name']?></option>
      <?php
} while ($row_companies = mysql_fetch_assoc($companies));
  $rows = mysql_num_rows($companies);
  if($rows > 0) {
      mysql_data_seek($companies, 0);
	  $row_companies = mysql_fetch_assoc($companies);
  }
?>
    </select>
    </label>
    </span></p>
  <p>
    <span class="sitemain">
    <label>price/L
    <input name="price" type="text" class="sitemain">
    </label>
    </span></p>
  <p>
    <span class="sitemain">
    <label>litres
    <input name="litres" type="text" class="sitemain">
    </label>
    </span></p>
  <p>
    <span class="sitemain">
    <label>date
    <input name="date" type="text" class="sitemain" value="<?php echo date('Y-m-d'); ?>">
    </label>
    </span></p>
  <p>
    <span class="sitemain">
    <label>comment
    <input name="comment" type="text" class="sitemain">
    </label>
    </span></p>
  <p>
    <span class="sitemain">
    <label>Submit
to my command!  
    <input name="Submit" type="submit" class="headings" value="Submit!">
    </label>
    </span></p>
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($companies);
?>

