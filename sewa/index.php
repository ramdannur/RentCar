<?php
include("../libs/library.php");
$title_page = "Transaksi Sewa";
cek_session("sewa","double");
$db_table = "tb_transaksi_sewa";
$dir_path = "sewa";
$btn_submit = '<input type="submit" name="inp_submit" value="Tambah Data">';
$ambildata = json_decode($db->select($db_table,"*","TglRealKembali = '0000-00-00'"));
$dis_input = "";
$inp_kode = @$_POST['inp_kode'];
$inp_pelanggan = @$_POST['inp_pelanggan'];
$inp_plat = @$_POST['inp_plat'];
$inp_plat2 = @$_POST['inp_plat2'];
$inp_tgl_pesan = date("Y-m-d");
$inp_jam_pinjam = @$_POST['inp_jam_pinjam'];
$inp_tgl_pinjam = @$_POST['inp_tgl_pinjam'];
$inp_tgl_renc_kembali = @$_POST['inp_tgl_renc_kembali'];
$inp_jam_renc_kembali = @$_POST['inp_jam_renc_kembali'];
$inp_kilometer_awal = @$_POST['inp_kilometer_awal'];
$inp_kondisi_awal = @$_POST['inp_kondisi_awal'];
$inp_bbm_awal = @$_POST['inp_bbm_awal'];
$inp_sopir = @$_POST['inp_sopir'];

$primary = "NoTransaksi";
$e_inp_kode = getKode($db->select($db_table,$primary,"","$primary DESC","0,1"),$primary,"R0");
$e_inp_pelanggan = "";
$e_inp_plat = "";
$e_inp_tgl_pinjam = "";
$e_inp_jam_pinjam = "";
$e_inp_tgl_renc_kembali = "";
$e_inp_jam_renc_kembali = "";
$e_inp_kilometer_awal = "";
$e_inp_kondisi_awal = "";
$e_inp_bbm_awal = "";
$e_inp_sopir = "";

$arrayPelanggan = get_array($db->select("tb_pelanggan","NoKTP,NmPelanggan"),"NoKTP","NmPelanggan");
$arraySopir = get_array($db->select("tb_sopir","IDSopir,NmSopir"),"IDSopir","NmSopir");
$fetchKendaraan = get_array($db->select("tb_kendaraan","NoPlat,IDType","StatusRental ='0'"),"NoPlat","IDType");
$arrayKendaraan = get_array($db->select("tb_kendaraan","NoPlat,IDType",""),"NoPlat","IDType");
$arrayKendaraan2 = get_array($db->select("qw_type","*"),"IDType","NmType");
$arrayMerk = get_array($db->select("tb_merk","*"),"KodeMerk","NmMerk");
$where = "NoTransaksi ='".@$safe_get_url['1']."'";
$array_insert = array(
'NoTransaksi' => $inp_kode,
'NoKTP' => $inp_pelanggan,
'NoPlat' => $inp_plat,
'TglPesan' => date("Y-m-d"),
'TglPinjam' => $inp_tgl_pinjam,
'JamPinjam' => $inp_jam_pinjam,
'TglRencKembali' => $inp_tgl_renc_kembali,
'JamRencKembali' => $inp_jam_renc_kembali,
'KilometerPinjam' => $inp_kilometer_awal,
'KondisiMobilPinjam' => $inp_kondisi_awal,
'BBMPinjam' => $inp_bbm_awal,
'IDSopir' => $inp_sopir
);
$array_update = array(
'NoTransaksi' => $inp_kode,
'NoPlat' => $inp_plat,
'TglPinjam' => $inp_tgl_pinjam,
'JamPinjam' => $inp_jam_pinjam,
'TglRencKembali' => $inp_tgl_renc_kembali,
'JamRencKembali' => $inp_jam_renc_kembali,
'KilometerPinjam' => $inp_kilometer_awal,
'KondisiMobilPinjam' => $inp_kondisi_awal,
'BBMPinjam' => $inp_bbm_awal,
'IDSopir' => $inp_sopir
);

$s_filter = array(
 'NoTransaksi' => "Nomor Transaksi",
 'NoKTP' => "Nomor KTP Pelanggan"
);
if (isset($_POST['inp_submit'])) {
if ($db->insert($db_table,$array_insert)) {
 $db->update("tb_kendaraan",array('StatusRental'=>'1'),"NoPlat ='".$inp_plat."'");
 echo js_alert("Berhasil Ditambahkan!");
}
 echo js_redir("../".$dir_path);
}

