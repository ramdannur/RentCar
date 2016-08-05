<?php
include("../libs/library.php");
$title_page = "Karyawan";
cek_session("karyawan","admin");
$db_table = "tb_karyawan";
$qw_table = "qw_user";
$dir_path = "karyawan";
$btn_submit = '<input type="submit" name="inp_submit" value="Tambah Data">';
$ambildata = json_decode($db->select($qw_table,"*"));
$dis_input = "";
@$dis_input2 = "";
$inp_kode = @$_POST['inp_kode'];
$inp_nama = @$_POST['inp_nama'];
$inp_alamat = @$_POST['inp_alamat'];
$inp_telp = @$_POST['inp_telp'];
$inp_username = @$_POST['inp_username'];
$inp_password = md5(@$_POST['inp_password']);
$inp_level = @$_POST['inp_level'];
$inp_nama_foto = @$_POST['inp_nama_foto'];
$inp_foto = @$_FILES['inp_foto']['name'];
$inp_foto_tmp = @$_FILES['inp_foto']['tmp_name'];
$e_inp_kode = getKode($db->select($db_table,"NIK","","NIK ASC","0,1"),"NIK","11");
$e_inp_nama = "";
$e_inp_alamat = "";
$e_inp_telp = "";
$e_inp_username = "";
$e_inp_password = "";
$e_inp_level = "";
$where = "NIK ='".@$safe_get_url['1']."'";
$array_insert = array(
 'NIK' => $inp_kode,
 'NmKaryawan' => $inp_nama,
 'AlmtKaryawan' => $inp_alamat,
 'TelpKaryawan' => $inp_telp,
 'Foto' => $inp_foto
);
$array_insert2 = array(
 'UserName' => $inp_username,
 'PassWord' => $inp_password,
 'TypeUser' => $inp_level,
 'NIK' => $inp_kode
);
$s_filter = array(
 'NIK' => "NIK",
 'NmKaryawan' => "Nama Karyawan"
);
$cari_user = json_decode($db->select("tb_login","*","UserName ='".$inp_username."'"));
if (isset($_POST['inp_submit'])) {
  if (count($cari_user->stand)) {
  echo js_alert("Maaf, Username sudah terdaftar! Cobalah gunakan username yang lain!");
  }else{
   if ($db->insert($db_table,$array_insert)) {
    $db->insert("tb_login",$array_insert2);
    move_uploaded_file($inp_foto_tmp,'../img/upload/'.$inp_foto);
    echo js_alert("Berhasil Ditambahkan!");
   }
 }
  echo js_redir("../".$dir_path);
}

