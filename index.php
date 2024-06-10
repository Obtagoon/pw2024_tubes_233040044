<?php
// Koneksi Ke Data Base //
session_start();

$user = $_SESSION['user'];
if (!isset($_SESSION['user'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}
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
            <div class="d-flex">
                <input class="div-control me-2" type="search" placeholder="Search" aria-label="Search" autofocus autocomplete="off" id="searchInput">
                <!-- <button class="btn btn-outline-success" type="submit" id="tombol-cari" name="cari">Search</button> -->
            </div>
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
                    <?php if ($user['role'] == 'admin') : ?>
                        <th>aksi</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody id="searchResults">

            </tbody>
        </table>
        <?php if ($user['role'] == 'admin') : ?>
            <a href="tambah.php" class="btn btn-primary mt-2 mb-2">Tambah data unit</a>
        <?php endif; ?>
    </section>


    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            var query = $(this).val(); // Using $(this) instead of $('#searchInput') for more specific targeting

            $.ajax({
                url: 'search.php',
                method: 'POST',
                data: {
                    query: query
                },
                success: function(data) {
                    $('#searchResults').html(data);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log('Error:', textStatus, errorThrown); // Optional: Log any errors for debugging
                }
            });


            $("input").on('input', function() {
                var query = $(this).val(); // Using $(this) instead of $('#searchInput') for more specific targeting

                $.ajax({
                    url: 'search.php',
                    method: 'POST',
                    data: {
                        query: query
                    },
                    success: function(data) {
                        $('#searchResults').html(data);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log('Error:', textStatus, errorThrown); // Optional: Log any errors for debugging
                    }
                });
            });
        });
    </script>

</body>

</html>