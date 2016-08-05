<?php
include("../libs/library.php");
$title_page = "Transaksi Pengembalian";
cek_session("pengembalian","double");
$db_table = "tb_transaksi_sewa";
$dir_path = "pengembalian";
#$btn_submit = '<input type="submit" name="inp_submit" value="Tambah Data">';
$btn_submit = '';
$ambildata = json_decode($db->select($db_table,"*","TglRealKembali = '0000-00-00'"));
$dis_input = "";
$visibility = "";
$inp_kode = @$safe_get_url['1'];
$inp_plat = @$_POST['inp_plat'];
$inp_tgl_real_kembali = @$_POST['inp_tgl_real_kembali'];
$inp_jam_real_kembali = @$_POST['inp_jam_real_kembali'];
$inp_kilometer_kembali = @$_POST['inp_kilometer_kembali'];
$inp_kondisi_kembali = @$_POST['inp_kondisi_kembali'];
$inp_bbm_kembali = @$_POST['inp_bbm_kembali'];
$inp_bbm_awal = @$_POST['inp_btd'];
$inp_denda= @$_POST['inp_td'];
$inp_sopir = @$_POST['inp_sopir'];
$inp_kerusakan = @$_POST['inp_kerusakan'];
$inp_biaya_kerusakan = @$_POST['inp_biaya_kerusakan'];
 $total_bbm = $inp_bbm_awal - $inp_bbm_kembali;
if (substr($total_bbm,0,1)=="-") {
 $tarifBBM = "0";
}else{
 $tarifBBM = $total_bbm*7500;
}
$e_inp_kode = "";
$e_inp_tgl_real_kembali = date("Y-m-d");
$e_inp_kilometer_kembali = "";
$e_inp_kondisi_kembali = "";
$e_inp_bbm_kembali = "";
$e_inp_sopir = "";
$e_inp_kerusakan = "";
$e_inp_biaya_kerusakan = "";

$arrayTarifKendaraan = get_array($db->select("tb_kendaraan","*"),"NoPlat","TarifPerJam");
$arrayPelanggan = get_array($db->select("tb_pelanggan","*"),"NoKTP","NmPelanggan");
$arraySopir = get_array($db->select("tb_sopir","*"),"IDSopir","NmSopir");
$arrayKendaraan = get_array($db->select("tb_kendaraan","*",""),"NoPlat","IDType");
$arrayKendaraan2 = get_array($db->select("qw_type","*"),"IDType","NmType");
$arrayMerk = get_array($db->select("tb_merk","*"),"KodeMerk","NmMerk");
$where = "NoTransaksi ='".@$safe_get_url['1']."'";
$array_update = array(
'NoTransaksi' => $inp_kode,
'TglRealKembali' => $inp_tgl_real_kembali,
'JamRealKembali' => $inp_jam_real_kembali,
'Denda' => $inp_denda,
'KilometerKembali' => $inp_kilometer_kembali,
'KondisiMobilKembali' => $inp_kondisi_kembali,
'BBMKembali' => $inp_bbm_kembali,
'Kerusakan' => $inp_kerusakan,
'BiayaKerusakan' => $inp_biaya_kerusakan,
'BiayaBBM'=>$tarifBBM
);

$s_filter = array(
 'NoTransaksi' => "Nomor Transaksi",
 'NoKTP' => "Nomor KTP Pelanggan"
);

if (isset($_POST['inp_update'])) {
if ($db->update($db_table,$array_update,$where)) {
 $db->update("tb_kendaraan",array('StatusRental'=>'0','TglRiwayat'=>date('Y-m-d')),"NoPlat ='".$inp_plat."'");
 echo js_alert("Sukses!");
}
 echo js_redir("../detail/?e/".$inp_kode);
}
switch($safe_get_url['0']){
 case "f":
  $e_safe_cari = @$_POST['inp_cari'];
  $e_safe_filter = @$_POST['inp_filter'];
  $ambildata = json_decode($db->select($db_table,"*","$e_safe_filter like '%$e_safe_cari%' And TglRealKembali = '0000-00-00'"));
  break;

 case "e":
  $editdata = json_decode($db->select($db_table,"*","NoTransaksi ='".$safe_get_url['1']."' And TglRealKembali = '0000-00-00'"));
  foreach($editdata->stand as $idx => $stand){
  $e_inp_kode = $stand->NoTransaksi;
  $e_inp_pelanggan = $stand->NoKTP;
  $e_inp_plat = $stand->NoPlat;
  $e_inp_tgl_pinjam = $stand->TglPinjam;
  $e_inp_jam_pinjam = $stand->JamPinjam;
  $e_inp_tgl_renc_kembali = $stand->TglRencKembali;
  $e_inp_jam_renc_kembali = $stand->JamRencKembali;
  $e_inp_kilometer_awal = $stand->KilometerPinjam;
  $e_inp_kondisi_awal = $stand->KondisiMobilPinjam;
  $e_inp_bbm_awal = $stand->BBMPinjam;
  $e_inp_sopir = $stand->IDSopir;
  }
  $visibility="display";
  $dis_input = "readonly id='readonly'";
  $btn_submit = '<input type="submit" name="inp_update" value="OK">';
  break;
 default:
    $visibility="";
  break;
}
if (empty($safe_get_url['1'])) {
     $visibility="";
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
 <strong class="title-form">Pilih Transaksi : </strong><br><br>
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
      <th>No Transaksi</th>
      <th>Pelanggan</th>
      <th>No Plat</th>
      <th>Tanggal Pesan</th>
      <th>Waktu Pinjam</th>
      <th>Waktu Rencana Kembali</th>
      <th>Kilometer</th>
      <th>Kondisi</th>
      <th>BBM</th>
      <th>Sopir</th>
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
     <?php echo $stand->NoTransaksi ?>
    </td>
    <td class="align-left">
     <?php echo $arrayPelanggan[$stand->NoKTP] ?>
    </td>
    <td>
     <?php echo $stand->NoPlat ?>
    </td>
    <td>
     <?php echo getFormatTanggal($stand->TglPesan) ?>
    </td>
    <td>
     <?php echo $stand->JamPinjam.", ".getFormatTanggal($stand->TglPinjam) ?>
    </td>
    <td>
     <?php echo $stand->JamRencKembali.", ".getFormatTanggal($stand->TglRencKembali) ?>
    </td>
    <td>
     <?php echo $stand->KilometerPinjam ?> Km
    </td>
    <td class="align-left">
     <?php echo $stand->KondisiMobilPinjam ?>
    </td>
    <td>
     <?php echo $stand->BBMPinjam ?> L
    </td>

    <td class="align-left">
     <?php echo $arraySopir[$stand->IDSopir] ?>
    </td>
    <td>
     <a href="?e/<?php echo $stand->NoTransaksi ?>">Pilih</a>
    </td>
    <?php
    echo "</tr></tbody>";
    }}
    ?>
   </table>
   <?php echo @$standMessage ?>
   <br>
   <br>
   <br>
   <br>

    <form method="post">

