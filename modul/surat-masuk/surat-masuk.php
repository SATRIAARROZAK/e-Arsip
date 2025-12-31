<?php

    //uji jika tombol simpan diklik
    if(isset($_POST['bsimpan']))
    {

        //pengujian apakah data akan diedit / simoan baru
        if(@$_GET['hal'] == "edit"){
            //perintah edit data
            //ubah data
            $ubah = mysqli_query($koneksi, "UPDATE tbl_pengirim_surat SET 
                                            nama_pengirim = '$_POST[nama_pengirim]',
                                            alamat = '$_POST[alamat]',
                                            no_hp = '$_POST[no_hp]',
                                            email = '$_POST[email]' 
                                            where id_pengirim_surat = '$_GET[id]'");
            if($ubah)
            {
                echo "<script>
                        alert('Ubah Data Sukses');
                        document.location='?halaman=surat-masuk';
                    </script>";
            }
            else
            {
                echo "<script>
                        alert('Ubah Data Gagal!!');
                        document.location='?halaman=surat-masuk';
                    </script>";
            }            
        }
        else
        {
            //perintah simpan data baru
            //simpandata
            $simpan = mysqli_query($koneksi, "INSERT INTO tbl_pengirim_surat VALUES ('', 
                                '$_POST[nama_pengirim]',
                                '$_POST[alamat]',
                                '$_POST[no_hp]',
                                '$_POST[email]'
                                ) ");
            if($simpan)
            {
                echo "<script>
                        alert('Simpan Data Sukses');
                        document.location='?halaman=surat-masuk';
                    </script>";
            }else
            {
                echo "<script>
                alert('Simpan Data Gagal!!');
                document.location='?halaman=surat-masuk';
            </script>";
            }
        }


        
    }

    //Uji Jika Klik tombol edit / hapus
    if(isset($_GET['hal']))
    {

        if($_GET['hal'] == "edit")
        {

            //tampilkan daya yang akan diedit
            $tampil = mysqli_query($koneksi, "SELECT * FROM tbl_pengirim_surat where id_pengirim_surat='$_GET[id]'");
            $data = mysqli_fetch_array($tampil);
            if($data)
            {
                //jika data ditemukan, maka data ditampung ke dalam variabel
                $vnama_pengirim = $data['nama_pengirim'];
                $valamat = $data['alamat'];
                $vno_hp = $data['no_hp'];
                $vemail = $data['email'];
            }

        }else{

            $hapus = mysqli_query($koneksi, "DELETE FROM tbl_pengirim_surat WHERE id_pengirim_surat='$_GET[id]'");
            if($hapus){
                echo "<script>
                        alert('Hapus Data Sukses');
                        document.location='?halaman=surat-masuk';
                    </script>";
            }

        }

        

    }

?>


<div class="card mt-3">
  <div class="card-header" style="background-color: #f0c001;">
    Form Data Pengirim Surat
  </div>
  <div class="card-body">
  <form method="post" action="">
    <div class="form-group">
        <label for="nama_pengirim">Nama Pengirim</label>
        <input type="text" class="form-control" id="nama_pengirim" name="nama_pengirim" value="<?=@$vnama_pengirim?>">
    </div>
    <div class="form-group">
        <label for="alamat">Alamat</label>
        <input type="text" class="form-control" id="alamat" name="alamat" value="<?=@$valamat?>">
    </div>
    <div class="form-group">
        <label for="no_hp">No. HP</label>
        <input type="text" class="form-control" id="no_hp" name="no_hp" value="<?=@$vno_hp?>">
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" value="<?=@$vemail?>">
    </div>

    <button type="submit" name="bsimpan" class="btn btn-success">Simpan</button>
    <button type="reset" name="bbatal" class="btn btn-danger">batal</button>
    </form>
  </div>
</div>

<div class="card mt-3">
  <div class="card-header" style="background-color: #f7d914;">
    Data Pengirim Surat
  </div>
  <div class="card-body">
  <table class="table table-borderd table-hovered table-striped">
    <tr>
        <th>No</th>
        <th>Nama Pengirim Surat</th>
        <th>Alamat</th>
        <th>No HP</th>
        <th>Email</th>
        <th>Aksi</th>
    </tr>
    <?php
        $tampil = mysqli_query($koneksi, "SELECT * from tbl_pengirim_surat order by id_pengirim_surat desc");
        $no = 1;
        while($data = mysqli_fetch_array($tampil)) :

    ?>
    <tr>
        <td><?=$no++?></td>
        <td><?=$data['nama_pengirim']?></td>
        <td><?=$data['alamat']?></td>
        <td><?=$data['no_hp']?></td>
        <td><?=$data['email']?></td>
        <td>
            <a href="?halaman=surat-masuk&hal=edit&id=<?=$data['id_pengirim_surat']?>"class="btn btn-success">Edit</a>
            <a href="?halaman=surat-masuk&hal=hapus&id=<?=$data['id_pengirim_surat']?>"class="btn btn-danger" onclick="return confirm('Apakah yakin ingin menghapus data ini?')">Hapus</a>
        </td>
    </tr>
  <?php endwhile; ?>
  </table>
  </div>
</div>