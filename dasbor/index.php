<?php
include("../libs/library.php");
$title_page = "Login System";
cek_session("dasbor","double");
$db_table = "tb_login";
$arrayFoto = get_array($db->select("tb_karyawan","*"),"NIK","Foto");
if (isset($_POST['inp_submit'])) {
 $safe_input['1'] = mysql_escape_string($_POST['inp_user']);
 $safe_input['2'] = md5(mysql_escape_string($_POST['inp_pass']));
 $sql_login = json_decode($db->select($db_table,"*","UserName ='".$safe_input['1']."' and PassWord ='".$safe_input['2']."'"));
if (count($sql_login->stand)) {
 foreach($sql_login->stand as $idx => $stand){
  create_session($stand->UserName,$stand->NIK,$stand->TypeUser);
 }
}
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>RentCar Apps | <?php echo $title_page ?></title>
    <link rel="stylesheet" href="../css/main.css">
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta name="keywords" content="">
</head>
<body>
<?php echo get_navbar1() ?>
<div class="kotak-tengah">
    <center>
   <h3>Selamat Datang <?php echo $_SESSION['config_username'] ?>,</h3>
   <h1>Sistem Informasi Manajemen Rental Mobil</h1>
   <br>
 </center>
</div>
</div>
<br>
<div style="width:400px;margin:auto;" class="align-center">
  <marquee direction="right"> ________________  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ________________   </marquee>
<img src="../img/upload/<?php echo  $arrayFoto[$_SESSION['config_nik']] ?>" class="user-dasbor">
  <marquee direction="left"> ________________  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Selamat Datang <font color=#09f><?php echo $_SESSION['config_username'] ?></font>,  NIK : <font color=#09f><?php echo $_SESSION['config_nik'] ?></font>, 
      Akses : <font color=#09f><?php echo $_SESSION['config_userlevel'] ?></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ________________   </marquee>
</div>
<br>
<br>
<br>
<br>
<br>
<br>
 <br> <?php echo getFooter() ?> </body>
</html>
