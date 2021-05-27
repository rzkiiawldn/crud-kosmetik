<?php 
include "function.php";

$produk = $conn->query("SELECT * FROM produk ORDER BY id_produk ASC");
$num = mysqli_num_rows($produk);

/*====================== TAMBAH =====================*/
if (isset($_POST["tambahproduk"])) {

//cek apakah data berhasil ditambahkan
if( tambahproduk($_POST) > 0 ) {
  echo "<script> 
    alert('data berhasil ditambahkan');
    document.location.href = 'index.php' ;
    </script>";

} else
  echo "<script> 
    alert('data gagal ditambahkan');
    document.location.href = 'index.php' ;
    </script>";
}

$query = mysqli_query($conn, "SELECT max(kode_produk) as kodeTerbesar FROM produk");
$data = mysqli_fetch_array($query);
$kodeProduk = $data['kodeTerbesar'];
$urutan = (int) substr($kodeProduk, 3);
$urutan++;
$kodeProduk = sprintf("%05s", $urutan);


/* ====================== EDIT ============================*/
if (isset($_POST["editproduk"])) {

//cek apakah produk berhasil diubah
if( editproduk($_POST) > 0 ) {
  echo "<script> 
    alert('produk berhasil diubah');
    document.location.href = 'index.php' ;
    </script>";
} else
  echo "<script> 
    alert('produk gagal diubah');
    document.location.href = 'index.php' ;
    </script>";
}

?>



<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <title>YourSkinCare!</title>
  </head>
  <body background="img/kosmetik2.jpg" style="background-repeat: no-repeat;background-size: cover;background-position: center;background-attachment: fixed;height: 100%">
    <!-- Nav -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-3">
        <div class="container"> 
          <a class="navbar-brand" href="#">YourSkinCare</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav ml-auto">
              <a class="nav-link active" href="#">Home</a>
            </div>
          </div>
        </div>
    </nav>
    <!-- Main -->
    <main>
        <div class="container mt-4" style="background-color : #f8eded;border-radius: 14px">
            <nav aria-label="breadcrumb mt-2" style="padding-top: 20px">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Skin Care</li>
              </ol>
            </nav>
            <h3>SkinCare</h3>
            <a href="" class="btn btn-success mb-3" data-toggle="modal" data-target="#tambah">Tambah SkinCare</a>
            <p>Total Produk : <?= $num; ?></p>
            <div class="table-responsive">
            <table class="table table-hover table-striped table-bordered">
              <thead>
                <tr>
                  <th scope="col" width="5%">#</th>
                  <th scope="col">Produk</th>
                  <th scope="col">Stok</th>
                  <th scope="col" width="12%">Kode Barang</th>
                  <th scope="col">Harga Satuan</th>
                  <!-- <th scope="col">Foto</th> -->
                  <th scope="col" width="12%">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php if($num == 0) : ?>
                <tr>
                    <td colspan="6" class="text-center">Produk Kosong !</td>
                </tr>
                <?php else: ?>
                <?php $no = 1; foreach ($produk as $row) : ?>
                <tr>
                  <th scope="row"><?= $no++; ?></th>
                  <td><?= $row['nama_produk']; ?></td>
                  <td><?= $row['stok_produk']; ?> Pcs</td>
                  <td><?= $row['kode_produk']; ?></td>
                  <td>Rp. <?= number_format($row['harga_satuan'],0,',','.'); ?></td>
                  <td>
                      <a href="" class="btn btn-sm btn-success" data-toggle="modal" data-target="#edit<?= $row['id_produk']; ?>">edit</a>
                      <a href="hapusproduk.php?id_produk=<?= $row["id_produk"]; ?>" onclick="return confirm('yakin?');" class="btn btn-sm btn-danger">hapus</a>
                  </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        </div>
        </div>
    </main>
    <p style="margin-bottom: 100px"></p>
    <footer class="fixed-bottom" style="background-color: #f8eded">
        <p class="text-center mt-2">&copy; YourSkinCare <?= date('Y'); ?></p>
    </footer>

    <!-- Modal -->
    <div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="tambahLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="tambahLabel">Tambah Produk</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
            <form action="" method="post" enctype="multipart/form-data">
              <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="kode_produk">Kode Produk</label>
                        <input type="text" class="form-control" id="kode_produk" readonly="" name="kode_produk" value="<?= $kodeProduk; ?>" required="">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="nama_produk">Nama Produk</label>
                        <input type="text" class="form-control" id="nama_produk" name="nama_produk" required="">
                      </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="stok_produk">Stok</label>
                        <input type="number" class="form-control" id="stok_produk" name="stok_produk" required="">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="harga_satuan">Harga Satuan</label>
                        <input type="number" class="form-control" id="harga_satuan" name="harga_satuan" required="">
                      </div>
                    </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="tambahproduk">Simpan</button>
              </div>
          </form>
        </div>
      </div>
    </div>


     <!-- EDIT Modal -->
     <?php foreach($produk as $row): ?>
    <div class="modal fade" id="edit<?= $row['id_produk']; ?>" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editLabel">Tambah Produk</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
            <form action="" method="post" enctype="multipart/form-data">
              <div class="modal-body">
                <input type="hidden" name="id_produk" value="<?= $row['id_produk']; ?>">
                <input type="hidden" name="foto_lama" value="<?= $row["foto_produk"]; ?>">
                <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="kode_produk">Kode Produk</label>
                        <input type="text" class="form-control" id="kode_produk" readonly="" name="kode_produk" value="<?= $row['kode_produk']; ?>" required="">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="nama_produk">Nama Produk</label>
                        <input type="text" class="form-control" id="nama_produk" name="nama_produk" value="<?= $row['nama_produk']; ?>" required="">
                      </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="stok_produk">Stok</label>
                        <input type="number" class="form-control" id="stok_produk" name="stok_produk" value="<?= $row['stok_produk']; ?>" required="">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="harga_satuan">Harga Satuan</label>
                        <input type="number" class="form-control" id="harga_satuan" name="harga_satuan" value="<?= $row['harga_satuan']; ?>" required="">
                      </div>
                    </div>
                </div>
               <!--  <div class="form-group row no-gutters mt-2">
                    <label class="col-sm-3 col-form-label" for="foto_produk">Foto Produk</label>
                    <div class="col-sm-9">
                        <div class="row">
                            <div class="col-sm-3">
                                <img src="img/<?= $row['foto_produk']; ?>" class="img-thumbnail">
                            </div>
                            <div class="col-sm-9">
                                <div class="custom-file">
                                    <input type="file" name="foto_produk" class="custom-file-input">
                                    <label class="custom-file-label" for="custom-file">Choose file</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="editproduk">Simpan</button>
              </div>
          </form>
        </div>
      </div>
    </div>
    <?php endforeach; ?>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    <!-- Script untuk menampilkan nama file dalam edit foto -->
    <script>
      $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
      });
      window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function() {
          $(this).remove();
        });
      }, 5000);
    </script>
  </body>
</html>