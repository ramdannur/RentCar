<?php
include("../libs/library.php");
$title_page = "Merk Kendaraan";
cek_session("merk","double");
$db_table = "tb_merk";
$dir_path = "merk";
$btn_submit = '<input type="submit" name="inp_submit" value="Tambah Data">';
$ambildata = json_decode($db->select($db_table,"*"));
$dis_input = "";
$inp_kode = @$_POST['inp_kode'];
$inp_nama = @$_POST['inp_nama'];
$primary = "KodeMerk";
$e_inp_kode = getKode($db->select($db_table,$primary,"","$primary DESC","0,1"),$primary,"M0");
$e_inp_nama = "";
$where = "KodeMerk ='".@$safe_get_url['1']."'";
$array_insert = array(
 'KodeMerk' => $inp_kode,
 'NmMerk' => $inp_nama
);
$array_update = array(
  'NmMerk' => $inp_nama
);

$s_filter = array(
 'KodeMerk' => "Kode Merk",
 'NmMerk' => "Nama Merk"
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
  if ($db->delete($db_table,array('KodeMerk'=>$safe_get_url['1']))) {
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
  $editdata = json_decode($db->select($db_table,"*","KodeMerk ='".$safe_get_url['1']."'"));
  foreach($editdata->stand as $idx => $stand){
   $e_inp_kode = $stand->KodeMerk;
   $e_inp_nama = $stand->NmMerk;
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
     <strong class="title-form">Form Input Data :</strong> <br><br>
      Kode Merk <br>
      <input type="text" name="inp_kode" value="<?php echo $e_inp_kode ?>" <?php echo $dis_input ?> required><br><br>
      Nama Merk <br>
      <input type="text" name="inp_nama" value="<?php echo $e_inp_nama ?>" required><br><br>
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
    <br>
    <br>
   </form>
   <table class="table" width="100%">
    <thead>
     <tr>
      <th>No</th>
      <th>Kode Merk</th>
      <th>Nama Merk</th>
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
     <?php echo $stand->KodeMerk ?>
    </td>
    <td class="align-left">
     <?php echo $stand->NmMerk ?>
    </td>
    <td>
     <a href="?x/<?php echo $stand->KodeMerk ?>">Hapus</a> |
     <a href="?e/<?php echo $stand->KodeMerk ?>">Edit</a>
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
