<?php require_once('Connections/cnStore.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
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
}

$colname_rsShirt = "-1";
if (isset($_SERVER['REMOTE_ADD'])) {
  $colname_rsShirt = $_SERVER['REMOTE_ADD'];
}
mysql_select_db($database_cnStore, $cnStore);
$query_rsShirt = sprintf("SELECT  cart.*, shirt.name, shirt.price, shirt.color FROM cart, shirt WHERE ip = %s AND cart.sid=shirt.sid ORDER BY car.cartid DESC", GetSQLValueString($colname_rsShirt, "text"));
$rsShirt = mysql_query($query_rsShirt, $cnStore) or die(mysql_error());
$row_rsShirt = mysql_fetch_assoc($rsShirt);
$totalRows_rsShirt = mysql_num_rows($rsShirt);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>無標題文件</title>
<link href="website.css" rel="stylesheet" type="text/css">
</head>

<body>
<p class="style2">&nbsp;</p>
<p align="center" class="style7">感謝您的購買, 期待您再次光臨！</p>
<table width="90%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#C6C6C6">
  <tr>
    <td align="center" bgcolor="#E8FFD0">訂單編號</td>
    <td align="center" bgcolor="#E8FFD0">下單時間</td>
    <td align="center" bgcolor="#E8FFD0">您的大名</td>
    <td align="center" bgcolor="#E8FFD0">住址</td>
    <td align="center" bgcolor="#E8FFD0">電話</td>
    <td align="center" bgcolor="#E8FFD0">E-mail</td>
  </tr>
  <tr>
    <td align="center" bgcolor="#FFFFFF"><?php echo $row_rsShirt['cartid']; ?></td>
    <td align="center" bgcolor="#FFFFFF">2007-12-12 14:45:11</td>
    <td align="center" bgcolor="#FFFFFF"><?php echo $row_rsShirt['uname']; ?></td>
    <td align="center" bgcolor="#FFFFFF"><?php echo $row_rsShirt['addr']; ?></td>
    <td align="center" bgcolor="#FFFFFF">0900111222</td>
    <td align="center" bgcolor="#FFFFFF">chiaohua@flag.com.tw</td>
  </tr>
</table>
<br />
<table width="90%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#C6C6C6">
  <tr>
    <td align="center" bgcolor="#FFFFCC">商品編號</td>
    <td align="center" bgcolor="#FFFFCC">品名</td>
    <td align="center" bgcolor="#FFFFCC">尺寸</td>
    <td align="center" bgcolor="#FFFFCC">價格</td>
    <td align="center" bgcolor="#FFFFCC">數量</td>
    <td align="center" bgcolor="#FFFFCC">小計</td>
  </tr>
  <tr>
    <td align="center" bgcolor="#FFFFFF">T-<?php echo $row_rsShirt['sid']; ?></td>
    <td align="center" bgcolor="#FFFFFF">Last Treasure (<?php echo $row_rsShirt['color']; ?>)</td>
    <td align="center" bgcolor="#FFFFFF"><?php echo $row_rsShirt['size']; ?></td>
    <td align="center" bgcolor="#FFFFFF"><?php echo $row_rsShirt['price']; ?> 元</td>
    <td align="center" bgcolor="#FFFFFF"><label><?php echo $row_rsShirt['qty']; ?></label></td>
    <td align="center" bgcolor="#FFFFFF"><?php echo $row_rsShirt['price']* $row_rsShirt['qty']; ?> 元</td>
  </tr>
</table>
<p>&nbsp;</p>
<p align="center" class="mylink"><a href="special.php">繼續挑選其他產品</a></p>
</body>
</html>
<?php
mysql_free_result($rsShirt);
?>
