<?php
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";
include "../classes/class.phpmailer.php";

//echo $_SESSION['user_id']; die;
//echo $_GET['unit']."<br>";
//echo $_GET['user_id']; die;

//echo $_SESSION['subbidang_id']; die;






$get_dt_operator_tujuan = mysqli_query($koneksi,"select * from user where jabatan='Operator'
 and subbidang_id='$_SESSION[subbidang_id]' 
");

/*kukus*/
while ($result_email_para_operator = mysqli_fetch_array($get_dt_operator_tujuan)) {
    //echo $result_email_para_operator['nama_lengkap']."<br>";
}
//die;

$result_dt_operator_tujuan = mysqli_fetch_assoc($get_dt_operator_tujuan);

//echo "<pre>"; print_r($result_dt_operator_tujuan); die;

$get_dt_kasub_operator_pengirim = mysqli_query($koneksi,"select * from `user` where subbidang_id='$_SESSION[subbidang_id]' 
and jabatan='Kasub Operator'");
$result_dt_kasub_operator_pengirim = mysqli_fetch_assoc($get_dt_kasub_operator_pengirim);



$data_email_operator_tujuan = $result_dt_operator_tujuan['email'];
$data_email_kasub_operator_pengirim = $result_dt_kasub_operator_pengirim['email'];

$data_nama_lengkap_operator_tujuan = $result_dt_operator_tujuan['nama_lengkap'];
$data_nama_lengkap_kasub_operator_pengirim = $result_dt_kasub_operator_pengirim['nama_lengkap'];

$data_subbidang_id_operator_tujuan = $result_dt_operator_tujuan['subbidang_id'];
$data_subbidang_id_kasub_operator_pengirim = $result_dt_kasub_operator_pengirim['subbidang_id'];

$get_dt_subbidang_tujuan = mysqli_query($koneksi,"select * from `subbidang` 
where id_subbidang='$data_subbidang_id_operator_tujuan'");
$result_dt_subbidang_tujuan = mysqli_fetch_assoc($get_dt_subbidang_tujuan);

$get_dt_subbidang_kasub_operator_pengirim = mysqli_query($koneksi,"select * from `subbidang` 
where id_subbidang='$data_subbidang_id_kasub_operator_pengirim'");

$result_dt_subbidang_kasub_operator_pengirim = mysqli_fetch_assoc($get_dt_subbidang_kasub_operator_pengirim);

//echo "<pre>"; print_r($result_dt_subbidang_tujuan);
//echo "<pre>"; print_r($result_dt_subbidang_kasub_operator_pengirim); die;

$data_nama_subbidang_operator_tujuan = $result_dt_subbidang_tujuan['nama_subbidang'];
$data_nama_subbidang_kasub_operator_pengirim = $result_dt_subbidang_kasub_operator_pengirim['nama_subbidang'];

$data_jabatan_detail_operator_tujuan = $result_dt_operator_tujuan['jabatan_detail'];
$data_jabatan_detail_kasub_operator_pengirim = $result_dt_kasub_operator_pengirim['jabatan_detail'];

/*kucos*/
//echo $data_email_operator_tujuan."<br>";
//echo $data_email_kasub_operator_pengirim."<br>";
//
//echo $data_nama_lengkap_operator_tujuan."<br>";
//echo $data_nama_lengkap_kasub_operator_pengirim."<br>";
//
//echo $data_nama_subbidang_operator_tujuan."<br>";
//echo $data_nama_subbidang_kasub_operator_pengirim."<br>";
//
//echo $data_jabatan_detail_operator_tujuan."<br>";
//echo $data_jabatan_detail_kasub_operator_pengirim."<br>";
//die;

//echo "<pre>"; print_r($result_dt_operator_tujuan); die;


$dt_get_data_pengirim = mysqli_query($koneksi, "select * from `user` where id_user='$_SESSION[user_id]'");
$result_data_pengirim = mysqli_fetch_assoc($dt_get_data_pengirim);

$dt_get_data_subbidang_pengirim = mysqli_query($koneksi,"select * from subbidang where id_subbidang='$result_data_pengirim[subbidang_id]'");
$result_data_subbidang_pengirim = mysqli_fetch_assoc($dt_get_data_subbidang_pengirim);

$data_email_pengirim = $result_data_pengirim['email'];
$data_nama_lengkap_pengirim = $result_data_pengirim['nama_lengkap'];
$data_subbidang_id_pengirim = $result_data_pengirim['subbidang_id'];

$data_nama_subbidang_pengirim = $result_data_subbidang_pengirim['nama_subbidang'];
$data_jabatan_detail_pengirim = $result_data_pengirim['jabatan_detail'];


//echo "<pre>"; print_r($result_data_pengirim);
//echo "<pre>"; print_r($result_data_subbidang_pengirim); die;

/*resulf*/
$dt_get_data_staf = mysqli_query($koneksi,"select * from `user` where subbidang_id='$_SESSION[subbidang_id]' and jabatan='Operator'");
$result_data_staf = mysqli_fetch_assoc($dt_get_data_staf);

$dt_email_staf_tujuan = $result_data_staf['email'];
$dt_nama_lengkap_staf_tujuan = $result_data_staf['nama_lengkap'];
$dt_subbidang_id_staf_tujuan = $result_data_staf['subbidang_id'];
$dt_jabatan_detail_staf_tujuan = $result_data_staf['jabatan_detail'];

$dt_get_data_subbidang_tujuan = mysqli_query($koneksi,"select * from `subbidang` where id_subbidang='$dt_subbidang_id_staf_tujuan'");
$result_data_subbidang_tujuan =  mysqli_fetch_assoc($dt_get_data_subbidang_tujuan);

//echo "<pre>"; print_r($result_data_staf);
//echo "<pre>"; print_r($result_data_subbidang_tujuan); die;


$array_permohonan_pengelola = [];
$array_pengajuan_kasub_bendahara = array();
$array_setuju_kasub_bendahara = array();
$array_tidak_setuju_kasub_bendahara = array();
$adp = array();

//echo "unit : ".$_GET['unit'].'<br>';
//echo "user_id : ".$_GET['user_id'].'<br>';
//echo "tgl_permintaan : ".$_GET['tgl_permintaan'].'<br><br>';
$array_ada_yg_tdk_disetujui = array();

if (isset($_GET['unit']) && isset($_GET['user_id']) && isset($_GET['tgl_permintaan'])) {
    $unit = $_GET['unit'];
    $user_id = $_GET['user_id'];
    $tgl_permintaan = $_GET['tgl_permintaan'];

    $query = mysqli_query($koneksi, "SELECT sementara.id_sementara,sementara.tgl_permintaan, 
sementara.bendahara,sementara.bendahara_id,
sementara.kode_brg,sementara.acc_kasub, nama_brg, jumlah, satuan, status,unit, sementara.status_acc,
 sementara.user_id FROM sementara
INNER JOIN stokbarang ON sementara.kode_brg = stokbarang.kode_brg
WHERE tgl_permintaan='$tgl_permintaan' AND unit='$unit' 
AND user_id='$user_id' 
AND status_acc in('Pengajuan Kasub Bendahara','Setuju Kasub Bendahara','Tidak Setuju Kasub Bendahara')");
}

//while($itm = mysqli_fetch_array($query)){
//    if($itm['status_acc']=='Tidak Setuju Kasub Bendahara'){
//        array_push($array_ada_yg_tdk_disetujui,"tidak_disetujui_kasub_bendahara");
//    }
//
//}
//
//echo "tdk setuju kasub bendahara : ".count($array_ada_yg_tdk_disetujui)."<br>";


$query_cek = mysqli_query($koneksi, "SELECT user.nama_lengkap,user.email,sementara.id_sementara,sementara.tgl_permintaan, 
sementara.bendahara,sementara.bendahara_id,
sementara.kode_brg,sementara.acc_kasub, nama_brg, jumlah, satuan, status,unit, sementara.status_acc,
 sementara.user_id FROM ((sementara
INNER JOIN stokbarang ON sementara.kode_brg = stokbarang.kode_brg) inner join user on 
sementara.bendahara_id=user.id_user)
WHERE tgl_permintaan='$tgl_permintaan' AND unit='$unit' 
AND user_id='$user_id' 
AND status_acc in('Pengajuan Kasub Bendahara','Setuju Kasub Bendahara','Tidak Setuju Kasub Bendahara')");

//Lanjutkan Disini
$query_pengecekan_bk1 = mysqli_query($koneksi, "SELECT user.nama_lengkap,user.email,sementara.id_sementara,sementara.tgl_permintaan, 
sementara.bendahara,sementara.bendahara_id,
sementara.kode_brg,sementara.acc_kasub, nama_brg, jumlah, satuan, status,unit, sementara.status_acc,
 sementara.user_id FROM ((sementara
INNER JOIN stokbarang ON sementara.kode_brg = stokbarang.kode_brg) inner join user on 
sementara.bendahara_id=user.id_user)
WHERE tgl_permintaan='$tgl_permintaan' AND unit='$unit' 
AND user_id='$user_id' 
AND status_acc in('Pengajuan Kasub Bendahara','Setuju Kasub Bendahara','Tidak Setuju Kasub Bendahara') ");

$query_pengecekan = mysqli_query($koneksi, "SELECT sementara.id_sementara,sementara.tgl_permintaan, 
sementara.bendahara,sementara.bendahara_id,
sementara.kode_brg,sementara.acc_kasub, nama_brg, jumlah, satuan, status,unit, sementara.status_acc,
 sementara.user_id FROM ((sementara
INNER JOIN stokbarang ON sementara.kode_brg = stokbarang.kode_brg) )
WHERE tgl_permintaan='$tgl_permintaan' AND unit='$unit' 
AND user_id='$user_id' 
AND status_acc in('Pengajuan Kasub Bendahara','Setuju Kasub Bendahara','Tidak Setuju Kasub Bendahara') ");


$jumlah_request = mysqli_num_rows($query_pengecekan);

//echo "jml request :" . $jumlah_request . "<br>";

while ($dt = mysqli_fetch_array($query_pengecekan)) {
    if ($dt['status_acc'] == "Pengajuan Kasub Bendahara") {
        array_push($array_pengajuan_kasub_bendahara, (object)[
            "status_sekarang" => $dt['status_acc'],
        ]);
    } else if ($dt['status_acc'] == "Setuju Kasub Bendahara") {
        array_push($array_setuju_kasub_bendahara, (object)[
            "status_sekarang" => $dt['status_acc'],
        ]);
    } else if ($dt['status_acc'] == "Tidak Setuju Kasub Bendahara") {
        array_push($array_tidak_setuju_kasub_bendahara, (object)[
            "status_sekarang" => $dt['status_acc'],
        ]);
    }
}

//echo "setuju : ".count($array_setuju_kasub_bendahara)."<br>";
//echo "tidak setuju : ".count($array_tidak_setuju_kasub_bendahara)."<br>";
$jumlah_request_setuju_dan_tidak = count($array_setuju_kasub_bendahara) + count($array_tidak_setuju_kasub_bendahara);



$query_cek_email_old = mysqli_query($koneksi, "SELECT sementara.status_acc,sementara.bendahara,user.nama_lengkap,user.email FROM ((sementara
INNER JOIN stokbarang ON sementara.kode_brg = stokbarang.kode_brg) inner join user on 
sementara.bendahara_id=user.id_user)
WHERE tgl_permintaan='$tgl_permintaan' AND unit='$unit' 
AND user_id='$user_id' 
AND status_acc not in('Pengajuan Kasub Bendahara')");



$query_cek_email = mysqli_query($koneksi, "SELECT sementara.status_acc,sementara.bendahara,
user.nama_lengkap,user.email FROM ((sementara
INNER JOIN stokbarang ON sementara.kode_brg = stokbarang.kode_brg) inner join user on 
sementara.bendahara_id=user.id_user)
WHERE tgl_permintaan='$tgl_permintaan' AND unit='$unit' 
AND user_id='$user_id' 
AND status_acc in('Pengajuan Kasub Bendahara','Setuju Kasub Bendahara','Tidak Setuju Kasub Bendahara')");

$query_cek_email_coba_baru = mysqli_query($koneksi, "SELECT sementara.status_acc,sementara.bendahara 
FROM ((sementara
INNER JOIN stokbarang ON sementara.kode_brg = stokbarang.kode_brg) )
WHERE tgl_permintaan='$tgl_permintaan' AND unit='$unit' 
AND user_id='$user_id' 
AND status_acc in('Pengajuan Kasub Bendahara','Setuju Kasub Bendahara','Tidak Setuju Kasub Bendahara')");




while ($dt_cek_email = mysqli_fetch_array($query_cek_email)) {
    if ($dt_cek_email['status_acc'] == 'Pengajuan Kasub Bendahara' || $dt_cek_email['status_acc'] == 'Setuju Kasub Bendahara' || $dt_cek_email['status_acc'] == 'Tidak Setuju Kasub Bendahara') {
        array_push($adp, (object)[
            "status_permohonan" => "Sudah Tidak Di Kasub Pengelola",
            "email_penerima" => $dt_cek_email['email'],
            "bendahara" => $dt_cek_email['bendahara'],
            "nama_lengkap" => $dt_cek_email['nama_lengkap'],
        ]);
    }
}



//echo count($adp) . " adp";
//echo $jumlah_request_setuju_dan_tidak."<br>";
//echo $jumlah_request."<br>"; die;

$get_data_email_operator = mysqli_query($koneksi,"select * from user where jabatan='Operator' 
and subbidang_id=$_SESSION[subbidang_id]");

while($data_operator_emails = mysqli_fetch_array($get_data_email_operator)){
   // echo $data_operator_emails['nama_lengkap']."<br>";
   // echo $data_operator_emails['email']."<br>";
}
// die;



if ($jumlah_request_setuju_dan_tidak == $jumlah_request) {
    //echo "<br>kirimlah email ke pengelola";


    if(count($array_tidak_setuju_kasub_bendahara)>0){
        $get_nama_pemohon = mysqli_query($koneksi,"select * from `user` where id_user=$user_id") ;
        $result_nama_pemohon = mysqli_fetch_assoc($get_nama_pemohon);

        $email_pemohon = $result_nama_pemohon['email'];
        $nama_pemohon = $result_nama_pemohon['nama_lengkap'];
        $jabatan_pemohon = $result_nama_pemohon['jabatan_detail'];
        $subbidang_id_pemohon = $result_nama_pemohon['subbidang_id'];

        $get_subbid_pemohon = mysqli_query($koneksi,"select * from subbidang 
where id_subbidang=$subbidang_id_pemohon");
        $result_subbid_pemohon = mysqli_fetch_assoc($get_subbid_pemohon);

        $subbidang_name_pemohon = $result_subbid_pemohon['nama_subbidang'];

        $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->SMTPSecure = "ssl";
        $mail->Host = "smtp.gmail.com"; //host email

        //jika '$mail->SMTPDebug = 2;' di uncomment maka akan muncul debug di browser
        //$mail->SMTPDebug = 2;
        $mail->Port = 465;
        $mail->SMTPAuth = true;
        $mail->Username = "senderforemail340@gmail.com"; //user email
        $mail->Password = "mtklbsimtazfowfi"; //password email
        $mail->SetFrom("senderforemail340@gmail.com", "Koreksi Persetujuan Kasub Pengelola"); //set email pengirim
        $mail->Subject = "Koreksi Persetujuan Kasub Pengelola"; //subyek email
        $mail->AddAddress($email_pemohon);  // email tujuan
        $mail->MsgHTML("Halo, " . $jabatan_pemohon ." ".$subbidang_name_pemohon
            . " Terdapat Koreksi Permohonan Persetujuan Pengelola dari "
            . $data_jabatan_detail_kasub_operator_pengirim." ".$data_nama_subbidang_kasub_operator_pengirim
            . ", segera cek aplikasi SIBAPER"); //pesan
        $mail->Send();

    }
    $get_data_email_operator = mysqli_query($koneksi,"select * from user where jabatan='Operator' 
and subbidang_id=$_SESSION[subbidang_id]");


    while($data_operator_emails = mysqli_fetch_array($get_data_email_operator)){


        $get_data_subbidang_operator = mysqli_query($koneksi,"select * from subbidang 
where id_subbidang='$data_operator_emails[subbidang_id]'");

        $result_data_subbidang_operator = mysqli_fetch_assoc($get_data_subbidang_operator);

//        echo $data_operator_emails['nama_lengkap']."<br>";
//        echo $data_operator_emails['email']."<br>";
//        echo $data_operator_emails['subbidang_id']."<br>";
//        echo $data_operator_emails['jabatan_detail']."<br>";
//        echo $result_data_subbidang_operator['nama_subbidang']."<br>";

        //echo "email penerima :" . $dt->email_penerima;
        //echo "nama lengkap penerima:" . $dt->nama_lengkap;

        $dt_email_tujuan = $data_operator_emails['email'];
        $dt_nama_lengkap_tujuan = $data_operator_emails['nama_lengkap'];



        $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->SMTPSecure = "ssl";
        $mail->Host = "smtp.gmail.com"; //host email

        //jika '$mail->SMTPDebug = 2;' di uncomment maka akan muncul debug di browser
        //$mail->SMTPDebug = 2;
        $mail->Port = 465;
        $mail->SMTPAuth = true;
        $mail->Username = "senderforemail340@gmail.com"; //user email
        $mail->Password = "mtklbsimtazfowfi"; //password email
        $mail->SetFrom("senderforemail340@gmail.com", "WKonfirmasi Persetujuan Kasub Pengelola"); //set email pengirim
        $mail->Subject = "Konfirmasi Persetujuan Kasub Pengelola"; //subyek email
        $mail->AddAddress($dt_email_tujuan);  // email tujuan
        $mail->MsgHTML("Halo, " . $data_operator_emails['jabatan'] ." ".$result_data_subbidang_operator['nama_subbidang']
            . " Terdapat Konfirmasi Permohonan Persetujuan Pengelola dari " . $data_jabatan_detail_kasub_operator_pengirim." ".$data_nama_subbidang_kasub_operator_pengirim . ", segera cek aplikasi SIBAPER"); //pesan
        $mail->Send();
    }

    //die;

    /*foreach ($adp as $id => $dt) {
        //echo "email penerima :" . $dt->email_penerima;
        //echo "nama lengkap penerima:" . $dt->nama_lengkap;

        $dt_email_tujuan = $dt->email_penerima;
        $dt_nama_lengkap_tujuan = $dt->nama_lengkap;

        $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->SMTPSecure = "ssl";
        $mail->Host = "smtp.gmail.com"; //host email

        //jika '$mail->SMTPDebug = 2;' di uncomment maka akan muncul debug di browser
        //$mail->SMTPDebug = 2;
        $mail->Port = 465;
        $mail->SMTPAuth = true;
        $mail->Username = "senderforemail340@gmail.com"; //user email
        $mail->Password = "mtklbsimtazfowfi"; //password email
        $mail->SetFrom("senderforemail340@gmail.com", "Konfirmasi Persetujuan Kasub Pengelola"); //set email pengirim
        $mail->Subject = "Konfirmasi Persetujuan Kasub Pengelola"; //subyek email
        $mail->AddAddress($dt_email_tujuan);  // email tujuan
        $mail->MsgHTML("Halo, " . $dt_nama_lengkap_tujuan . " Terdapat Konfirmasi Permohonan Persetujuan Pengelola dari " . $_SESSION['nama_lengkap'] . ", segera cek aplikasi SIBAPER"); //pesan
        $mail->Send();
    }*/
} else {
    //echo "<br>jangan kirim email ke pengelola dulu";

}


?>


<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <?php

                    $get_nama_pemohon = mysqli_query($koneksi,"select * from `user` where id_user='$user_id'");
                    $nama_lengkap_pemohon = mysqli_fetch_assoc($get_nama_pemohon)['nama_lengkap'];
                    ?>
                    <h3 class="text-center">Konfirmasi Permintaan <b><?php echo $nama_lengkap_pemohon; ?></b></h3><br>
                    <center>
                        <span style="font-weight: bold">
                           <?php echo tanggal_indo($tgl_permintaan) ?>
                        </span>
                    </center>
                </div>
                <div class="box-body">
                    <a href="index.php?p=datapermintaan_table&pas=permintaanbarang" style="margin:10px;"
                       class="btn btn-success"><i
                                class='fa fa-backward'> Kembali</i></a>
                    <div class="table-responsive">
                        <table class="table text-center">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Id Sementara</th>
<!--                                <th>Bendahara Brg</th>-->
                                <th class="hide">Pemohon Brg</th>
                                <th class="hide">Id Pemohon</th>
                                <th class="hide">Tgl Permintaan</th>
                                <!--                                <th>Kode Barang</th>-->
                                <th>Nama Barang</th>
                                <th>Satuan</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>


                            <tbody>
                            <tr>
                                <?php
                                $no = 1;
                                if (mysqli_num_rows($query)) {
                                while ($row = mysqli_fetch_assoc($query)):


                                if ($row['status_acc'] != null) {
                                    ?>
                                    <!--jika belum disetujui-->
                                    <td id="no"> <?= $no; ?> </td>
                                    <td id="id_sementara"> <?= $row['id_sementara']; ?> </td>

                                    <?php if ($row['bendahara'] == '' || $row['bendahara'] == null) { ?>
                                        <!--<td> Belum Ada</td>-->
                                    <?php } else { ?>
                                        <td>
                                            <?php
                                            $get_nama_bendahara = mysqli_query($koneksi, "Select nama_lengkap from `user` where id_user='$row[bendahara_id]'") ;
                                            //echo mysqli_fetch_assoc($get_nama_bendahara)['nama_lengkap'];
                                            ?>
                                        </td>
                                    <?php } ?>
                                    <td id="unit" class="hide"> <?= $row['unit']; ?> </td>
                                    <td id="user_id" class="hide"> <?= $row['user_id']; ?> </td>
                                    <td id="tgl_permintaan" class="hide"> <?= $row['tgl_permintaan']; ?> </td>
                                    <!--                                    <td> --><? //= $row['kode_brg'];
                                    ?><!-- </td>-->
                                    <td> <?= $row['nama_brg']; ?> </td>
                                    <td> <?= $row['satuan']; ?> </td>
                                    <td> <?= $row['jumlah']; ?> </td>
                                    <td> <?= $row['status_acc'] ?> </td>

                                    <td style="width: 150px" class="">

                                        <?php


                                        $_SESSION['acc_kasub_temp'] = $row['acc_kasub'];

                                        ?>


                                        <?php
                                        if ($row['status_acc'] != 'Pengajuan Kasub Bendahara') { ?>
                                            <a id="a_setujui_fake" class=""
                                               href="">
                                        <span id="span_setujui_fake" data-placement='top' data-toggle='tooltip'
                                              title='Setujui'>
                                            <button id="button_setujui_fake"
                                                    class="btn btn-success disabled">
                                                Setujui
                                            </button>

                                        </span>
                                            </a>

                                            <a id="a_tidaksetuju_fake"
                                               href="">
                                        <span id="span_tidaksetujui_fake" data-placement='top' data-toggle='tooltip'
                                              title='Tidak Setuju'>
                                            <button id="tidaksetuju_fake"
                                                    class="btn btn-danger disabled">
                                                Tidak Setuju
                                            </button>

                                        </span>
                                            </a>


                                        <?php } else if ($row['status_acc'] == 'Pengajuan Kasub Bendahara') { ?>


                                            <a style="margin-right: 2px" id="a_setujui" class=""
                                               href="setuju_table_kasub_operator.php?id_sementara=<?php echo $row['id_sementara']; ?>&user_id=<?php echo $row['user_id'] ?>&unit=<?php echo $row['unit']; ?>&tgl_permintaan=<?php echo $row['tgl_permintaan']; ?>">
                                        <span style="" id="span_setujui" data-placement='top' data-toggle='tooltip'
                                              title='Setujui'>
                                            <button id="bt_setuju"
                                                    class="btn btn-success  ">
                                                Setujuiszy
                                            </button>

                                        </span>
                                            </a>

                                            <form style="" method="post"
                                                  action="alasan_tidak_setuju_kasub_operator.php">
                                                <input class="hidden" type="text" name="unit" id="unit"
                                                       value="<?php echo $row['unit']; ?>">
                                                <input class="hidden" type="text" name="user_id" id="user_id"
                                                       value="<?php echo $row['user_id']; ?>">
                                                <input class="hidden" type="text" name="tgl_permintaan" id="tgl_permintaan"
                                                       value="<?php echo $row['tgl_permintaan']; ?>">
                                                <input class="hidden" type="text" name="id_sementara" id="id_sementara"
                                                       value="<?php echo $row['id_sementara']; ?>">
                                                <input data-toggle="tooltip" title="Tidak Setuju"
                                                       onclick="return confirm('Berikan Catatan Tidak Setuju?')"
                                                       type="submit" id="alasan_tidak_setuju_kasub_operator"
                                                       name="alasan_tidak_setuju_kasub_operator"
                                                       style="margin-left: 3px"
                                                       class="btn btn-danger col-sm-offset-3"
                                                       value="Tidak Setujus">


                                            </form>


                                            <div class="input-no-acc-<?php echo $row['id_sementara']; ?> hide col-sm-4">
                                                <input type="text" value="" placeholder="Alasan Penolakan"
                                                       class="form-control" name="kode_brg">
                                                <!--                                                <input id="bt_setuju" type="text" value="" placeholder="Alasan Penolakan" class="form-control" name="" >-->
                                            </div>
                                        <?php }
                                        ?>


                                        <?php
                                        $id_sementara = "";
                                        $tgl_permintaan = "";
                                        ?>


                                    </td>

                                <?php } ?>

                            </tr>

                            <?php $no++;

                            endwhile;
                            } else {
                                echo "<tr><td colspan=9>Tidak ada permintaan material teknik.</td></tr>";
                            } ?>
                            </tbody>
                        </table>

                        <script>
                            $(document).ready(function () {
                                $("#setujui").click(function () {
                                    document.getElementById('setujui').style.visibility = "hidden";
                                });
                            });

                            function showStuff(id, text, btn) {
                                document.getElementById(id).style.display = 'block';
                                // hide the lorem ipsum text
                                document.getElementById(text).style.display = 'none';
                                // hide the link
                                btn.style.display = 'none';
                            }

                            function klikLah(id, btn) {
                                const buttons = document.getElementById('a_setujui');
                                const sembunyi = document.getElementById('sembunyi');
                                document.getElementById(id).style.display = 'block';
                                // hide the lorem ipsum text
                                // document.getElementById(text).style.display = 'none';
                                // hide the link
                                // btn.style.display = 'none';
                                buttons.style.display = 'none';
                                sembunyi.style.visibility = "visible";
                            }
                        </script>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    function TidakSetuju() {
        let TidakSetuju = document.getElementById('TidakSetuju');
        TidakSetuju.click(function () {

            var id_sementara = $('#id_sementara').val();
            var unit = $('#unit').val();
            var user_id = $('#user_id').val();
            var tgl_permintaan = $('#tgl_permintaan').val();
            // var dataString = 'id_sementara='+id_sementara+"&unit="+unit+"&user_id="+user_id+"&tgl_permintaan="+tgl_permintaan;
            $.ajax({
                type: "POST",
                url: "get_id_sementara.php",
                data: 'id_sementara=' + id_sementara + "&unit=" + unit + "&user_id=" + user_id + "&tgl_permintaan=" + tgl_permintaan,
                success: function (html) {
                    // $("#nama_brg").html(html);
                }
            });
        });
    }

    $(document).ready(function () {


        // let bt_tidaksetuju = document.getElementById('bt_tidaksetuju');
        //
        // bt_tidaksetuju.addEventListener('click',(ev)=>{
        //     let bt_setuju = document.getElementById('bt_setuju');
        //     let HTMLString = "<input id='' type='text' value='' placeholder='Alasan Penolakan' class='form-control'>";
        //     bt_setuju.outerHTML = HTMLString;
        //     let HTMLStrings =  "<div id='content'> <b> This text is inserted by setting the element.innerHTML. At </b>" + new Date();
        // });

    });
</script>

