<?php
include("../libs/library.php");
$title_page = "Pemilik Kendaraan";
cek_session("pemilik","admin");
$db_table = "tb_pemilik";
$dir_path = "pemilik";
$btn_submit = '<input type="submit" name="inp_submit" value="Tambah Data">';
$ambildata = json_decode($db->select($db_table,"*"));
$dis_input = "";
$inp_kode = @$_POST['inp_kode'];
$inp_nama = @$_POST['inp_nama'];
$inp_alamat = @$_POST['inp_alamat'];
$inp_telp = @$_POST['inp_telp'];
$primary = "KodePemilik";
$e_inp_kode = getKode($db->select($db_table,$primary,"","$primary DESC","0,1"),$primary,"PK");
$e_inp_nama = "";
$e_inp_alamat = "";
$e_inp_telp = "";
$arrayMerk = get_array($db->select("tb_merk","*"),"KodeMerk","NmMerk");
$where = "KodePemilik ='".@$safe_get_url['1']."'";
$array_insert = array(
 'KodePemilik' => $inp_kode,
 'NmPemilik' => $inp_nama,
 'AlmtPemilik' => $inp_alamat,
 'TelpPemilik' => $inp_telp
);
$array_update = array(
 'NmPemilik' => $inp_nama,
 'AlmtPemilik' => $inp_alamat,
 'TelpPemilik' => $inp_telp
);

$s_filter = array(
 'KodePemilik' => "Kode Pemilik",
 'NmPemilik' => "Nama Pemilik"
);
if (isset($_POST['inp_submit'])) {
if ($db->insert($db_table,$array_insert)) {
 echo js_alert("Berhasil Ditambahkan!");
}
 echo js_redir("../".$dir_path);
}

if (isset($_POST['inp_update'])) {
if ($db->update($db_table,$array_update,$where)) {
 echo js_alert("Berhasil Diubah!");
}
 echo js_redir("../".$dir_path);
}
switch($safe_get_url['0']){
 case "x":
  if ($db->delete($db_table,array('KodePemilik'=>$safe_get_url['1']))) {
    echo js_alert("Berhasil Dihapus!");
   }
    echo js_redir("../".$dir_path);
  break;

 case "f":
  $e_safe_cari = @$_POST['inp_cari'];
  $e_safe_filter = @$_POST['inp_filter'];
  $ambildata = json_decode($db->select($db_table,"*","$e_safe_filter like '%$e_safe_cari%'"));
  break;

 case "e":
  $editdata = json_decode($db->select($db_table,"*","KodePemilik ='".$safe_get_url['1']."'"));
  foreach($editdata->stand as $idx => $stand){
   $e_inp_kode = $stand->KodePemilik;
   $e_inp_nama = $stand->NmPemilik;
   $e_inp_alamat = $stand->AlmtPemilik;
   $e_inp_telp = $stand->TelpPemilik;
  }

  $dis_input = "readonly id='readonly'";
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
<table width="100%" border="0">
 <tr>
  <td width="30%" valign="top">

    <form method="post">
     <strong class="title-form">Form Input Data : </strong><br><br>
      Kode <br>
      <input type="text" name="inp_kode" value="<?php echo $e_inp_kode ?>" <?php echo $dis_input ?> required><br><br>
      Nama Pemilik <br>
      <input type="text" name="inp_nama" value="<?php echo $e_inp_nama ?>" required><br><br>
       Alamat <br>
     <textarea type="text" name="inp_alamat" required><?php echo $e_inp_alamat ?></textarea><br><br>
       Nomor Telepon <br>
      <input type="text" name="inp_telp" value="<?php echo $e_inp_telp ?>" required><br><br>
      <?php echo $btn_submit ?>
   </form>

  </td>
  <td valign="top">
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
      <th>Kode</th>
      <th>Nama</th>
      <th>Alamat</th>
      <th>Telepon</th>
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
     <?php echo $stand->KodePemilik ?>
    </td>
    <td class="align-left">
     <?php echo $stand->NmPemilik ?>
    </td>
    <td class="align-left">
     <?php echo $stand->AlmtPemilik ?>
    </td>
    <td>
     <?php echo $stand->TelpPemilik ?>
    </td>
    <td>
     <a href="?x/<?php echo $stand->KodePemilik ?>">Hapus</a> |
     <a href="?e/<?php echo $stand->KodePemilik ?>">Edit</a>
    </td>
    <?php
    echo "</tr></tbody>";
    }}
    ?>
   </table>
   <?php echo @$standMessage ?>
  </td>

 </tr>
</table>
</div>
</div>
 <br> <?php echo getFooter() ?> </body>
</html>
