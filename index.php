<?php
include("libs/library.php");
$title_page = "Login System";
cek_session("login");
$db_table = "tb_login";
if (isset($_POST['inp_submit'])) {
 $safe_input['1'] = mysql_escape_string($_POST['inp_user']);
 $safe_input['2'] = md5(mysql_escape_string($_POST['inp_pass']));
 $sql_login = json_decode($db->select($db_table,"*","UserName ='".$safe_input['1']."' and PassWord ='".$safe_input['2']."'"));
    if (count($sql_login->stand)) {
     foreach($sql_login->stand as $idx => $stand){
      create_session($stand->UserName,$stand->NIK,$stand->TypeUser);
      cek_session("login");
      }
   }else{
    echo js_alert('Maaf! Username atau Password Salah!');
   }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>RentCar Apps | <?php echo $title_page ?></title>
    <link rel="stylesheet" href="css/main.css">
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta name="keywords" content="">
</head>
<body>
 <center>
 </center>
<div class="kotak-tengah">
    <center>
   <h1>Sistem Informasi Manajemen Rental Mobil</h1>
   <br>
 </center>
 <div class="kotak-login">
  <br>
 <br>
  <br>

 <center>
  <form method="post">
  <h1>LOGIN SYSTEM</h1>
   <input type="text" name="inp_user" placeholder="Username" required style="width:18%;">
   <br>
   <input type="password" name="inp_pass" placeholder="Password" required style="width:18%;">
   <br>
   <br>
  <input type="submit" name="inp_submit" value="Login" style="width:20%;">
  </form>
 </center>
 <br>
 <br>
 <br>
 <br>
 <br>
 <br>
 <br>
</div>
</div>
<br>
<center class="copyright">Copyright &copy 2016. Developed by Ramdan Nurul</center>
</body>
</html>
