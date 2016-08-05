<?php
include("../libs/library.php");
$title_page = "Sopir";
cek_session("sopir","admin");
$db_table = "tb_sopir";
$dir_path = "sopir";
$btn_submit = '<input type="submit" name="inp_submit" value="Tambah Data">';
$ambildata = json_decode($db->select($db_table,"*","IDSopir != '0'"));
$dis_input = "";
$inp_kode = @$_POST['inp_kode'];
$inp_nama = @$_POST['inp_nama'];
$inp_alamat = @$_POST['inp_alamat'];
$inp_telp = @$_POST['inp_telp'];
$inp_sim = @$_POST['inp_sim'];
$inp_tarif = @$_POST['inp_tarif'];
$primary = "IDSopir";
$e_inp_kode = getKode($db->select($db_table,$primary,"","$primary DESC","0,1"),$primary,"14");
$e_inp_nama = "";
$e_inp_alamat = "";
$e_inp_telp = "";
$e_inp_sim = "";
$e_inp_tarif = "";
$arrayMerk = get_array($db->select("tb_merk","*"),"KodeMerk","NmMerk");
$where = "IDSopir ='".@$safe_get_url['1']."'";
$array_insert = array(
 'IDSopir' => $inp_kode,
 'NmSopir' => $inp_nama,
 'AlmtSopir' => $inp_alamat,
 'TelpSopir' => $inp_telp,
 'NoSim' => $inp_sim,
 'TarifPerJam' => $inp_tarif
);
$array_update = array(
 'NmSopir' => $inp_nama,
 'AlmtSopir' => $inp_alamat,
 'TelpSopir' => $inp_telp,
 'NoSim' => $inp_sim,
 'TarifPerJam' => $inp_tarif
);

$s_filter = array(
 'IDSopir' => "Kode Sopir",
 'NmSopir' => "Nama Sopir",
 'NoSim' => "Nomor Sim",
 'TarifPerJam' => "Tarif/Jam"
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
  if ($safe_get_url['1']=='0') {
   echo js_alert("invalid number!");
  }else{
  if ($db->delete($db_table,array('IDSopir'=>$safe_get_url['1']))) {
    echo js_alert("Berhasil Dihapus!");
   }
  }
    echo js_redir("../".$dir_path);
  break;

 case "f":
  $e_safe_cari = @$_POST['inp_cari'];
  $e_safe_filter = @$_POST['inp_filter'];
  $ambildata = json_decode($db->select($db_table,"*","$e_safe_filter like '%$e_safe_cari%' And IDSopir != '0'"));
  break;

 case "e":
  $editdata = json_decode($db->select($db_table,"*","IDSopir ='".$safe_get_url['1']."' And IDSopir != '0'"));
  foreach($editdata->stand as $idx => $stand){
   $e_inp_kode = $stand->IDSopir;
   $e_inp_nama = $stand->NmSopir;
   $e_inp_alamat = $stand->AlmtSopir;
   $e_inp_telp = $stand->TelpSopir;
   $e_inp_sim = $stand->NoSim;
   $e_inp_tarif = $stand->TarifPerJam;
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
     <strong class="title-form"> Form Input Data :</strong> <br><br>
      Kode <br>
      <input type="text" name="inp_kode" value="<?php echo $e_inp_kode ?>" <?php echo $dis_input ?> required><br><br>
      Nama Sopir <br>
      <input type="text" name="inp_nama" value="<?php echo $e_inp_nama ?>" required><br><br>
       Alamat <br>
     <textarea type="text" name="inp_alamat" required><?php echo $e_inp_alamat ?></textarea><br><br>
       Nomor Telepon <br>
      <input type="text" name="inp_telp" value="<?php echo $e_inp_telp ?>" required><br><br>
       Nomor SIM <br>
      <input type="text" name="inp_sim" value="<?php echo $e_inp_sim ?>" required><br><br>
       Tarif/Jam <br>
      <input type="text" name="inp_tarif" value="<?php echo $e_inp_tarif ?>" required><br><br>
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
      <th>Nomor SIM</th>
      <th>Tarif/Jam</th>
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
     <?php echo $stand->IDSopir ?>
    </td>
    <td class="align-left">
     <?php echo $stand->NmSopir ?>
    </td>
    <td class="align-left">
     <?php echo $stand->AlmtSopir ?>
    </td>
    <td>
     <?php echo $stand->TelpSopir ?>
    </td>
    <td>
     <?php echo $stand->NoSim ?>
    </td>
    <td class="align-right">
     <?php echo getFormatRupiah($stand->TarifPerJam) ?>
    </td>
    <td>
     <a href="?x/<?php echo $stand->IDSopir ?>">Hapus</a> |
     <a href="?e/<?php echo $stand->IDSopir ?>">Edit</a>
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
