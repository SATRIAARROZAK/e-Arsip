<?php
    // --- LOGIKA SIMPAN / EDIT DATA ---
    if(isset($_POST['bsimpan']))
    {
        // 1. Amankan Input (Cegah error karena tanda kutip)
        $nama_departemen = mysqli_real_escape_string($koneksi, $_POST['nama_departemen']);

        // Cek apakah Edit atau Simpan Baru
        if(isset($_GET['hal']) && $_GET['hal'] == "edit")
        {
            // --- LOGIKA EDIT ---
            $ubah = mysqli_query($koneksi, "UPDATE tbl_departemen SET 
                                            nama_departemen = '$nama_departemen' 
                                            WHERE id_departemen = '$_GET[id]'");
            if($ubah){
                echo "<script>alert('Ubah Data Sukses'); document.location='?halaman=instansi';</script>";
            } else {
                echo "<script>alert('Ubah Gagal: ".mysqli_error($koneksi)."');</script>";
            }            
        }
        else
        {
            // --- LOGIKA SIMPAN BARU ---
            // Gunakan nama kolom spesifik!
            $simpan = mysqli_query($koneksi, "INSERT INTO tbl_departemen (nama_departemen) 
                                              VALUES ('$nama_departemen') ");
            if($simpan){
                echo "<script>alert('Simpan Data Sukses'); document.location='?halaman=instansi';</script>";
            } else {
                echo "<script>alert('Simpan Gagal: ".mysqli_error($koneksi)."');</script>";
            }
        }
    }

    // --- LOGIKA PROSES DATA (EDIT/HAPUS) ---
    // Variabel default agar tidak error 'Undefined variable'
    $vnama_departemen = "";

    if(isset($_GET['hal']))
    {
        if($_GET['hal'] == "edit")
        {
            // Tampilkan data yang akan diedit
            $tampil = mysqli_query($koneksi, "SELECT * FROM tbl_departemen WHERE id_departemen='$_GET[id]'");
            $data = mysqli_fetch_array($tampil);
            if($data){
                $vnama_departemen = $data['nama_departemen'];
            }
        }
        elseif($_GET['hal'] == "hapus") // PENTING: Pakai elseif agar lebih aman
        {
            $hapus = mysqli_query($koneksi, "DELETE FROM tbl_departemen WHERE id_departemen='$_GET[id]'");
            if($hapus){
                echo "<script>alert('Hapus Data Sukses'); document.location='?halaman=instansi';</script>";
            } else {
                echo "<script>alert('Hapus Gagal: ".mysqli_error($koneksi)."');</script>";
            }
        }
    }
?>

<div class="card mt-3">
  <div class="card-header" style="background-color: #f0c001;">
    Form Data Instansi
  </div>
  <div class="card-body">
  <form method="post" action="">
    <div class="form-group">
        <label for="nama_departemen">Nama Instansi</label>
        <input type="text" class="form-control" id="nama_departemen" name="nama_departemen" value="<?=$vnama_departemen?>" required>
    </div>
    <button type="submit" name="bsimpan" class="btn btn-success">Simpan</button>
    <a href="?halaman=instansi" class="btn btn-danger">Batal</a>
    </form>
  </div>
</div>

<div class="card mt-3">
  <div class="card-header" style="background-color: #f7d914;">
    Data Instansi
  </div>
  <div class="card-body">
  <table class="table table-bordered table-hover table-striped">
    <tr>
        <th>No</th>
        <th>Nama Instansi</th>
        <th>Aksi</th>
    </tr>
    <?php
        $tampil = mysqli_query($koneksi, "SELECT * FROM tbl_departemen ORDER BY id_departemen DESC");
        $no = 1;
        while($data = mysqli_fetch_array($tampil)) :
    ?>
    <tr>
        <td><?=$no++?></td>
        <td><?=$data['nama_departemen']?></td>
        <td>
            <a href="?halaman=instansi&hal=edit&id=<?=$data['id_departemen']?>" class="btn btn-success">Edit</a>
            <a href="?halaman=instansi&hal=hapus&id=<?=$data['id_departemen']?>" class="btn btn-danger" onclick="return confirm('Apakah yakin ingin menghapus data ini?')">Hapus</a>
        </td>
    </tr>
  <?php endwhile; ?>
  </table>
  </div>
</div>