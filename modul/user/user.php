<?php
    // Cek Akses: Hanya Admin yang boleh akses halaman ini
    // Pastikan session level sudah diset saat login (nanti kita bahas di menu)
    if(empty($_SESSION['level']) || $_SESSION['level'] != 'admin'){
       echo "<script>alert('Maaf, Anda tidak memiliki akses ke halaman ini!'); document.location='index.php';</script>";
       exit;
    }

    // --- LOGIKA SIMPAN / EDIT ---
    if(isset($_POST['bsimpan']))
    {
        $username     = mysqli_real_escape_string($koneksi, $_POST['username']);
        $nama_lengkap = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
        $level        = mysqli_real_escape_string($koneksi, $_POST['level']);
        
        // Logika Password (MD5)
        $password_sql = ""; 
        if(!empty($_POST['password'])){
            $password_enc = md5($_POST['password']); 
            $password_sql = ", password = '$password_enc'"; // String update password
        }

        if($_GET['hal'] == "edit")
        {
            // QUERY UPDATE
            // Jika password kosong, tidak ikut diupdate
            $query = "UPDATE tbl_user SET 
                      username = '$username',
                      nama_lengkap = '$nama_lengkap',
                      level = '$level'
                      $password_sql
                      WHERE id_user = '$_GET[id]'";
            
            $ubah = mysqli_query($koneksi, $query);
            if($ubah){
                echo "<script>alert('Ubah User Sukses'); document.location='?halaman=user';</script>";
            } else {
                echo "<script>alert('Ubah Gagal: ".mysqli_error($koneksi)."');</script>";
            }            
        }
        else
        {
            // QUERY INSERT (Wajib isi password untuk user baru)
            if(empty($_POST['password'])){
                echo "<script>alert('Password wajib diisi untuk user baru!');</script>";
            } else {
                $password_enc = md5($_POST['password']);
                $simpan = mysqli_query($koneksi, "INSERT INTO tbl_user (username, password, nama_lengkap, level) 
                                                  VALUES ('$username', '$password_enc', '$nama_lengkap', '$level')");
                if($simpan){
                    echo "<script>alert('Simpan User Sukses'); document.location='?halaman=user';</script>";
                } else {
                    echo "<script>alert('Simpan Gagal: ".mysqli_error($koneksi)."');</script>";
                }
            }
        }
    }

    // --- LOGIKA HAPUS ---
    if(isset($_GET['hal']) && $_GET['hal'] == "hapus"){
        $hapus = mysqli_query($koneksi, "DELETE FROM tbl_user WHERE id_user='$_GET[id]'");
        if($hapus){
            echo "<script>alert('Hapus User Sukses'); document.location='?halaman=user';</script>";
        }
    }

    // --- PERSIAPAN EDIT ---
    $vusername = ""; $vnama = ""; $vlevel = "";
    if(isset($_GET['hal']) && $_GET['hal'] == "edit"){
        $tampil = mysqli_query($koneksi, "SELECT * FROM tbl_user WHERE id_user='$_GET[id]'");
        $data = mysqli_fetch_array($tampil);
        if($data){
            $vusername = $data['username'];
            $vnama = $data['nama_lengkap'];
            $vlevel = $data['level'];
        }
    }
?>

<div class="card mt-3">
  <div class="card-header bg-primary text-white">
    Form Manajemen User
  </div>
  <div class="card-body">
    <form method="post" action="">
        <div class="form-group">
            <label>Username</label>
            <input type="text" class="form-control" name="username" value="<?=$vusername?>" required>
        </div>
        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" class="form-control" name="nama_lengkap" value="<?=$vnama?>" required>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" class="form-control" name="password" placeholder="Kosongkan jika tidak ingin mengganti password">
            <?php if(!isset($_GET['hal'])): ?>
                <small class="text-danger">* Wajib diisi untuk user baru</small>
            <?php endif; ?>
        </div>
        <div class="form-group">
            <label>Level User</label>
            <select class="form-control" name="level">
                <option value="<?=$vlevel?>"><?=$vlevel?></option>
                <option value="admin">Admin</option>
                <option value="direktur">Direktur</option>
            </select>
        </div>

        <button type="submit" name="bsimpan" class="btn btn-success">Simpan</button>
        <a href="?halaman=user" class="btn btn-danger">Batal</a>
    </form>
  </div>
</div>

<div class="card mt-3">
  <div class="card-header bg-info text-white">
    Data User Pengguna
  </div>
  <div class="card-body">
    <table class="table table-bordered table-striped">
        <tr>
            <th>No</th>
            <th>Username</th>
            <th>Nama Lengkap</th>
            <th>Level</th>
            <th>Aksi</th>
        </tr>
        <?php
            $tampil = mysqli_query($koneksi, "SELECT * FROM tbl_user ORDER BY id_user DESC");
            $no = 1;
            while($data = mysqli_fetch_array($tampil)) :
        ?>
        <tr>
            <td><?=$no++?></td>
            <td><?=$data['username']?></td>
            <td><?=$data['nama_lengkap']?></td>
            <td>
                <?php 
                    if($data['level']=='admin'){
                        echo "<span class='badge badge-success'>Admin</span>";
                    } else {
                        echo "<span class='badge badge-warning'>Direktur</span>";
                    }
                ?>
            </td>
            <td>
                <a href="?halaman=user&hal=edit&id=<?=$data['id_user']?>" class="btn btn-sm btn-warning">Edit</a>
                <a href="?halaman=user&hal=hapus&id=<?=$data['id_user']?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus User ini?')">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
  </div>
</div>