<table width="100%" border="0">
 <tr>
 <?php if ($visibility=="display") {?>
  <td width="30%" valign="top">
    <?php
      $total_jam_denda = get_selisih_jam($e_inp_tgl_renc_kembali,$e_inp_jam_renc_kembali,date("Y-m-d"),date("H:i:s"));
      $tarifDenda = $arrayTarifKendaraan[$e_inp_plat]*$total_jam_denda;
    ?>
    <strong class="title-form"> Rincian Data : </strong> <br><br>
      No Transaksi : <strong class="c-blue"><?php echo $e_inp_kode ?></strong><br><br>
      Pelanggan  : <?php echo $e_inp_pelanggan." - ".$arrayPelanggan[$e_inp_pelanggan] ?><br><br>

      Kendaraan  : <?php echo $e_inp_plat." - ".$arrayKendaraan2[$arrayKendaraan[$e_inp_plat]] ?><br><br>

      Waktu Pinjam : <?php echo $e_inp_jam_pinjam.", ".getFormatTanggal($e_inp_tgl_pinjam) ?><br><br>

      Waktu Rencana Kembali : <?php echo $e_inp_jam_renc_kembali.", ".getFormatTanggal($e_inp_tgl_renc_kembali) ?><br><br>

      Kilometer Awal  : <?php echo $e_inp_kilometer_awal ?><br><br>

      Kondisi Awal  : <?php echo $e_inp_kondisi_awal ?><br><br>

      BBM Awal  : <?php echo $e_inp_bbm_awal ?> Liter<br><br>

      Sopir  : <?php echo $e_inp_sopir." - ".$arraySopir[$e_inp_sopir] ?><br><br>

      Denda  : <?php echo getFormatRupiah($tarifDenda) ?><br><br>

  </td>
  <td valign="top">
        <strong class="title-form">Form Input Data :</strong> <br><br>

      <input type="hidden" name="inp_td" value="<?php echo $tarifDenda ?>">
      <input type="hidden" name="inp_btd" value="<?php echo $stand->BBMPinjam ?>">
      <input type="hidden" name="inp_plat" value="<?php echo $e_inp_plat ?>">
      Tgl Realisasi Kembali <br>
      <input type="date" name="inp_tgl_real_kembali" value="<?php echo $e_inp_tgl_real_kembali ?>" required><br><br>
       Jam Realisasi Kembali <br>
      <input type="time" name="inp_jam_real_kembali" value="<?php echo $e_inp_jam_real_kembali ?>" required><br><br>
       Kilometer Kembali <br>
      <input type="text" name="inp_kilometer_kembali" value="<?php echo $e_inp_kilometer_kembali ?>" required><br><br>
      Kondisi Kembali <br>
      <select name="inp_kondisi_kembali" required <?php echo @$dis_input2 ?>>
       <option value="">-- pilih kondisi --</option>
       <?php
      $kondisi = array(
     "baik" => "Baik",
     "rusak" => "Rusak"
     );
      foreach($kondisi as $key => $value){
       $e_inp_kondisi_kembali==$key?$statSelect="Selected":$statSelect="";
       ?>
       <option value="<?php echo $key ?>" <?php echo $statSelect ?>><?php echo $value ?></option>
       <?php
      }
      ?>
      </select><br><br>
      BBM Kembali <br>
      <input type="text" name="inp_bbm_kembali" value="<?php echo $e_inp_bbm_kembali ?>" required><br><br>
       Kerusakan <br>
      <input type="text" name="inp_kerusakan" value="<?php echo $e_inp_kerusakan ?>" required><br><br>

       Biaya Kerusakan <br>
      <input type="text" name="inp_biaya_kerusakan" value="<?php echo $e_inp_biaya_kerusakan ?>" required><br><br>
           <?php echo $btn_submit ?>

  </td>
  <?php } ?>
 </tr>
</table>
<br>
   </form>
<br>
<br>

</div>
</div>
 <br> <?php echo getFooter() ?> </body>
</html>
