<?php
@session_start();
error_reporting(0);
include("pdo.class.crud.php");
$db = new crud();
$base_url = "http://127.0.0.1:81/RentCar/";
$url = explode("/",urldecode(getenv('QUERY_STRING')));
foreach($url as $key => $value){
 $get_url[$key] = $value;
 $safe_get_url[$key] = $value;
}
$hari = array(
        'Sun' => "Minggu",
        'Mon' => "Senin",
        'Tue' => "Selasa",
        'Wed' => "Rabu",
        'Thu' => "Kamis",
        'Fri' => "Jum'at",
        'Sat' => "Sabtu"
        );

$bulan = array(
        '01' => "Januari",
        '02' => "Februari",
        '03' => "Maret",
        '04' => "April",
        '05' => "Mei",
        '06' => "Juni",
        '07' => "Juli",
        '08' => "Agustus",
        '09' => "September",
        '10' => "Oktober",
        '11' => "November",
        '12' => "Desember"
        );
$arrayStatus = array(
       '0' => "<font color=green>Ada</font>",
       '1' => "<font color=red>Disewa</font>",
       '2' => "<font color=blue>Diservice</font>"
);
$arrayStatus2 = array(
       '0' => "<font color=red>Belum Bayar</font>",
       '1' => "<font color=blue>Sudah Bayar</font>",
);
function create_session($user,$nik,$level){
 $_SESSION['config_log']="allowed";
 $_SESSION['config_username']=$user;
 $_SESSION['config_nik']=$nik;
 $_SESSION['config_userlevel']=$level;
 return $user.$nik.$level;
}
function do_logout(){
 session_destroy();
}
function cek_session($key,$sessionKey=null){
 if ($key=="login") {
  if (@$_SESSION['config_log']=="allowed") {
   echo js_redir('dasbor');
  }
 }else{
  if (@$_SESSION['config_log']!="allowed") {
   echo js_redir('../libs/logout.php');
  }else{
   if ($sessionKey!="double") {
    if (($sessionKey!="admin")&&($_SESSION['config_userlevel']=="administrator")) {
      echo js_alert('maaf, akses dibatasi!');
      echo js_redir('../dasbor');
    }elseif (($sessionKey=="admin")&&($_SESSION['config_userlevel']=="karyawan")) {
      echo js_alert('maaf, akses dibatasi!');
      echo js_redir('../dasbor');
    }
   }
  }
 }
}
function get_navbar1(){
 ?>
 <div class="navbar1">
 <strong>RENTCAR Apps </strong>||
 <a href="../dasbor">Home</a> |
 <a href="../karyawan/">karyawan</a> |
 <a href="../kendaraan/">Kendaraan</a> |
 <a href="../type">Tipe</a> |
 <a href="../merk">Merk</a> |
 <a href="../service/">Service</a> |
 <a href="../jenisService/">Jenis Service</a> |
 <a href="../pemilik/">Pemilik Kendaraan</a> |
 <a href="../pelanggan/">Pelanggan</a> |
 <a href="../sopir/">Sopir</a> |
 <a href="../sewa/">Sewa</a> |
 <a href="../pengembalian/">Pengembalian</a> |
 <a href="../laporan/lihatRiwayat.php">Riwayat Transaksi</a> |
 <a href="../laporan/lihatDetail.php">Detail Transaksi</a> |
 <a href="../laporan/lihatSetoran.php">Pemasukan</a> |
 <a href="../libs/logout.php" class="c-red">Logout</a>
 </div>
 <?php
}
function js_alert($pesan){
 return "<script>alert('".$pesan."')</script>";
}
function js_redir($tujuan){
 return "<script>document.location.href='".$tujuan."'</script>";
}
function get_array($conn,$id,$id2){
 $json = json_decode($conn);
 foreach($json->stand as $idx => $stand){
  $var[$stand->$id] = $stand->$id2;
 }
 return $var;
}
function getFormatRupiah($nominal){
 return "Rp. ".number_format($nominal);
}
function getFormatTanggal($tanggal){
$bulan = array(
        '00' => "",
        '01' => "Januari",
        '02' => "Februari",
        '03' => "Maret",
        '04' => "April",
        '05' => "Mei",
        '06' => "Juni",
        '07' => "Juli",
        '08' => "Agustus",
        '09' => "September",
        '10' => "Oktober",
        '11' => "November",
        '12' => "Desember"
        );
  $splitTanggal = explode('-',$tanggal);

  $retTanggal = $splitTanggal[2]."-".$bulan[$splitTanggal[1]]."-".$splitTanggal[0];
  if ($splitTanggal[1]="") {
  return "-";
   }else{
 return $retTanggal;
  }
}
function get_selisih_jam($vtgl1,$vjam1,$vtgl2,$vjam2){
   $tgl1 = $vtgl1." ".$vjam1;
   $tgl2 = $vtgl2." ".$vjam2;
   $selisih1 = strtotime($tgl1);
   $selisih2 = strtotime($tgl2);
   $hasil = ($selisih2 - $selisih1)/3600;
   if (substr($hasil,0,1)=="-") {
    $hasil="0";
   }
   return round($hasil);
}
function get_selisih_hari($vtgl1,$vjam1,$vtgl2,$vjam2){
   $tgl1 = $vtgl1." ".$vjam1;
   $tgl2 = $vtgl2." ".$vjam2;
   $selisih1 = strtotime($tgl1);
   $selisih2 = strtotime($tgl2);
   $hasil = ($selisih2 - $selisih1)/3600;
    $hari = $hasil/24;
    $jam = $hasil%$hari;
   if (substr($hasil,0,1)=="-") {
    $hasil="0";
   }
   return round($hari)." hari ".$jam." jam";
}
function getKode($conn,$primary,$prefix){
 $json = json_decode($conn);
 foreach($json->stand as $idx => $stand){
  $kode = "1".substr($stand->$primary,2);
 }
 $kode++;
 return $prefix.substr($kode,1);
}
function getFooter(){
 return '<center class="copyright"><font class="c-blue">'.$_SESSION['config_username'].'</font> | <a href="../ubahAkun">Ubah Username/Password</a><br>Copyright &copy 2016. Developed by Ramdan Nurul</center>';
}
?>