if (isset($_POST['inp_update'])) {
 if (!empty($inp_foto_tmp)) {
  move_uploaded_file($inp_foto_tmp,'../img/upload/'.$inp_foto);
  $array_update = array(
    'NmKaryawan' => $inp_nama,
    'AlmtKaryawan' => $inp_alamat,
    'TelpKaryawan' => $inp_telp,
    'Foto' => $inp_foto
   );
   if ($db->update($db_table,$array_update,$where)) {
    echo js_alert("Berhasil Diubah!");
}
 }else{
  $array_update = array(
    'NmKaryawan' => $inp_nama,
    'AlmtKaryawan' => $inp_alamat,
    'TelpKaryawan' => $inp_telp,
    'Foto' => $_POST['inp_nama_foto']
   );
   if ($db->update($db_table,$array_update,$where)) {
    echo js_alert("Berhasil Diubah!");
   }
 }

echo js_redir("../".$dir_path);
}
switch($safe_get_url['0']){
 case "x":
  if ($db->delete($db_table,array('NIK'=>$safe_get_url['1']))) {
    echo js_alert("Berhasil Dihapus!");
   }
    echo js_redir("../".$dir_path);
  break;

 case "f":
  $e_safe_cari = @$_POST['inp_cari'];
  $e_safe_filter = @$_POST['inp_filter'];
  $ambildata = json_decode($db->select($qw_table,"*","$e_safe_filter like '%$e_safe_cari%'"));
  break;

 case "e":
  $editdata = json_decode($db->select($qw_table,"*","NIK ='".$safe_get_url['1']."'"));
  foreach($editdata->stand as $idx => $stand){
   $e_inp_kode = $stand->NIK;
   $e_inp_nama = $stand->NmKaryawan;
   $e_inp_alamat = $stand->AlmtKaryawan;
   $e_inp_telp = $stand->TelpKaryawan;
   $e_inp_username = $stand->UserName;
   $e_inp_password = $stand->PassWord;
   $e_inp_level = $stand->TypeUser;
   $e_inp_foto = $stand->Foto;
  }

  $dis_input = "readonly id='readonly'";
  $dis_input2 = "readonly id='readonly' disabled";
  $btn_submit = '<input type="submit" name="inp_update" value="Ubah Data">';
  break;
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
<div class="kotak-utama">
<h1><?php echo $title_page ?></h1>
<br>
    <form method="post" enctype="multipart/form-data">

<table width="100%" border="0">
 <tr>
  <td width="2%" valign="top">

   <strong class="title-form"> Form Input Data : </strong><br><br>
      Kode <br>
      <input type="text" name="inp_kode" value="<?php echo $e_inp_kode ?>" <?php echo $dis_input ?> required><br><br>
      Nama Karyawan <br>
      <input type="text" name="inp_nama" value="<?php echo $e_inp_nama ?>" required><br><br>
       Alamat <br>
     <textarea type="text" name="inp_alamat" required><?php echo $e_inp_alamat ?></textarea><br><br>
       Nomor Telepon <br>
      <input type="text" name="inp_telp" value="<?php echo $e_inp_telp ?>" required><br><br>
      Foto <br>
      <input type="file" name="inp_foto">
      <input type="text" name="inp_nama_foto" value="<?php echo @$e_inp_foto ?>" style="border:0;" readonly><br><br>

  </td>
  <td valign="top">
     <br>
     <br>
      Username <br>
      <input type="text" name="inp_username" value="<?php echo $e_inp_username ?>" required <?php echo $dis_input2 ?>><br><br>
      Password <br>
      <input type="text" name="inp_password" value="<?php echo $e_inp_password ?>" required <?php echo $dis_input2 ?>><br><br>
      Type User <br>
      <select name="inp_level" required <?php echo @$dis_input2 ?>>
       <option value="">-- pilih tipe user --</option>
       <?php
 $tipeUser = array(
"administrator" => "Administrator",
"karyawan" => "Karyawan"
);
      foreach($tipeUser as $key => $value){
       $e_inp_level==$key?$statSelect="Selected":$statSelect="";
       ?>
       <option value="<?php echo $key ?>" <?php echo $statSelect ?>><?php echo $value ?></option>
       <?php
      }
      ?>
      </select>
      <br><br>
               <?php echo $btn_submit ?>

  </td>
 </tr>
</table>

   </form>
<form method="post" action="?f" class="align-right">
    Pencarian : <input type="text" name="inp_cari" value="<?php echo @$e_safe_cari ?>">
    <select name="inp_filter">
     <?php
    foreach($s_filter as $key => $value){
     $e_safe_filter==$key?$statSelect="Selected":$statSelect="";
     ?>
     <option value="<?php echo $key ?>" <?php echo $statSelect ?>><?php echo $value ?></option>
     <?php
    }
    ?>
    </select>
    <input type="submit" name="inp_btn_cari" value="OK">
   </form>
     <br>

   <table class="table" width="100%">
    <thead>
     <tr>
      <th>No</th>
      <th>NIK</th>
      <th>Nama</th>
      <th>Alamat</th>
      <th>Telepon</th>
      <th>Username</th>
      <th>Password</th>
      <th>Jabatan</th>
      <th>Foto</th>
      <th>Opsi</th>
     </tr>
    </thead>
    <?php
    if (!count($ambildata->stand)) {
     $standMessage = "<center>Data Kosong!</center>";
    }else{
    foreach($ambildata->stand as $idx => $stand){
    $idx++;
    echo "<tbody><tr>";
    ?>
    <td>
     <?php echo $idx ?>
    </td>
    <td>
     <?php echo $stand->NIK ?>
    </td>
    <td class="align-left">
     <?php echo $stand->NmKaryawan ?>
    </td>
    <td class="align-left">
     <?php echo $stand->AlmtKaryawan ?>
    </td>
    <td class="align-left">
     <?php echo $stand->TelpKaryawan ?>
    </td>
    <td class="align-left">
     <?php echo $stand->UserName ?>
    </td>
    <td class="align-left">
     <?php echo $stand->PassWord ?>
    </td>
    <td class="align-left">
     <?php echo $stand->TypeUser ?>
    </td>
    <td>
     <img src="../img/upload/<?php echo $stand->Foto ?>" class="img-table">
    </td>
    <td>
     <a href="?x/<?php echo $stand->NIK ?>">Hapus</a> |
     <a href="?e/<?php echo $stand->NIK ?>">Edit</a>
    </td>
    <?php
    echo "</tr></tbody>";
    }}
    ?>
   </table>
   <?php echo @$standMessage ?>
</div>
</div>
 <br> <?php echo getFooter() ?> </body>
</html>
