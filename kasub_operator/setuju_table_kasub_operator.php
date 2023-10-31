<?php
session_start();
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";

if(isset($_GET['id_sementara'])){
    $id_sementara = $_GET['id_sementara'];
    //echo "id sementara cuy : ".$id_sementara; die;
    $unit = $_GET['unit'];
    $user_id = $_GET['user_id'];
    $tgl_permintaan = $_GET['tgl_permintaan'];

    //metode taruh variabel di alert php II
    echo '<script language="javascript">alert("'.$unit." ".$user_id." ".$tgl_permintaan." ".'")';
    echo '</script>';



    $get_data_from_sementara = mysqli_query($koneksi,"select * from `sementara` where id_sementara='$id_sementara'");
    $result_data_from_sementara = mysqli_fetch_assoc($get_data_from_sementara);


    $dt_unit_for_pengeluaran = $result_data_from_sementara['unit'];
    $dt_userID_for_pengeluaran = $result_data_from_sementara['user_id'];
    $dt_kodeBrg_for_pengeluaran = $result_data_from_sementara['kode_brg'];
    $dt_jumlah_for_pengeluaran = $result_data_from_sementara['jumlah'];
    $dt_tglKeluar_for_pengeluaran = date('Y-m-d');
    $dt_idSementara_for_pengeluaran = $result_data_from_sementara['id_sementara'];



    /*update tabel sementara*/
    $get_data_stokbarang_by_kodeBarang = mysqli_query($koneksi, "select * from stokbarang where kode_brg='$dt_kodeBrg_for_pengeluaran'");
    $result_data_stokbarang_by_kodeBarang = mysqli_fetch_assoc($get_data_stokbarang_by_kodeBarang);

    $dt_stok_byKodeBrg = $result_data_stokbarang_by_kodeBarang['stok'];
    $dt_keluar_byKodeBrg = $result_data_stokbarang_by_kodeBarang['keluar'];
    $dt_sisa_byKodeBrg = $result_data_stokbarang_by_kodeBarang['sisa'];

    $dt_sisa_old = $result_data_stokbarang_by_kodeBarang['sisa'];
    $dt_keluar_old = $result_data_stokbarang_by_kodeBarang['keluar'];

//    echo "data barang old : <br>";
//    echo "sisa old : ".$dt_sisa_old."<br>";
//    echo "keluar old : ".$dt_keluar_old."<br>";
//
//    echo "data barang yang diminta : <br>";
//    echo "barang yg diminta : ".$dt_jumlah_for_pengeluaran."<br>";
//
//    echo "data keluar baru:". ($dt_keluar_old+$dt_jumlah_for_pengeluaran)."<br>";
//    echo "data sisa baru :". ($dt_sisa_old-$dt_jumlah_for_pengeluaran)."<br>";
//    die;


    //$sisa_brg_toUpdate = $dt_sisa_byKodeBrg - $dt_jumlah_for_pengeluaran;

//    echo $dt_jumlah_for_pengeluaran."<br>";
//    echo $_GET['id_sementara']."<br>";
//    echo $dt_stok_byKodeBrg."<br>";
//    echo $dt_kodeBrg_for_pengeluaran."<br>"; die;
//    echo $sisa_brg_toUpdate."<br>"; die;

//    echo $dt_keluar_byKodeBrg."<br>";
//    echo $dt_jumlah_for_pengeluaran."<br>";
//    echo $dt_stok_byKodeBrg."<br>"; die;




    $query_update_tbl_sementara = mysqli_query($koneksi,"update sementara set acc_kasub=1, 
status_acc='Setuju Kasub Bendahara' where id_sementara='$id_sementara'");

    $query_insert_to_pengeluaran = mysqli_query($koneksi,"insert into pengeluaran
(unit,user_id,kode_brg,jumlah,tgl_keluar,id_sementara)
values('$dt_unit_for_pengeluaran','$dt_userID_for_pengeluaran','$dt_kodeBrg_for_pengeluaran',
'$dt_jumlah_for_pengeluaran','$dt_tglKeluar_for_pengeluaran','$dt_idSementara_for_pengeluaran')");

    $query_update_stokbarang = mysqli_query($koneksi,"update stokbarang 
set keluar=($dt_keluar_old+$dt_jumlah_for_pengeluaran),
 sisa=($dt_sisa_old-$dt_jumlah_for_pengeluaran) where kode_brg='$dt_kodeBrg_for_pengeluaran'");


    if($query_update_stokbarang && $query_update_tbl_sementara && $query_insert_to_pengeluaran){
//        mengacu dari kebutuhan parameter get utk halaman detilpermintaan.php seperti dibawah :
//        p=detilpermintaan&unit=Undar&user_id=23&tgl_permintaan=2022-10-04
//        p=detilpermintaan&unit=Bela&user_id=26&tgl_permintaan=2022-10-10
        header("location:index.php?p=detilpermintaan_table&unit=$unit&user_id=$user_id&tgl_permintaan=$tgl_permintaan");
        ///index.php?p=detilpermintaan_table&unit=wika&user_id=50&tgl_permintaan=2023-10-21

    } else {
        echo "ada yang salah" . mysqli_error($koneksi);
    }
}




?>

