<?php
include("../libs/library.php");
$title_page = "Data Kendaraan";
cek_session("kendaraan","double");
$db_table = "tb_kendaraan";
$dir_path = "kendaraan";
$btn_submit = '<input type="submit" name="inp_submit" value="Tambah Data">';
$ambildata = json_decode($db->select($db_table,"*"));
$dis_input = "";
$inp_kode = @$_POST['inp_kode'];
$inp_tahun = @$_POST['inp_tahun'];
$inp_type = @$_POST['inp_type'];
$inp_tarif = @$_POST['inp_tarif'];
$inp_pemilik = @$_POST['inp_pemilik'];
$e_inp_kode = "";
$e_inp_tahun = "";
$e_inp_type = "";
$e_inp_tarif = "";
$e_inp_pemilik = "";
$arrayType = get_array($db->select("tb_type","*","","KodeMerk ASC"),"IDType","NmType");
$arrayType2 = get_array($db->select("qw_type","*"),"IDType","NmMerk");
$arrayPemilik = get_array($db->select("tb_pemilik","*"),"KodePemilik","NmPemilik");
$where = "NoPlat ='".@$safe_get_url['1']."'";
$array_insert = array(
 'NoPlat' => $inp_kode,
 'Tahun' => $inp_tahun,
 'TarifPerJam' => $inp_tarif,
 'IDType' => $inp_type,
 'KodePemilik' => $inp_pemilik
);
$array_update = array(
 'Tahun' => $inp_tahun,
 'TarifPerJam' => $inp_tarif,
 'IDType' => $inp_type,
 'KodePemilik' => $inp_pemilik
);

$s_filter = array(
 'NoPlat' => "Plat Nomor",
 'Tahun' => "Tahun",
 'Tarif' => "Tarif",
 'IDType' => "ID Type",
 'KodePemilik' => "Kode Pemilik"
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
  if ($db->delete($db_table,array('NoPlat'=>$safe_get_url['1']))) {
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
  $editdata = json_decode($db->select($db_table,"*","NoPlat ='".$safe_get_url['1']."'"));
  foreach($editdata->stand as $idx => $stand){
   $e_inp_kode = $stand->NoPlat;
   $e_inp_tahun = $stand->Tahun;
   $e_inp_tarif = $stand->TarifPerJam;
   $e_inp_type = $stand->IDType;
   $e_inp_pemilik = $stand->KodePemilik;
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
      Plat Nomor <br>
      <input type="text" name="inp_kode" value="<?php echo $e_inp_kode ?>" <?php echo $dis_input ?> required><br><br>
      Tahun <br>
      <select name="inp_tahun">
       <?php
        for($key=1965;$key<date('Y');$key++){
          $e_inp_tahun==$key?$statSelect="Selected":$statSelect="";
         ?>
         <option value="<?php echo $key ?>" <?php echo $statSelect ?>><?php echo $key ?></option>
         <?php
        }
        ?>
      </select><br><br>
      Tarif/Jam <br>
      <input type="text" name="inp_tarif" value="<?php echo $e_inp_tarif ?>" required><br><br>
      Type <br>
      <select name="inp_type">
       <option value="">-- pilih pemilik type --</option>
       <?php
        foreach($arrayType as $key => $value){
          $e_inp_type==$key?$statSelect="Selected":$statSelect="";
         ?>
         <option value="<?php echo $key ?>" <?php echo $statSelect ?>><?php echo $value ?> - <?php echo $arrayType2[$key] ?></option>
         <?php
        }
        ?>
      </select><br><br>
      Pemilik <br>
      <select name="inp_pemilik" required>
      <option value="">-- pilih pemilik kendaraan --</option>
       <?php
        foreach($arrayPemilik as $key => $value){
          $e_inp_pemilik==$key?$statSelect="Selected":$statSelect="";
         ?>
         <option value="<?php echo $key ?>" <?php echo $statSelect ?>><?php echo $value ?></option>
         <?php
        }
        ?>
      </select><br><br>
      <?php echo $btn_submit ?>
   </form>
<br>
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
      <th>Nomor Plat</th>
      <th>Tahun</th>
      <th>Tarif/Jam</th>
      <th>Tipe</th>
      <th>Pemilik</th>
      <th>Status</th>
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
     <?php echo $stand->NoPlat ?>
    </td>
    <td>
     <?php echo $stand->Tahun ?>
    </td>
    <td class="align-right">
     <?php echo getFormatRupiah($stand->TarifPerJam) ?>
    </td>
    <td class="align-left">
     <?php echo $arrayType[$stand->IDType]." - ".$arrayType2[$stand->IDType] ?>
    </td>
    <td class="align-left">
     <?php echo $arrayPemilik[$stand->KodePemilik] ?>
    </td>
    <td>
     <?php echo $arrayStatus[$stand->StatusRental] ?>
    </td>
    <td>
     <a href="?x/<?php echo $stand->NoPlat ?>">Hapus</a> |
     <a href="?e/<?php echo $stand->NoPlat ?>">Edit</a>
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
