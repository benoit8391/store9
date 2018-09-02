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

$colname_rsProduct = "-1";
if (isset($_GET['sid'])) {
  $colname_rsProduct = $_GET['sid'];
}
mysql_select_db($database_cnStore, $cnStore);
$query_rsProduct = sprintf("SELECT * FROM shirt WHERE name = (SELECT name FROM shirt WHERE sid=%s) ORDER BY (sid=%s) desc", GetSQLValueString($colname_rsProduct, "text"),GetSQLValueString($colname_rsProduct, "text"));
$rsProduct = mysql_query($query_rsProduct, $cnStore) or die(mysql_error());
$row_rsProduct = mysql_fetch_assoc($rsProduct);
$totalRows_rsProduct = mysql_num_rows($rsProduct);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Tshirts Kingdom</title>
<link href="website.css" rel="stylesheet" type="text/css">
</head>

<body>
<table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="350"><div id="detail"> <a href="product.php?sid=<?php echo $row_rsProduct['sid']; ?>"><img src="imgshirt/<?php echo $row_rsProduct['img']; ?>l.jpg" width="350" height="294" class="type2" /></a>
        <form action="cart.php" method="post" enctype="multipart/form-data" name="buy">
          <table width="250" border="0" cellpadding="5" cellspacing="1" bgcolor="#C6C6C6">
            <tr>
              <td width="34" align="left" bgcolor="#FFFFFF">品名</td>
              <td width="193" align="left" bgcolor="#FFFFFF"><?php echo $row_rsProduct['name']; ?>&nbsp;&nbsp;(T-<?php echo $row_rsProduct['sid']; ?>)</td>
            </tr>
            <tr>
              <td align="left" bgcolor="#FFFFFF">尺寸</td>
              <td align="left" bgcolor="#FFFFFF"><label>
                  <select name="size" class="type1" id="size">
                    <option selected="selected">S</option>
                    <option>M</option>
                    <option>L</option>
                    <option>XL</option>
                  </select>
                </label>
                X
                <input name="qty" type="text" class="type1" id="qty" value="1" size="2" maxlength="2" required/>
                件 </td>
            </tr>
            <tr>
              <td align="left" bgcolor="#FFFFFF">顏色</td>
              <td align="left" bgcolor="#FFFFFF"><?php echo $row_rsProduct['color']; ?></td>
            </tr>
            <tr>
              <td align="left" bgcolor="#FFFFFF">價格</td>
              <td align="left" bgcolor="#FFFFFF">NT<?php echo $row_rsProduct['price']; ?></td>
            </tr>
            <tr>
              <td height="130" align="left" bgcolor="#FFFFFF">簡介 </td>
              <td height="130" align="left" bgcolor="#FFFFFF"><p><?php echo $row_rsProduct['descript']; ?></p></td>
            </tr>
          </table>
          <br />
          <table width="250" border="0">
            <tr>
              <td width="50%"><div align="right">
                  <input type="image" name="tobuy" id="tobuy" src="images/button_buy1.gif" alt="確定購買" />
              </div></td>
              <td><div align="right"><a href="javascript:;"><img src="images/button_back.gif" alt="回到上一頁" width="98" height="28" onClick="history.go(-1)" border="0" align="bottom" /></a></div></td>
            </tr>
          </table>
        </form>
    </div></td>
  </tr>
  <tr>
    <td><div> 　其他同款式的Ｔ恤：</div>
    <?php do { ?>
	<div class="picklist">
        <div class="box"> <a href="product.php?sid=<?php echo $row_rsProduct['sid']; ?>"><img src="imgshirt/<?php echo $row_rsProduct['img']; ?>z.jpg" width="98" height="82" /></a>
        </div>
        NT<?php echo $row_rsProduct['price']; ?></div>
    <?php } while ($row_rsProduct = mysql_fetch_assoc($rsProduct)); ?>
        </td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($rsProduct);
?>
