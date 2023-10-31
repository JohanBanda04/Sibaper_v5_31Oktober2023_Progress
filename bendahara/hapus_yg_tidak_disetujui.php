<?php
session_start();
include "../fungsi/koneksi.php";
$tgl_sekarang = date('Y-m-d');
//echo $_POST['hapus_yg_tidak_disetujui'];  die;
$get_data_yg_akan_dihapus = mysqli_query($koneksi,"select * from sementara where 
id_sementara=$_POST[hapus_yg_tidak_disetujui]");
$result_data_yg_akan_dihapus = mysqli_fetch_assoc($get_data_yg_akan_dihapus);

//echo "<pre>"; print_r($result_data_yg_akan_dihapus); die;
//echo count($result_data_yg_akan_dihapus); die;
//echo count($get_data_yg_akan_dihapus); die;
$id_sementara = $_POST['hapus_yg_tidak_disetujui'];
$unit = $_POST['unit'];
$tgl_permintaan = $_POST['tgl_permintaan'];
$user_id = $_POST['user_id'];

if(isset($_POST['hapus_yg_tidak_disetujui'])){

    if(count($result_data_yg_akan_dihapus)>0){
        //hapus data yg ada pd bbrp tabel
        $get_data_sementara = mysqli_query($koneksi,"select * from sementara where id_sementara=$_POST[hapus_yg_tidak_disetujui]");
        $result_data_sementara = mysqli_fetch_assoc($get_data_sementara);

        $data_unit = $result_data_sementara['unit'];
        $data_user_id = $result_data_sementara['user_id'];
        $data_tgl_permintaan = $result_data_sementara['tgl_permintaan'];

        $kode_brg = $result_data_sementara['kode_brg'];
        $jml_brg = $result_data_sementara['jumlah'];

        $get_data_stokbarang = mysqli_query($koneksi,"select * from stokbarang where kode_brg=$kode_brg");
        $result_data_stokbarang = mysqli_fetch_assoc($get_data_stokbarang);

        $jumlah_stok_old = $result_data_stokbarang['stok'];
        $jumlah_keluar_old = $result_data_stokbarang['keluar'];
        $jumlah_sisa_old = $result_data_stokbarang['sisa'];

        $query_update_dt_on_stokbarang = mysqli_query($koneksi,"update stokbarang 
set keluar=($jumlah_keluar_old-$jml_brg),
sisa=($jumlah_sisa_old+$jml_brg) where kode_brg='$kode_brg'");



       // $update_on_stokbarang = mysqli_query($koneksi, "DELETE FROM permintaan WHERE id_sementara=$_POST[hapus_yg_tidak_disetujui]");

        $delete_on_permintaan = mysqli_query($koneksi, "DELETE FROM permintaan WHERE id_sementara=$_POST[hapus_yg_tidak_disetujui]");

        $delete_on_sementara = mysqli_query($koneksi, "DELETE FROM sementara WHERE id_sementara=$_POST[hapus_yg_tidak_disetujui]");

        echo "<script>window.alert('Data Sukses Dihapus Bang Bro!')
		window.location='index.php?p=detilpermintaan_table&unit=$unit&tgl=$tgl_permintaan&user_id_pemohon=$user_id&bendahara_id='</script>";

    } else {
//        echo "<script>window.alert('Maaf Data Sudah Dihapus Oleh Operator Lain')</script>";

        echo "<script>window.alert('Data Sudah Dihapus Oleh Bendahara Lain Bang Bro!')
		window.location='index.php?p=detilpermintaan_table&unit=$unit&tgl=$tgl_permintaan&user_id_pemohon=$user_id&bendahara_id='</script>";
    }

    //$hapus_yg_tidak_disetujui = $_POST['hapus_yg_tidak_disetujui'];
    //echo $hapus_yg_tidak_disetujui;




}



?>