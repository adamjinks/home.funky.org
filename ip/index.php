<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>IP INFO</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
.mainStyle {
	font-family: Geneva, Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000066;
}
-->
</style>
</head>
<?php $hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']); ?>
<body class="mainStyle">
<table width="80%"  border="0">
  <tr align="center">
    <td colspan="2"><u>IP INFO </u></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">IP ADDRESS </td>
    <td>&nbsp;</td>
    <td> <?php echo $REMOTE_ADDR; ?></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp; </td>
  </tr>
  <tr>
    <td align="right">REVERSE DNS</td>
    <td>&nbsp;</td>
    <td><?php echo $hostname; ?></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">BROWSER</td>
    <td>&nbsp;</td>
    <td><?php echo $HTTP_USER_AGENT; ?> </td>
  </tr>
</table>
</body>
</html>
