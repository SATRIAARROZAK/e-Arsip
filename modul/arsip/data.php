<div class="card mt-3">
  <div class="card-header" style="background-color: #f0c001;">
    Data Arsip Surat
  </div>
  <div class="card-body">
    <a href="?halaman=arsip&hal=tambahdata" class="btn btn-info mb-3">Tambah Data</a>
  <table class="table table-borderd table-hovered table-striped">
    <tr>
        <th>No</th>
        <th>No Surat</th>
        <th>Tanggal Surat</th>
        <th>Tanggal Direrima</th>
        <th>Perihal</th>
        <th>Departemen / Tujuan</th>
        <th>Pengirim</th>
        <th>File</th>
        <th>Perihal</th>
    </tr>
    <?php
        $tampil = mysqli_query($koneksi, "SELECT 
                    tbl_arsip.*,
                    tbl_departemen.nama_departemen,
                    tbl_pengirim_surat.nama_pengirim, tbl_pengirim_surat.no_hp
                  FROM
                    tbl_arsip, tbl_departemen, tbl_pengirim_surat
                  WHERE
                    tbl_arsip.id_departemen = tbl_departemen.id_departemen
                    and tbl_arsip.id_pengirim = tbl_pengirim_surat.id_pengirim_surat
                  ");
        $no = 1;
        while($data = mysqli_fetch_array($tampil)) :

    ?>
    <tr>
        <td><?=$no++?></td>
        <td><?=$data['no_surat']?></td>
        <td><?=$data['tanggal_surat']?></td>
        <td><?=$data['tanggal_diterima']?></td>
        <td><?=$data['perihal']?></td>
        <td><?=$data['nama_departemen']?></td>
        <td><?=$data['nama_pengirim']?> / <?=$data['no_hp']?></td>
        <td>
            <?php
                //uji apakah file nya ada atau tidak
                if(empty($data['file'])){
                    echo " _ ";
                }else{
            ?>
                <a href="file/<?=$data['file']?>" target="$_blank"> lihat file </a>        
            <?php
                }
            ?>
        </td>
        <td>
            <a href="?halaman=arsip&hal=edit&id=<?=$data['id_arsip']?>"class="btn btn-success">Edit</a>
            <a href="?halaman=arsip&hal=hapus&id=<?=$data['id_arsip']?>"class="btn btn-danger" onclick="return confirm('Apakah yakin ingin menghapus data ini?')">Hapus</a>
        </td>
    </tr>
  <?php endwhile; ?>
  </table>
  </div>
</div>