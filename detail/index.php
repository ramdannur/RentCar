<?php
include("../libs/library.php");
$title_page = "Detail Transaksi";
cek_session("detail","double");
$db_table = "tb_transaksi_sewa";
$dir_path = "detail";
#$btn_submit = '<input type="submit" name="inp_submit" value="Tambah Data">';
$btn_submit = '';
$ambildata = json_decode($db->select($db_table,"*","TglRealKembali != '0000-00-00'"));
$dis_input = "";
$visibility = "";
$inp_kode = @$_POST['inp_kode'];
$inp_kode_setor = @$_POST['inp_kode_setor'];
$inp_pemilik = @$_POST['inp_pemilik'];
$inp_total = @$_POST['inp_total'];
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
$arrayPemilik = get_array($db->select("tb_kendaraan","*"),"NoPlat","KodePemilik");
$arrayTarifKendaraan = get_array($db->select("tb_kendaraan","*"),"NoPlat","TarifPerJam");
$arrayTarifSopir = get_array($db->select("tb_sopir","*"),"IDSopir","TarifPerJam");
$arrayMerk = get_array($db->select("tb_merk","*"),"KodeMerk","NmMerk");
$where = "NoTransaksi ='".@$safe_get_url['1']."'";

$array_insert = array(
 'NoTransaksi' => $inp_kode_setor,
 'TglSetoran' => date("Y-m-d"),
 'KodePemilik' => $inp_pemilik,
 'Jumlah' => $inp_total,
 'NIk' => $_SESSION['config_nik']
);

$s_filter = array(
 'NoTransaksi' => "Nomor Transaksi",
 'NoKTP' => "Nomor KTP Pelanggan"
);

