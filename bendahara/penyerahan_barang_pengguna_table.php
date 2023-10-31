<?php
session_start();

//echo $_POST['unit']."<br>";
//echo $_SESSION['user_id']; die;
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";

$set_post_button = false;

if(isset($_POST['penyerahan_barang_pengguna']) && isset($_POST['id_sementara'])){

    $unit = $_POST['unit'];
    $tgl = $_POST['tgl_permintaan'];
    $user_id_pemohon = $_POST['user_id'];
    $bendahara_id = $_POST['bendahara_id'];

    $bendahara = $_POST['bendahara'];
    $id_sementara = $_POST['id_sementara'];

//    echo $user_id_pemohon."::";
//    echo $unit."::";
//    echo $tgl."::";
//    echo $bendahara_id."::";
//    echo $bendahara."::";
//    echo $id_sementara."::";
    //sampai disini sukses


    $cek_exist_bendahara_id = mysqli_query($koneksi, "select * from sementara where id_sementara='$id_sementara'");
    $result_cek_exist_bendahara_id = mysqli_fetch_assoc($cek_exist_bendahara_id);
    //echo $result_cek_exist_bendahara_id['bendahara_id']; die;

    if($result_cek_exist_bendahara_id['bendahara_id']!=null ){
        echo "<script>window.alert('Maaf, Sudah Ada Operator Lain Yang Memproses Permintaan ini')
		window.location=
		'index.php?p=detilpermintaan_table&unit=$_POST[unit]&tgl=$_POST[tgl_permintaan]&user_id_pemohon=$_POST[user_id]&bendahara_id='
		</script>";
        /*index.php?p=detilpermintaan_table&unit=wika&tgl=2023-10-21&user_id_pemohon=50&bendahara_id=*/
    } else {
        $query_update_serah_ke_pengguna = mysqli_query($koneksi,"update sementara set
status_acc='Penyerahan Barang Ke Pengguna', bendahara='$_SESSION[username]', bendahara_id='$_SESSION[user_id]'
where id_sementara='$id_sementara'");

        if($query_update_serah_ke_pengguna){
            //index.php?p=detilpermintaan&unit=Undar&tgl=2022-10-19&user_id_pemohon=23&bendahara_id=31
            echo "<script>window.alert('Silakan serahkan barang ke Pengguna')
		window.location='index.php?p=detilpermintaan_table&unit=$_POST[unit]&tgl=$_POST[tgl_permintaan]&user_id_pemohon=$_POST[user_id]&bendahara_id=$_POST[bendahara_id]'</script>";

        } else {
            echo "gagal euy cuy" . mysqli_error($koneksi);
        }
    }





}

?>