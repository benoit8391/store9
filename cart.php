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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO cart (cartid, sid, `size`, qty, uname, email, tel, ip) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['sid'], "int"),
                       GetSQLValueString($_POST['sid'], "int"),
                       GetSQLValueString($_POST['size'], "text"),
                       GetSQLValueString($_POST['qty'], "int"),
                       GetSQLValueString($_POST['uname'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['Tel'], "text"),
                       GetSQLValueString($_POST['ip'], "text"));

  mysql_select_db($database_cnStore, $cnStore);
  $Result1 = mysql_query($insertSQL, $cnStore) or die(mysql_error());

  $insertGoTo = "thanks.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$colname_rsShirt = "-1";
if (isset($_POST['sid'])) {
  $colname_rsShirt = $_POST['sid'];
}
mysql_select_db($database_cnStore, $cnStore);
$query_rsShirt = sprintf("SELECT * FROM shirt WHERE sid = %s", GetSQLValueString($colname_rsShirt, "int"));
$rsShirt = mysql_query($query_rsShirt, $cnStore) or die(mysql_error());
$row_rsShirt = mysql_fetch_assoc($rsShirt);
$totalRows_rsShirt = mysql_num_rows($rsShirt);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Tshirts Kingdom</title>
<link href="website.css" rel="stylesheet" type="text/css">
</head>

<body>
<div id="cartlist">
  <p><img src="images/title1.gif" alt="購物明細" width="630" height="31" /></p>
  <div align="center"><img src="imgshirt/<?php echo $row_rsShirt['img']; ?>m.jpg" /></div>
  <br />
  <table width="80%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#C6C6C6">
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
      <td align="center" bgcolor="#FFFFFF"><?php echo $row_rsShirt['name']; ?> (<?php echo $row_rsShirt['color']; ?>)</td>
      <td align="center" bgcolor="#FFFFFF"><?php echo $_POST['size']; ?></td>
      <td align="center" bgcolor="#FFFFFF"><?php echo $row_rsShirt['price']; ?> 元</td>
      <td align="center" bgcolor="#FFFFFF"><label><?php echo $_POST['qty']; ?></label></td>
      <td align="center" bgcolor="#FFFFFF"> <?php echo $row_rsShirt['price']* $_POST['qty']; ?> 元</td>
    </tr>
  </table>
  <br />
  <form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1">
    <table align="center">
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">姓名：</td>
        <td colspan="2"><label for="uname"></label>
        <input type="text" name="uname" id="uname" size="10" required>
        <input name="sid" type="hidden" id="sid" value="<?php echo $row_rsShirt['sid']; ?>">
        <input name="size" type="hidden" id="size" value="<?php echo $_POST['size']; ?>">
        <input name="qty" type="hidden" id="qty" value="<?php echo $_POST['qty']; ?>">
        <input name="ip" type="hidden" id="ip" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>"></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">Email：</td>
        <td colspan="2"><label for="email"></label>
        <input type="text" name="email" id="email" required></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">地址：</td>
        <td colspan="2"><label for="address"></label>
        <input type="text" name="address" id="address" required></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">手機：</td>
        <td colspan="2"><label for="Tel"></label>
          <input type="text" name="Tel" id="Tel" required>
          <br />
        <br /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">&nbsp;</td>
        <td><img src="images/button_send.gif" alt="送出訂單" name="imageField" width="98" height="28" id="imageField"> </td>
        <td><div align="right"><img src="images/button_back.gif" alt="回到上一頁" width="98" height="28" onClick="history.go(-1)" border="0" /></a></div></td>
      </tr>
    </table>
    <input type="hidden" name="MM_insert" value="form1">
  </form>
</div>
</body>
</html>
<?php
mysql_free_result($rsShirt);
?>