if (isset($_POST['inp_confirm'])) {
 if ($db->insert("tb_setoran",$array_insert)) {
  $db->update("tb_transaksi_sewa",array('StatusBayar'=>'1'),"NoTransaksi ='".$inp_kode_setor."'");
  echo js_alert("Sukses!");
 }
  echo js_redir("../".$dir_path."/?e/".$inp_kode_setor);
}
switch($safe_get_url['0']){
 case "e":
  $editdata = json_decode($db->select($db_table,"*","NoTransaksi ='".$safe_get_url['1']."' And TglRealKembali != '0000-00-00'"));
  foreach($editdata->stand as $idx => $stand){
  $e_inp_kode = $stand->NoTransaksi;
  $e_inp_pelanggan = $stand->NoKTP;
  $e_inp_plat = $stand->NoPlat;
  $e_inp_tgl_pesan = $stand->TglPesan;
  $e_inp_tgl_pinjam = $stand->TglPinjam;
  $e_inp_jam_pinjam = $stand->JamPinjam;
  $e_inp_tgl_renc_kembali = $stand->TglRencKembali;
  $e_inp_jam_renc_kembali = $stand->JamRencKembali;
  $e_inp_kilometer_awal = $stand->KilometerPinjam;
  $e_inp_kondisi_awal = $stand->KondisiMobilPinjam;
  $e_inp_bbm_awal = $stand->BBMPinjam;
  $e_inp_tgl_real_kembali = $stand->TglRealKembali;
  $e_inp_jam_real_kembali = $stand->JamRealKembali;
  $e_inp_kilometer_kembali = $stand->KilometerKembali;
  $e_inp_kondisi_kembali = $stand->KondisiMobilKembali;
  $e_inp_bbm_kembali = $stand->BBMKembali;
  $e_inp_kerusakan = $stand->Kerusakan;
  $e_inp_biaya_kerusakan = $stand->BiayaKerusakan;
  $e_inp_sopir = $stand->IDSopir;
  $e_inp_status = $stand->StatusBayar;
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


 <?php if ($visibility=="display") {?>
<table width="100%" border="0">
 <tr>
  <td width="30%" valign="top">
   <?php
      $total_jam_renc_kembali =  get_selisih_jam($e_inp_tgl_pinjam,$e_inp_jam_pinjam,$e_inp_tgl_renc_kembali,$e_inp_jam_renc_kembali);
      $total_jam_real_kembali =  get_selisih_jam($e_inp_tgl_pinjam,$e_inp_jam_pinjam,$e_inp_tgl_real_kembali,$e_inp_jam_real_kembali);
      $total_jam_denda =  get_selisih_jam($e_inp_tgl_renc_kembali,$e_inp_jam_renc_kembali,$e_inp_tgl_real_kembali,$e_inp_jam_real_kembali);
      $total_hari_renc_kembali =  get_selisih_hari($e_inp_tgl_pinjam,$e_inp_jam_pinjam,$e_inp_tgl_renc_kembali,$e_inp_jam_renc_kembali);
      $total_hari_real_kembali =  get_selisih_hari($e_inp_tgl_pinjam,$e_inp_jam_pinjam,$e_inp_tgl_real_kembali,$e_inp_jam_real_kembali);
      $total_bbm = $e_inp_bbm_awal - $e_inp_bbm_kembali;
       if (substr($total_bbm,0,1)=="-") {
        $tarifBBM = "0";
       }else{
        $tarifBBM = $total_bbm*7500;
       }
      $tarifDenda = $arrayTarifKendaraan[$e_inp_plat]*$total_jam_denda;
      $tarifSewa = $arrayTarifKendaraan[$e_inp_plat]*$total_jam_real_kembali;
      $total_tarif_sewa = $tarifSewa-$tarifDenda;
      $tarifSopir = $arrayTarifSopir[$e_inp_sopir]*$total_jam_real_kembali;
      $total_biaya = $total_tarif_sewa+$tarifDenda+$tarifSopir+$e_inp_biaya_kerusakan+$tarifBBM;
    ?>
    <strong class="title-form"> Rincian Data : </strong>
    <div align="right">
     <a href='../detail/print.php?e/<?php echo $safe_get_url['1'] ?>' target="_blank"><button>Print Data Transaksi</button></a>
     <form method="post">
     <br>
     <br>
    </div>
     <table width="100%" border="1" cellpadding="5">
      <tr>
       <td width="25%">No Transaksi </td>
       <td width="1%"> : </td>
       <td>  <strong class="c-blue"><?php echo $e_inp_kode ?></strong> </td>
      </tr>
      <tr>
       <td>Kendaran</td>
       <td> : </td>
       <td> <?php echo $e_inp_plat." - ".$arrayKendaraan2[$arrayKendaraan[$e_inp_plat]] ?> </td>
      </tr>
      <tr>
       <td>Pelanggan</td>
       <td> : </td>
       <td> <?php echo $arrayKendaraan2[$arrayKendaraan[$e_inp_plat]] ?> </td>
      </tr>
      <tr>
       <td>Nomor KTP</td>
       <td> : </td>
       <td> <?php echo $e_inp_pelanggan ?> </td>
      </tr>
      <tr>
       <td>Nama Pelanggan</td>
       <td> : </td>
       <td> <?php echo $arrayPelanggan[$e_inp_pelanggan] ?> </td>
      </tr>
      <tr>
       <td>Tanggal Pesan</td>
       <td> : </td>
       <td> <?php echo getFormatTanggal($e_inp_tgl_pesan) ?> </td>
      </tr>
      <tr>
       <td>Waktu Pinjam</td>
       <td> : </td>
       <td> <?php echo $e_inp_jam_pinjam.", ".getFormatTanggal($e_inp_tgl_pinjam) ?> </td>
      </tr>
      <tr>
       <td>Waktu Rencana Kembali</td>
       <td> : </td>
       <td> <?php echo $e_inp_jam_renc_kembali.", ".getFormatTanggal($e_inp_tgl_renc_kembali) ?> (<?php
       if($total_jam_renc_kembali<=23){echo $total_jam_renc_kembali." jam";}else{echo $total_hari_renc_kembali;}; ?>)</td>
      </tr>
      <tr>
       <td>Waktu Realisasi Kembali</td>
       <td> : </td>
       <td> <?php echo $e_inp_jam_real_kembali.", ".getFormatTanggal($e_inp_tgl_real_kembali) ?> (<?php if($total_jam_real_kembali<=23){echo $total_jam_real_kembali." jam";}else{echo $total_hari_real_kembali;}; ?>)</td>
      </tr>
      <tr>
       <td>Kilometer Awal</td>
       <td> : </td>
       <td> <?php echo $e_inp_kilometer_awal ?> </td>
      </tr>
      <tr>
       <td>Kilometer Kembali</td>
       <td> : </td>
       <td> <?php echo $e_inp_kilometer_kembali ?> </td>
      </tr>
      <tr>
       <td>Kondisi Awal</td>
       <td> : </td>
       <td> <?php echo $e_inp_kondisi_awal ?> </td>
      </tr>
      <tr>
      <tr>
       <td>Kondisi Kembali</td>
       <td> : </td>
       <td> <?php echo $e_inp_kondisi_kembali ?> </td>
      </tr>
      <tr>
       <td>BBM Awal</td>
       <td> : </td>
       <td> <?php echo $e_inp_bbm_awal ?> Liter</td>
      </tr>
      <tr>
       <td>BBM Kembali</td>
       <td> : </td>
       <td> <?php echo $e_inp_bbm_kembali ?> Liter</td>
      </tr>
      <tr>
       <td>Kerusakan</td>
       <td> : </td>
       <td> <?php echo $e_inp_kerusakan ?></td>
      </tr>
      <tr>
       <td>Sopir</td>
       <td> : </td>
       <td> <?php echo $arraySopir[$e_inp_sopir] ?> </td>
      </tr>
      <tr>
       <td>Status Bayar</td>
       <td> : </td>
       <td> <?php echo $arrayStatus2[$e_inp_status] ?> </td>
      </tr>
     </table>
     <br>

    <strong class="title-form"> Tagihan Pembayaran : </strong> <br><br>
     <table width="100%" border="1" cellpadding="5">
      <tr>
       <td width="25%">No Transaksi </td>
       <td width="1%"> : </td>
       <td>  <strong class="c-blue"><?php echo $e_inp_kode ?></strong> </td>
      </tr>
      <tr>
       <td width="25%"> Biaya Sewa </td>
       <td width="1%"> : </td>
       <td> <?php echo getFormatRupiah($total_tarif_sewa) ?> </td>
      </tr>
      <tr>
       <td width="25%"> Biaya Sopir </td>
       <td width="1%"> : </td>
       <td> <?php echo getFormatRupiah($tarifSopir) ?> </td>
      </tr>
      <tr>
       <td width="25%"> Denda Waktu </td>
       <td width="1%"> : </td>
       <td> <?php echo getFormatRupiah($tarifDenda) ?> (<?php echo $total_jam_denda ?> Jam) </td>
      </tr>
      <tr>
       <td width="25%"> Biaya Kerusakan </td>
       <td width="1%"> : </td>
       <td> <?php echo getFormatRupiah($e_inp_biaya_kerusakan) ?>  </td>
      </tr>
      <tr>
       <td width="25%"> Biaya BBM </td>
       <td width="1%"> : </td>
       <td> <?php echo getFormatRupiah($tarifBBM) ?>  </td>
      </tr>
      <tr>
       <td width="25%"> <strong>Total Bayar</strong> </td>
       <td width="1%"> : </td>
       <td> <strong><?php echo getFormatRupiah($total_biaya) ?></strong>  </td>
      </tr>
     </table>

  </td>

 </tr>
</table>
<br>
<input type="hidden" name="inp_kode_setor" value="<?php echo $e_inp_kode?>">
<input type="hidden" name="inp_pemilik" value="<?php echo $arrayPemilik[$e_inp_plat] ?>">
<input type="hidden" name="inp_total" value="<?php echo $total_biaya ?>">
<div class="align-right">
  <?php
    if ($e_inp_status=="0") {
      ?>
<input type="submit" name="inp_confirm" value="Konfirmasi Pembayaran">
      <?php
    }
  ?>
</div>
<br>
<br>
 </form>
 * keterangan : <br><br>
  <?php
echo "Tarif/Jam Kendaraan : ".getFormatRupiah($arrayTarifKendaraan[$e_inp_plat])."<br>";
echo "Tarif/Jam Sopir : ".getFormatRupiah($arrayTarifSopir[$e_inp_sopir])."<br>";
 ?>

 <?php
} ?>

<br>
<br>
<br>

</div>
</div>
 <br> <?php echo getFooter() ?> </body>
</html>
