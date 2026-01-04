<div class="card mt-3">
  <div class="card-header" style="background-color: #f0c001;">
    Data Arsip Surat
  </div>
  <div class="card-body">
    <a href="?halaman=arsip&hal=tambahdata" class="btn btn-info mb-3">Tambah Data</a>
  <table class="table table-bordered table-hover table-striped">
    <tr>
        <th>No</th>
        <th>No Surat</th>
        <th>Tanggal Surat</th>
        <th>Tanggal Diterima</th>
        <th>Perihal</th>
        <th>Departemen / Tujuan</th>
        <th>Pengirim</th>
        <th>File</th>
        <th>Aksi</th>
    </tr>
    <?php
        $tampil = mysqli_query($koneksi, "SELECT 
                    tbl_arsip.*,
                    tbl_departemen.nama_departemen,
                    tbl_pengirim_surat.nama_pengirim, tbl_pengirim_surat.no_hp
                  FROM tbl_arsip
                  LEFT JOIN tbl_departemen ON tbl_arsip.id_departemen = tbl_departemen.id_departemen
                  LEFT JOIN tbl_pengirim_surat ON tbl_arsip.id_pengirim = tbl_pengirim_surat.id_pengirim_surat
                  ORDER BY tbl_arsip.id_arsip DESC"); // Order by biar data baru di atas
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
        <td><?=$data['nama_pengirim']?> <br> <small>(<?=$data['no_hp']?>)</small></td>
        <td class="text-center">
            <?php
                // Cek apakah file ada dan filenya benar-benar ada di folder
                if(empty($data['file'])){
                    echo "<span class='badge badge-secondary'>-</span>";
                } else {
            ?>
                <a href="file/<?=$data['file']?>" target="_blank" class="btn btn-sm btn-primary">
                    📄 Lihat
                </a>        
            <?php
                }
            ?>
        </td>
        <td>
            <a href="?halaman=arsip&hal=edit&id=<?=$data['id_arsip']?>" class="btn btn-success btn-sm">Edit</a>
            <a href="?halaman=arsip&hal=hapus&id=<?=$data['id_arsip']?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah yakin ingin menghapus data ini?')">Hapus</a>
        </td>
    </tr>
  <?php endwhile; ?>
  </table>
  </div>
</div>