if (isset($_POST['inp_update'])) {
if ($db->update($db_table,$array_update,$where)) {
 $db->update("tb_kendaraan",array('StatusRental'=>'0'),"NoPlat ='".$inp_plat2."'");
 $db->update("tb_kendaraan",array('StatusRental'=>'1'),"NoPlat ='".$inp_plat."'");
 echo js_alert("Berhasil Diubah!");
}
 echo js_redir("../".$dir_path);
}
switch($safe_get_url['0']){
 case "x":
  if ($db->delete($db_table,array('NoTransaksi'=>$safe_get_url['1']))) {
   $db->update("tb_kendaraan",array('StatusRental'=>'0'),"NoPlat ='".$inp_plat2."'");
    echo js_alert("Transaksi Berhasil Dibatalkan!");
   }
    echo js_redir("../".$dir_path);
  break;

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
    <form method="post">

<table width="100%" border="0">
 <tr>
  <td width="30%" valign="top">

   <strong class="title-form">Form Input Data :</strong> <br><br>
      No Transaksi <br>
      <input type="text" name="inp_kode" value="<?php echo $e_inp_kode ?>" <?php echo $dis_input ?> required><br><br>
      Pelanggan <br>
      <select name="inp_pelanggan" required>
      <option value="">-- pilih pelanggan --</option>
       <?php
        foreach($arrayPelanggan as $key => $value){
          $e_inp_pelanggan==$key?$statSelect="Selected":$statSelect="";
         ?>
         <option value="<?php echo $key ?>" <?php echo $statSelect ?>><?php echo $value ?></option>
         <?php
        }
        ?>
      </select><br>
      <a href="../pelanggan/?ref=transaksi">klik disini</a> untuk menambahkan pelanggan.<br><br>
      Kendaraan <br>
      <select name="inp_plat">
       <option value="">-- pilih kendaraan --</option>
       <?php
           if ($e_inp_plat!="") {
           ?>
           <option value="<?php echo $e_inp_plat ?>" Selected><?php echo $e_inp_plat." - ".$arrayKendaraan2[$arrayKendaraan[$e_inp_plat]] ?></option>
           <?php
          }
        foreach($fetchKendaraan as $key => $value){
          $e_inp_plat==$key?$statSelect="Selected":$statSelect="";
         ?>
         <option value="<?php echo $key ?>" <?php echo $statSelect ?>><?php echo $key." - ".$arrayKendaraan2[$value] ?></option>
         <?php
        }
        ?>
      </select>
      <input type="hidden" name="inp_plat2" value="<?php echo $e_inp_plat ?>" required><br><br>
      Jam Pinjam <br>
      <input type="time" name="inp_jam_pinjam" value="<?php echo $e_inp_jam_pinjam ?>" required><br><br>
      Tgl Pinjam <br>
      <input type="date" name="inp_tgl_pinjam" value="<?php echo $e_inp_tgl_pinjam ?>" required><br><br>



  </td>
  <td valign="top">
    <br>
     Jam Rencana Kembali <br>
      <input type="time" name="inp_jam_renc_kembali" value="<?php echo $e_inp_jam_renc_kembali ?>" required><br><br>
      Tgl Rencana Kembali <br>
      <input type="date" name="inp_tgl_renc_kembali" value="<?php echo $e_inp_tgl_renc_kembali ?>" required><br><br>
       Kilometer Awal <br>
      <input type="text" name="inp_kilometer_awal" value="<?php echo $e_inp_kilometer_awal ?>" required><br><br>
      Kondisi Awal <br>
      <select name="inp_kondisi_awal" required <?php echo @$dis_input2 ?>>
       <option value="">-- pilih kondisi --</option>
       <?php
      $kondisi = array(
     "baik" => "Baik",
     "rusak" => "Rusak"
     );
      foreach($kondisi as $key => $value){
       $e_inp_kondisi_awal==$key?$statSelect="Selected":$statSelect="";
       ?>
       <option value="<?php echo $key ?>" <?php echo $statSelect ?>><?php echo $value ?></option>
       <?php
      }
      ?>
      </select><br><br>
      BBM Awal <br>
      <input type="text" name="inp_bbm_awal" value="<?php echo $e_inp_bbm_awal ?>" required><br><br>
      Sopir <br>
      <select name="inp_sopir" required>
      <option value="">-- pilih sopir --</option>
       <?php
        foreach($arraySopir as $key => $value){
          $e_inp_sopir==$key?$statSelect="Selected":$statSelect="";
         ?>
         <option value="<?php echo $key ?>" <?php echo $statSelect ?>><?php echo $value ?></option>
         <?php
        }
        ?>
      </select><br><br>
  </td>

 </tr>
</table>
     <?php echo $btn_submit ?>
<br>
   </form>
<br>
<br>

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
     <a href="?x/<?php echo $stand->NoTransaksi ?>">Batal</a> |
     <a href="?e/<?php echo $stand->NoTransaksi ?>">Edit</a>
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
</div>
</div>
 <br> <?php echo getFooter() ?> </body>
</html>
