<?php
include("../libs/library.php");
$title_page = "Ubah Data Akun";
cek_session("ubahakun","double");
$db_table = "tb_karyawan";
$qw_table = "qw_user";
$dir_path = "ubahAkun";
$ambildata = json_decode($db->select($qw_table,"*"));
$inp_kode = $_SESSION['config_nik'];
$inp_username = @$_POST['inp_username'];
$inp_password_lama = md5(@$_POST['inp_password_lama']);
$inp_password_baru1 = md5(@$_POST['inp_password_baru1']);
$inp_password_baru2 = md5(@$_POST['inp_password_baru2']);
if ($inp_password_baru1!=$inp_password_baru2) {
   echo js_alert("Maaf, Konfirmasi Password tidak cocok!");
  echo js_redir("../".$dir_path);
}
$e_inp_username = "";
$e_inp_password = "";
$e_inp_level = "";
$where = "NIK ='".@$_SESSION['config_nik']."'";
  $array_update = array(
    'UserName' => $inp_username,
    'PassWord' => $inp_password_baru2
   );
$cari_user = json_decode($db->select("tb_login","*","PassWord ='".$inp_password_lama."' And NIK ='".$_SESSION['config_nik']."'"));
if (isset($_POST['inp_update'])) {
 if (!count($cari_user->stand)) {
  echo js_alert("Maaf, Password lama yang anda masukan salah!");
  }else{
    if ($db->update("tb_login",$array_update,$where)) {
    echo js_alert("Berhasil Diubah!");
   }
 }
  echo js_redir("../".$dir_path);
}
  $editdata = json_decode($db->select($qw_table,"*","NIK ='".$_SESSION['config_nik']."'"));
  foreach($editdata->stand as $idx => $stand){
   $e_inp_kode = $stand->NIK;
   $e_inp_username = $stand->UserName;
  }

  $dis_input = "readonly id='readonly'";
  $dis_input2 = "readonly id='readonly' disabled";
  $btn_submit = '<input type="submit" name="inp_update" value="Ubah Data">';
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
<div class="kotak-utama">
<h1><?php echo $title_page ?></h1>
<br>
    <form method="post" enctype="multipart/form-data">

<table width="60%" border="0" style="margin-left:0%;">
 <tr>
  <td width="2%" valign="top" >

      Username <br>
      <input type="text" name="inp_username" value="<?php echo $e_inp_username ?>" required><br><br>
      Password Lama<br>
      <input type="text" name="inp_password_lama" value="" required><br><br>
      Password Baru <br>
      <input type="password" name="inp_password_baru1" value="" required id="inp_pass1" onkeyup="validate_password()"><br><br>
      Ulangi Password Baru<br>
      <input type="password" name="inp_password_baru2" value="" required id="inp_pass2" onkeyup="validate_password()"><br>
      <input type="text" id="wrap_text" style="border:1px"><br><br>
  </td>
 </tr>
 <tr>
 </tr>
</table>
  <?php echo $btn_submit ?>
   </form>
   <br>
   <br>
   <br>
</div>
</div>
<script>
 function validate_password(){
  var pass1 = document.getElementById('inp_pass1').value;
  var pass2 = document.getElementById('inp_pass2').value;
  var wrap = document.getElementById('wrap_text');
  if (pass1 != "" || pass2 != ""){
    if(pass1==pass2){
     wrap.value = "Cocok";
    }else{
     wrap.value = "Tidak Cocok";
    }
   }
  }
 </script>
 <br> <?php echo getFooter() ?> </body>
</html>
