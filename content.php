<?php
    if(isset($_GET['halaman']))
    {
        $hal = $_GET['halaman'];
        if($hal == "instansi"){ include "modul/instansi/instansi.php"; }
        else if($hal == "surat-masuk"){ include "modul/surat-masuk/surat-masuk.php"; }
        else if($hal == "arsip"){ 
              //tampilkan halaman arsip surat
        if(@$_GET['hal'] == "tambahdata" || @$_GET['hal'] == "edit" || @$_GET['hal'] == "hapus"){
            include "modul/arsip/form.php";
        }else{
            include "modul/arsip/data.php";
        }
          
        }
        else if($hal == "user"){ include "modul/user/user.php"; }
    }
    else
    {
        // Jika tidak ada parameter halaman (Home Dashboard)
        if(@$_SESSION['level'] == 'admin'){
            include "modul/home.php"; // Dashboard Admin Biasa
        } elseif(@$_SESSION['level'] == 'direktur'){
            include "modul/home_direktur.php"; // Dashboard Khusus Direktur
        }
    }
?>
