<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_expenses = "localhost";
$database_expenses = "bongca_expense";
$username_expenses = "bongca_expense";
$password_expenses = "expense";
$expenses = mysql_pconnect($hostname_expenses, $username_expenses, $password_expenses) or trigger_error(mysql_error(),E_USER_ERROR); 
?>
