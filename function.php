<?php
function koneksi()
{
    $conn = mysqli_connect("localhost", "root", "", "pw2024_tubes_233040044");
    return $conn;
}

// function tambah($data)
// {
//     $conn = koneksi();

//     // Sanitize input data
//     $gambar = htmlspecialchars($data['gambar']);
//     $motor = htmlspecialchars($data['motor']);
//     $tipemotor = htmlspecialchars($data['tipemotor']);
//     $harga = htmlspecialchars($data['harga']);
//     $deskripsi = htmlspecialchars($data['deskripsi']);

//     // Insert query excluding the 'id' field
//     $query = "INSERT INTO otomotive (gambar, motor, tipemotor, harga, deskripsi)
//               VALUES ('$gambar', '$motor', '$tipemotor', '$harga', '$deskripsi')";

//     // Execute the query
//     mysqli_query($conn, $query) or die(mysqli_error($conn));

//     // Return the number of affected rows
//     return mysqli_affected_rows($conn);
// }

function tambah($data)
{
    $conn = koneksi();

    // Retrieve and sanitize other form data
    $motor = htmlspecialchars($data['motor']);
    $tipemotor = htmlspecialchars($data['tipemotor']);
    $harga = htmlspecialchars($data['harga']);
    $deskripsi = htmlspecialchars($data['deskripsi']);

    // Handle file upload
    $gambar = $_FILES['gambar']['name'];
    $tmp_name = $_FILES['gambar']['tmp_name'];
    $error = $_FILES['gambar']['error'];
    $folder = 'img/';

    // Check if the file was uploaded without errors
    if ($error === UPLOAD_ERR_OK) {
        // Generate a unique name for the file
        $unique_name = uniqid() . '_' . $gambar;
        $destination = $folder . $unique_name;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($tmp_name, $destination)) {
            // File successfully uploaded and moved to destination

            // Construct the SQL query excluding the 'id' field
            $query = "INSERT INTO otomotive (gambar, motor, tipemotor, harga, deskripsi)
                      VALUES ('$unique_name', '$motor', '$tipemotor', '$harga', '$deskripsi')";

            // Execute the query
            mysqli_query($conn, $query) or die(mysqli_error($conn));

            // Return the number of affected rows
            return mysqli_affected_rows($conn);
        } else {
            // Error moving the file
            return 0;
        }
    } else {
        // Error with file upload
        return 0;
    }
}


function hapus($id)
{
    $conn = koneksi();

    // Sanitize the id before using it in the query
    $id = intval($id);

    // Ensure id is greater than zero
    if ($id > 0) {
        $query = "DELETE FROM otomotive WHERE id = $id";
        $result = mysqli_query($conn, $query);

        if ($result) {
            return mysqli_affected_rows($conn);
        } else {
            die("Query Error: " . mysqli_error($conn));
        }
    } else {
        return 0; // Invalid ID
    }
}


function query($query)
{
    $conn = koneksi();

    $result = mysqli_query($conn, $query);

    $rows = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}

function loginfungsion($data)
{
    global $conn;

    $username = htmlspecialchars($data["username"]);
    $password = htmlspecialchars($data["password"]);
    // cek dulu username nya // 
    $user = query("SELECT * FROM user WHERE username = '$username'");

    if (count($user) > 0) {

        if (password_verify($password, $user[0]['password'])) {

            $_SESSION['login'] = true;
            $_SESSION['user'] = $user[0];
            header("Location: index.php");


            exit;
        }
    }

    return [
        'error' => true,
        'pesan' => 'Username/ Password Salah'
    ];
}

function registrasi($data)
{
    $conn = koneksi();

    $username = htmlspecialchars(strtolower($data['username']));
    $password1 = mysqli_real_escape_string($conn, $data['password1']);
    $password2 = mysqli_real_escape_string($conn, $data['password2']);

    if (empty($username) || empty($password1) || empty($password2)) {
        echo "<script>
                alert('username /password tidak boleh kosong!')
                document.location.href = 'register.php'
            </script>";
        return false;
    }

    // jika username sudah ad

    if (query("SELECT * FROM user WHERE username = '$username'")) {
        echo "<script>
                alert('username sudah terdaftar')
                document.location.href = 'register.php'
            </script>";
        return false;
    }

    if ($password1 !== $password2) {
        echo "<script>
                alert('konfirmasi password tidak sesuai')
                document.location.href = 'register.php'
            </script>";
        return false;
    }

    // jika password < 5
    if (strlen($password1) < 5) {
        echo "<script>
                alert('password terlalu pendek')
                document.location.href = 'register.php'
            </script>";
        return false;
    }

    // jika username & password sudah sesuai
    $password_baru = password_hash($password1, PASSWORD_DEFAULT);
    // insert ke tabel user
    $query = "INSERT INTO user VALUES
            (null, '$username', '$password_baru')";
    mysqli_query($conn, $query) or die(mysqli_error($conn));
    return mysqli_affected_rows($conn);
}

// Cari //

function cari($keyword)
{
    $query = "SELECT * FROM otomotive WHERE
motor Like '%$keyword%' OR
tipemotor Like '%$keyword%' OR
 harga Like '%$keyword%' OR 
 deskripsi Like '%$keyword%'  
 
 ";
    return query($query);
}
