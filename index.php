<?php
// Koneksi Ke Data Base //
session_start();
require('function.php');

$motor = query("SELECT * FROM otomotive");

// tombol cari di click //
if (isset($_POST["cari"])) {
    $motor = cari($_POST["keyword"]);
}

$no = 1;

// Ambil Data { Fetch } Outomotive Dari Object Result //
// ada 4 cara 
// mysqli_fetch_row{} // mengembalikan array numerik
// mysqli_fetch_assoc{} // mengembalikan array assosiative
// mysqli_fetch_array{} // mengembalikan keduanya
// mysqli_fetch_object{ // memanggil menggunakan -> {nama}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style2.css">

</head>

<body>
    <nav class="navbar fixed-top">
        <div class="container-fluid">
            <h2 class="navbar-brand">Moto77 Garage</h2>
            <form class="d-flex" role="search" method="post">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="keyword" autofocus autocomplete="off" id="keyword">
                <button class="btn btn-outline-success" type="submit" id="tombol-cari" name="cari">Search</button>

            </form>
            <a href="logout.php" class="btn btn-danger" role="button">Log out</a>
        </div>
    </nav>



    <!-- <div class="container mt-5">
        <h2>Search</h2>
        <div class="input-group mb-3">
            <input type="text" id="searchInput" class="form-control" placeholder="Search..." name="keyword" autofocus autocomplete="off" id="keyword">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="button" id="tombol-cari" name="cari">Search</button>
            </div>
        </div>
        <div id="searchResults"></div>
    </div> -->


    <section class="tabel">
        <table class="table table-striped table-bordered border-black table-dark">
            <thead>
                <tr>
                    <th>no.</th>
                    <th>gambar</th>
                    <th>motor</th>
                    <th>tipemotor</th>
                    <th>harga</th>
                    <th>deskripsi</th>
                    <th>aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($motor as $mtr) : ?>
                    <tr>
                        <th scope="row"><?php echo $no++; ?></th>
                        <td><img src="img/<?= $mtr['gambar'] ?>" width="70"></td>
                        <td><?= $mtr['motor'] ?></td>
                        <td><?= $mtr['tipemotor'] ?></td>
                        <td><?= $mtr['harga'] ?></td>
                        <td><?= $mtr['deskripsi'] ?></td>
                        <td>
                            <a href="ubah.php?id=<?= $mtr['id']; ?>">Ubah</a> |
                            <form action="hapus.php" method="post" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                <input type="hidden" name="id" value="<?= $mtr['id']; ?>">
                                <button type="submit">hapus</button>
                            </form>

                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="tambah.php" class="btn btn-primary mt-2 mb-2">Tambah data unit</a>
    </section>


    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#searchButton').click(function() {
                var query = $('#searchInput').val();

                $.ajax({
                    url: 'search.php',
                    method: 'POST',
                    data: {
                        query: query
                    },
                    success: function(data) {
                        $('#searchResults').html(data);
                    }
                });
            });
        });
    </script>

</body>

</html>