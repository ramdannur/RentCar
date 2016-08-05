<?php
include("../libs/library.php");
$title_page = "Laporan Riwayat Transaksi";
cek_session("laporan","double");
$db_table = "tb_transaksi_sewa";
$dir_path = "laporan";
#$btn_submit = '<input type="submit" name="inp_submit" value="Tambah Data">';
$btn_submit = '';
$ambildata = json_decode($db->select($db_table,"*","TglRealKembali != '0000-00-00'"));
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
'KilometerKembali' => $inp_kilometer_kembali,
'KondisiMobilKembali' => $inp_kondisi_kembali,
'BBMKembali' => $inp_bbm_kembali,
'Kerusakan' => $inp_kerusakan,
'BiayaKerusakan' => $inp_biaya_kerusakan,
);

$s_filter = array(
 'TglPesan' => "Tanggal Pesan",
 'TglPinjam' => "Tanggal Pinjam",
 'TglRencKembali' => "Tanggal Rencana Kembali",
 'TglRealKembali' => "Tanggal Realisasi Kembali"
);
if (isset($_POST['inp_update'])) {
if ($db->update($db_table,$array_update,$where)) {
 echo js_alert("Berhasil Diubah!");
}
 echo js_redir("../".$dir_path);
}
switch($safe_get_url['0']){
 case "f":
  $e_safe_tgl_1 = @$_POST['inp_tgl_1'];
  $e_safe_tgl_2 = @$_POST['inp_tgl_2'];
  $e_safe_filter = @$_POST['inp_filter'];
  $ambildata = json_decode($db->select($db_table,"*","$e_safe_filter BETWEEN '$e_safe_tgl_1' And '$e_safe_tgl_2' And TglRealKembali != '0000-00-00'"));
  break;
 case "d":
  if (isset($_POST['inp_btn_pesan'])) {
    $e_safe_tgl_1 = date("Y-m-")."01";
    $e_safe_tgl_2 = date("Y-m-d");
    $e_safe_filter = "TglPesan";
  }
  if (isset($_POST['inp_btn_pinjam'])) {
    $e_safe_tgl_1 = date("Y-m-")."01";
    $e_safe_tgl_2 = date("Y-m-d");
    $e_safe_filter = "TglPinjam";
  }
  if (isset($_POST['inp_btn_real'])) {
    $e_safe_tgl_1 = date("Y-m-")."01";
    $e_safe_tgl_2 = date("Y-m-d");
    $e_safe_filter = "TglRealKembali";
  }
 $ambildata = json_decode($db->select($db_table,"*","$e_safe_filter BETWEEN '$e_safe_tgl_1' And '$e_safe_tgl_2' And TglRealKembali != '0000-00-00'"));
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
<form method="post" action="?f" class="align-center">
    Pencarian : <br><br>
    <input type="date" name="inp_tgl_1" value="<?php echo @$e_safe_tgl_1 ?>">
    <input type="date" name="inp_tgl_2" value="<?php echo @$e_safe_tgl_2 ?>"><br><br>
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
 <br>
 <form method="post" action="?d">
 <button name="inp_btn_pesan">Transaksi Pemesanan<br> Mobil Bulan ini</button>
 <button name="inp_btn_pinjam">Transaksi Pinjam <br> Mobil Bulan ini</button>
 <button name="inp_btn_real">Transaksi Rencana <br>Pengembalian Mobil Bulan ini</button>
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
      <th>Waktu Realisasi Kembali</th>
      <th>Waktu Rencana Kembali</th>
      <th>Sopir</th>
      <th>Status Bayar</th>
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
     <?php echo $stand->JamRealKembali.", ".getFormatTanggal($stand->TglRealKembali) ?>
    </td>
    <td>
     <?php echo $arraySopir[$stand->IDSopir] ?>
    </td>
    <td>
     <?php echo $arrayStatus2[$stand->StatusBayar] ?>
    </td>
    <td>
     <a href="../detail/?e/<?php echo $stand->NoTransaksi ?>">Detail</a> |
     <a href="../detail/print.php?e/<?php echo $stand->NoTransaksi ?>">Print</a>
    </td>
    <?php
    echo "</tr></tbody>";
    }}
    ?>
   </table>
   <?php echo @$standMessage ?>
   <br>
   <?php if ($safe_get_url['0']=="f" || $safe_get_url['0']=="d"){ ?>
     <a href="printRiwayat.php?e/<?php echo @$e_safe_filter."/".@$e_safe_tgl_1."/".@$e_safe_tgl_2 ?>" target="_blank"><button>Print</button></a>
   <?php }else{ ?>
     <a href="printRiwayat.php" target="_blank"><button>Print</button></a>
   <?php } ?>
   <br>
   <br>
   <br>

</div>
</div><br>
<?php echo getFooter() ?>
</body>
</html>
