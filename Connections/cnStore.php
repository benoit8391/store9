<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_cnStore = "localhost";
$database_cnStore = "store";
$username_cnStore = "admin";
$password_cnStore = "a123";
$cnStore = mysql_pconnect($hostname_cnStore, $username_cnStore, $password_cnStore) or trigger_error(mysql_error(),E_USER_ERROR);
mysql_query("set names utf8"); 
?>