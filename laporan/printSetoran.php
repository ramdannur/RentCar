<?php
include("../libs/library.php");
$title_page = "Laporan Pemasukan";
cek_session("printDetail","double");
$db_table = "tb_setoran";
$dir_path = "pengembalian";
#$btn_submit = '<input type="submit" name="inp_submit" value="Tambah Data">';
$btn_submit = '';
$ambildata = json_decode($db->select($db_table,"*"));
$dis_input = "";
$visibility = "";
$inp_kode = @$_POST['inp_kode'];
$inp_tgl_real_kembali = @$_POST['inp_tgl_real_kembali'];
$inp_jam_real_kembali = @$_POST['inp_jam_real_kembali'];
$inp_kilometer_kembali = @$_POST['inp_kilometer_kembali'];
$inp_kondisi_kembali = @$_POST['inp_kondisi_kembali'];
$inp_bbm_kembali = @$_POST['inp_bbm_kembali'];
$inp_sopir = @$_POST['inp_sopir'];
$inp_kerusakan = @$_POST['inp_kerusakan'];
$inp_biaya_kerusakan = @$_POST['inp_biaya_kerusakan'];

$e_inp_kode = "";
$e_inp_tgl_real_kembali = date("Y-m-d");
$e_inp_kilometer_kembali = "";
$e_inp_kondisi_kembali = "";
$e_inp_bbm_kembali = "";
$e_inp_sopir = "";
$e_inp_kerusakan = "";
$e_inp_biaya_kerusakan = "";

$arrayPetugas = get_array($db->select("tb_karyawan","*"),"NIK","NmKaryawan");
$arrayPelanggan = get_array($db->select("tb_pelanggan","*"),"NoKTP","NmPelanggan");
$arrayMerk = get_array($db->select("tb_merk","*"),"KodeMerk","NmMerk");
$where = "NoTransaksi ='".@$safe_get_url['1']."'";

$s_filter = array(
 'NoTransaksi' => "Nomor Transaksi",
 'NoKTP' => "Nomor KTP Pelanggan"
);

switch($safe_get_url['0']){
 case "e":
  $e_safe_tgl_1 =  @$safe_get_url['2'];
  $e_safe_tgl_2 =  @$safe_get_url['3'];
  $e_safe_filter = @$safe_get_url['1'];
  $ambildata = json_decode($db->select($db_table,"*","$e_safe_filter BETWEEN '$e_safe_tgl_1' And '$e_safe_tgl_2'"));
  $visibility="display";
  $dis_input = "readonly id='readonly'";
  $btn_submit = '<input type="submit" name="inp_update" value="OK">';
  break;
 default:
    $visibility="display";
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
<body onload="window.print()">

<br>
<div class="kotak-laporan">
<br>
<table width="100%">
 <tr>
 <td>
  <h1>Sistem Informasi dan Manajemen Rental Mobil<br></h1>
  </td>
    <td rowspan="3" class="align-right">
     <img src="../img/smkwikrama.jpeg" width="75px">
    </td>
 </tr>
 <tr>
 <td>
  Jalan Raya Wangun, kelurahan Sindang Sari, kabupaten Bogor.<br>
  </td>
 </tr>
 <tr>
 <td>
  <strong>Telp/Fax: 0251 - 88918191, Website: smkwikrama.net</strong>
  </td>
 </tr>
</table>
<hr>
<br>
<h2><?php echo $title_page ?></h2>
<br>

 <?php if ($visibility=="display") {?>
   <table class="table" width="100%" border="1">
    <tbody>
     <tr>
      <td>No</td>
      <td>No Setoran</td>
      <td>Tanggal Setoran</td>
      <td>Total Setoran</td>
      <td>Petugas</td>
     </tr>
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
     <?php echo $stand->NoSetoran ?>
    </td>
    <td>
     <?php echo getFormatTanggal($stand->TglSetoran) ?>
    </td>
    <td  class="align-right">
     <?php echo getFormatRupiah($stand->Jumlah) ?>
    </td>
    <td class="align-left">
     <?php echo $arrayPetugas[$stand->NIK] ?>
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
 </tr>
</table>
 <?php
} ?>

<br>
</div>
<br>
<br>

</body>
</html>
