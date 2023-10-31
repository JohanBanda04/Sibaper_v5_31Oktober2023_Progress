<?php
session_start();
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";
include "../classes/class.phpmailer.php";

if(isset($_GET['id_sementara'])){
    $id_sementara = $_GET['id_sementara'];
    $unit = $_GET['unit'];
    $user_id = $_GET['user_id'];
    $tgl_permintaan = $_GET['tgl_permintaan'];

//    echo $id_sementara.'<br>';
//    echo $user_id.'<br>';
//    echo $unit.'<br>';
//    echo $tgl_permintaan; die;

    $query_select_by_id_sementara = mysqli_query($koneksi,"select * from sementara 
where id_sementara='$_GET[id_sementara]'");

    //echo "<pre>"; print_r(mysqli_fetch_assoc($query_select_by_id_sementara)); die;

    $dt_for_tb_sementara = mysqli_fetch_assoc($query_select_by_id_sementara);
    $dt_unit = $dt_for_tb_sementara['unit'];
    $dt_user_id = $dt_for_tb_sementara['user_id'];
    $dt_instansi = $dt_for_tb_sementara['instansi'];
    $dt_kode_brg = $dt_for_tb_sementara['kode_brg'];
    $dt_id_jenis = $dt_for_tb_sementara['id_jenis'];
    $dt_jumlah = $dt_for_tb_sementara['jumlah'];
    $dt_tgl_permintaan = $dt_for_tb_sementara['tgl_permintaan'];
    $dt_status = $dt_for_tb_sementara['status'];
    $dt_id_sementara = $dt_for_tb_sementara['id_sementara'];

//    echo $dt_unit."<br>";
//    echo $dt_user_id."<br>";
//    echo $dt_instansi."<br>";
//    echo $dt_kode_brg."<br>";
//    echo $dt_id_jenis."<br>";
//    echo $dt_jumlah."<br>";
//    echo $dt_tgl_permintaan."<br>";
//    echo $dt_status."<br>";
//    echo $dt_id_sementara."<br>"; die;

    /*UPDATE on tabel sementara*/
    $query = mysqli_query($koneksi,"UPDATE sementara SET acc_kasub=1,
status_acc='Pengajuan Kasub Bendahara' WHERE id_sementara='$id_sementara'");

    /*INSERT on tabel permintaan*/
    $query_insert_permintaan = mysqli_query($koneksi,"INSERT into permintaan
(unit, user_id, instansi, kode_brg, id_jenis, jumlah, tgl_permintaan, status, id_sementara)
VALUES	('$dt_unit', '$dt_user_id', '$dt_instansi',
'$dt_kode_brg', '$dt_id_jenis', '$dt_jumlah','$dt_tgl_permintaan', '$dt_status','$dt_id_sementara')");

//    $query_bk1 = mysqli_query($koneksi,"UPDATE sementara SET acc_kasub=1,
//status_acc='setuju' WHERE id_sementara='$id_sementara'");



    // metode pengiriman email
    $mail = new PHPMailer;

    if($query){
//        mengacu dari kebutuhan parameter get utk halaman detilpermintaan.php seperti dibawah :
//        p=detilpermintaan&unit=Undar&user_id=23&tgl_permintaan=2022-10-04
        header("location:index.php?p=detilpermintaan_table&unit=$unit&user_id=$user_id&tgl_permintaan=$tgl_permintaan");
    } else {
        echo "ada yang salah" . mysqli_error($koneksi);
    }
}




?>

