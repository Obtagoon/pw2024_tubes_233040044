<?php
require 'function.php';

// Check if 'id' is set in $_POST and validate it
if (isset($_POST['id']) && is_numeric($_POST['id'])) {
    $id = intval($_POST['id']);
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
