<?php
require 'function.php';

// Check if 'id' is set in $_POST and validate it
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
    echo "ID to delete: " . $id . "<br>";  // Debugging line

    // Call the hapus function
    if (hapus($id) > 0) {
        echo "<script>
                    alert('Data berhasil dihapus!');
                    document.location.href = 'index.php';
              </script>";
    } else {
        echo "<script>
                    alert('Data gagal dihapus!');
                    document.location.href = 'index.php';
              </script>";
    }
} else {
    echo "<script>
                alert('ID tidak valid!');
                document.location.href = 'index.php';
          </script>";
}
