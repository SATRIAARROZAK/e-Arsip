<?php

    @$halaman = $_GET["halaman"];

    if($halaman == "instansi")
    {
        //tampilkan halaman departemen
        //echo "Tampil Halaman Moful Departemen";
        include "modul/instansi/instansi.php";

    }
    elseif ($halaman == "surat-masuk"){
        //tampilkan halaman pengirim surat
        include "modul/surat-masuk/surat-masuk.php";
    }
    elseif($halaman == "arsip")
    {
        //tampilkan halaman arsip surat
        if(@$_GET['hal'] == "tambahdata" || @$_GET['hal'] == "edit" || @$_GET['hal'] == "hapus"){
            include "modul/arsip/form.php";
        }else{
            include "modul/arsip/data.php";
        }
    }
    elseif($halaman == "user")
    {
        //tampilkan halaman user
        include "modul/user/user.php";
    }
    else
    {
        //echo "Tampil Halaman Home";
        include "modul/home.php";
    }


?>