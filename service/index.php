<?php
include("../libs/library.php");
$title_page = "Service Kendaraan";
cek_session("service","double");
$db_table = "tb_service";
$dir_path = "service";
$btn_submit = '<input type="submit" name="inp_submit" value="Tambah Data">';
$ambildata = json_decode($db->select($db_table,"*","","TglService DESC"));
$dis_input = "";
$inp_kode = @$_POST['inp_kode'];
$inp_plat = @$_POST['inp_plat'];
$inp_tgl = @$_POST['inp_tgl'];
$inp_biaya = @$_POST['inp_biaya'];
$inp_JenisService = @$_POST['inp_JenisService'];
$primary = "KodeService";
$e_inp_kode = getKode($db->select($db_table,$primary,"","$primary DESC","0,1"),$primary,"S0");
$e_inp_plat = "";
$e_inp_tgl = "";
$e_inp_biaya = "";
$e_inp_JenisService = "";
$arrayKendaraan = get_array($db->select("tb_kendaraan","*",""),"NoPlat","IDType");
$arrayKendaraan2 = get_array($db->select("qw_type","*"),"IDType","NmType");
$arrayJenis = get_array($db->select("tb_jenis_service","*"),"IDJenisService","NmJenisService");
$arrayPemilik = get_array($db->select("tb_pemilik","*"),"KodePemilik","NmPemilik");
$where = "KodeService ='".@$safe_get_url['1']."'";
$array_insert = array(
 'KodeService' => $inp_kode,
 'NoPlat' => $inp_plat,
 'IDJenisService' => $inp_JenisService,
 'TglService' => $inp_tgl,
 'BiayaService' => $inp_biaya,
);
$array_update = array(
 'NoPlat' => $inp_plat,
 'IDJenisService' => $inp_JenisService,
 'TglService' => $inp_tgl,
 'BiayaService' => $inp_biaya,
);

$s_filter = array(
 'KodeService' => "Kode Service",
 'NoPlat' => "Nomor Plat",
 'IDJenisService' => "Id Jenis Service",
 'TglService' => "Tanggal Service"
);
if (isset($_POST['inp_submit'])) {
if ($db->insert($db_table,$array_insert)) {
 $db->update("tb_kendaraan",array('StatusRental'=>'0','TglRiwayat'=>date('Y-m-d')),"NoPlat ='".$inp_plat."'");
 echo js_alert("Berhasil Ditambahkan!");
}
 echo js_redir("../".$dir_path);
}

if (isset($_POST['inp_update'])) {
if ($db->update($db_table,$array_update,$where)) {
 $db->update("tb_kendaraan",array('StatusRental'=>'0','TglRiwayat'=>date('Y-m-d')),"NoPlat ='".$inp_plat."'");
 echo js_alert("Berhasil Diubah!");
}
 echo js_redir("../".$dir_path);
}
switch($safe_get_url['0']){
  case "a":
  $visibility="visible";
  $e_inp_plat = $safe_get_url['1'];
    $vselect = "a";
    $dis_input2 = "readonly id='readonly'";
  break;

  case "p":
 $db->update("tb_kendaraan",array('StatusRental'=>'2','TglRiwayat'=>date('Y-m-d')),"NoPlat ='".$safe_get_url['1']."'");
  break;

  case "b":
 $db->update("tb_kendaraan",array('StatusRental'=>'0','TglRiwayat'=>date('Y-m-d')),"NoPlat ='".$safe_get_url['1']."'");
  break;

 case "x":
  if ($db->delete($db_table,array('KodeService'=>$safe_get_url['1']))) {
    echo js_alert("Berhasil Dihapus!");
   }
    echo js_redir("../".$dir_path);
  break;

 case "f":
  $e_safe_cari = @$_POST['inp_cari'];
  $e_safe_filter = @$_POST['inp_filter'];
  $ambildata = json_decode($db->select($db_table,"*","$e_safe_filter like '%$e_safe_cari%'","TglService DESC"));
  break;

 case "e":
  $editdata = json_decode($db->select($db_table,"*","KodeService ='".$safe_get_url['1']."'"));
  foreach($editdata->stand as $idx => $stand){
   $e_inp_kode = $stand->KodeService;
   $e_inp_plat = $stand->NoPlat;
   $e_inp_jenis = $stand->IDJenisService;
   $e_inp_tgl = $stand->TglService;
   $e_inp_biaya = $stand->BiayaService;
   $e_inp_JenisService = $stand->IDJenisService;
  }

  $dis_input = "readonly id='readonly'";
  $btn_submit = '<input type="submit" name="inp_update" value="Ubah Data">';
    $visibility="visible";
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
   <?php if (@$visibility=="visible") {?>
    <form method="post">
     <strong class="title-form"> Form Input Data :</strong> <br><br>
      Kode Service <br>
      <input type="text" name="inp_kode" value="<?php echo $e_inp_kode ?>" <?php echo $dis_input ?> required><br><br>
     Kendaraan <br>
      <?php
    if (@$vselect=='a') {
     ?>
           <input type="text" name="inp_plat" value="<?php echo $e_inp_plat ?>" <?php echo @$dis_input2 ?> required>
     <?php
    }else{
     ?><select name="inp_plat">
       <option value="">-- pilih kendaraan --</option>
       <?php
        foreach($arrayKendaraan as $key => $value){
          $e_inp_plat==$key?$statSelect="Selected":$statSelect="";
         ?>
         <option value="<?php echo $key ?>" <?php echo $statSelect ?>><?php echo $key." - ".$arrayKendaraan2[$value] ?></option>
         <?php
        }
        ?>
      </select><?php } ?><br><br>
      Jenis Service <br>
      <select name="inp_JenisService" required>
      <option value="">-- pilih JenisService kendaraan --</option>
       <?php
        foreach($arrayJenis as $key => $value){
          $e_inp_JenisService==$key?$statSelect="Selected":$statSelect="";
         ?>
         <option value="<?php echo $key ?>" <?php echo $statSelect ?>><?php echo $value ?></option>
         <?php
        }
        ?>
      </select><br><br>
      Tanggal Service <br>
      <input type="date" name="inp_tgl" value="<?php echo $e_inp_tgl ?>" required><br><br>
      Biaya Service <br>
      <input type="text" name="inp_biaya" value="<?php echo $e_inp_biaya ?>" required><br><br>
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
      <th>Kode Service</th>
      <th>Plat Nomor</th>
       <th>Jenis Service</th>
       <th>Tanggal Service</th>
      <th>Biaya</th>
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
     <?php echo $stand->KodeService ?>
    </td>
    <td>
     <?php echo $stand->NoPlat ?>
    </td>
    <td class="align-left">
     <?php echo $arrayJenis[$stand->IDJenisService] ?>
    </td>
    <td>
     <?php echo getFormatTanggal($stand->TglService) ?>
    </td>
    <td class="align-right">
     <?php echo getFormatRupiah($stand->BiayaService) ?>
    </td>
    <td>
     <a href="?x/<?php echo $stand->KodeService ?>">Hapus</a> |
     <a href="?e/<?php echo $stand->KodeService ?>">Edit</a>
    </td>
    <?php
    echo "</tr></tbody>";
    }}
    ?>
   </table>
   <?php echo @$standMessage ?>
   <?php }else{
 ?>

Pilih Mobil Yang Akan Diservice: <br><br>
   <table class="table" width="100%">
    <thead>
     <tr>
      <th>No</th>
      <th>Nomor Plat</th>
      <th>Pemilik</th>
      <th>Opsi</th>
     </tr>
    </thead>
    <?php

$ambildata = json_decode($db->select("tb_kendaraan","*","StatusRental ='0'"));
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
     <?php echo $stand->NoPlat ?>
    </td>
    <td class="align-left">
     <?php echo $arrayPemilik[$stand->KodePemilik] ?>
    </td>
    <td>
     <a href="?p/<?php echo $stand->NoPlat ?>">Pilih</a>
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
<br>
<br>

Daftar Mobil Yang Sedang Diservice: <br><br>
   <table class="table" width="100%">
    <thead>
     <tr>
      <th>No</th>
      <th>Nomor Plat</th>
      <th>Pemilik</th>
      <th>Tanggal Mulai Service</th>
      <th>Opsi</th>
     </tr>
    </thead>
    <?php

$ambildata = json_decode($db->select("tb_kendaraan","*","StatusRental ='2'"));
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
     <?php echo $stand->NoPlat ?>
    </td>
    <td class="align-left">
     <?php echo $arrayPemilik[$stand->KodePemilik] ?>
    </td>
    <td>
     <?php echo getFormatTanggal($stand->TglRiwayat) ?>
    </td>
    <td>
     <a href="?b/<?php echo $stand->NoPlat ?>">Batal</a> |
     <a href="?a/<?php echo $stand->NoPlat ?>">Selesai</a>
    </td>
    <?php
    echo "</tr></tbody>";
    }}
    ?>
   </table>
   <?php echo @$standMessage ?>
  </td>

      <?php
    }?>
  </td>

 </tr>
</table>
</div>
</div>
 <br> <?php echo getFooter() ?> </body>
</html>
