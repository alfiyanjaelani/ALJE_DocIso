<?php
require('top.inc.php');
date_default_timezone_set('Asia/Jakarta');
isAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['berkas'])) {
    // Ambil file yang di-upload
    $file = $_FILES["berkas"];
    

    if ($file['error'] === UPLOAD_ERR_OK) {
    
   

      // Validasi apakah file adalah gambar atau PDF
      $imageInfo = getimagesize($file["tmp_name"]);
      if ($imageInfo !== false || $file['type'] == 'application/pdf') {
          // File adalah gambar atau PDF
          $name = $file["name"];
          $type = $file["type"]; // MIME type (e.g., image/jpeg, application/pdf)
          $blob = addslashes(file_get_contents($file["tmp_name"])); // Membaca file sebagai binary data
          $id_department = isset($_POST['id_department']) ? $_POST['id_department'] : null;
          $upload_by = isset($_SESSION['ADMIN_USERNAME']) ? $_SESSION['ADMIN_USERNAME'] : ''; // Nama pengunggah
          $size = $file['size']; // Ukuran file
          $uploaded_date = date('Y-m-d H:i:s'); // Tanggal dan waktu saat ini
          $update_by = isset($_SESSION['ADMIN_USERNAME']) ? $_SESSION['ADMIN_USERNAME'] : ''; // Nama pengunggah
          $update_date = date('Y-m-d H:i:s');

          // Cek apakah ID ada (untuk menentukan edit atau create)
          $id = isset($_POST['id']) ? $_POST['id'] : null;
          // var_dump($id);
          // die();
          
          if ($id) {
              // Proses EDIT (Update)
              $sql = "UPDATE `tbl_document` 
                      SET `name` = '$name',
                          `berkas` = '$blob',
                          `type` = '$type',
                          `id_department` = '$id_department',
                          `size` = '$size',
                          `update_by` = '$update_by',
                          `update_date` = '$update_date'
                      WHERE `id` = '$id'";

              if (mysqli_query($con, $sql)) {
                  // Berhasil update
                  echo "<script>
                          alert('Berhasil update dokumen!');
                          window.location.href = 'document_management.php';
                        </script>";
              } else {
                  // Gagal update
                  echo "<script>
                          alert('Update gagal: " . mysqli_error($con) . "');
                        </script>";
              }
          } else {
              // Proses INSERT (Create)
              $sql = "INSERT INTO `tbl_document` 
                      (`id`, `name`, `berkas`, `type`, `id_department`, `upload_by`, `size`, `uploaded_date`) 
                      VALUES 
                      (NULL, '$name', '$blob', '$type', '$id_department', '$upload_by', '$size', '$uploaded_date')";

              if (mysqli_query($con, $sql)) {
                  // Berhasil upload
                  echo "<script>
                          alert('Berhasil upload dokumen!');
                          window.location.href = 'document_management.php';
                        </script>";
              } else {
                  // Gagal upload
                  echo "<script>
                          alert('Upload gagal: " . mysqli_error($con) . "');
                        </script>";
              }
          }
      } else {
          // File bukan gambar atau PDF
          echo "<script>
                  alert('File bukan gambar atau PDF.');
                    window.location.href = 'manage_document_management.php'; 
                </script>";
      }

    
    }
    else {

      $id = isset($_POST['id']) ? $_POST['id'] : null;
      $id_department = isset($_POST['id_department']) ? $_POST['id_department'] : null;
      $upload_by = isset($_SESSION['ADMIN_USERNAME']) ? $_SESSION['ADMIN_USERNAME'] : ''; // Nama pengunggah
      $uploaded_date = date('Y-m-d H:i:s'); // Tanggal dan waktu saat ini
      $update_by = isset($_SESSION['ADMIN_USERNAME']) ? $_SESSION['ADMIN_USERNAME'] : ''; // Nama pengunggah
      $update_date = date('Y-m-d H:i:s');

      // var_dump($id);
      // die();

      if ($id) {
        // Proses EDIT (Update)
        $sql = "UPDATE `tbl_document` 
                SET                     
                    `id_department` = '$id_department',                   
                    `update_by` = '$update_by',
                    `update_date` = '$update_date'
                WHERE `id` = '$id'";

        if (mysqli_query($con, $sql)) {
            // Berhasil update
            echo "<script>
                    alert('Berhasil update dokumen!');
                    window.location.href = 'document_management.php';
                  </script>";
        } else {
            // Gagal update
            echo "<script>
                    alert('Update gagal: " . mysqli_error($con) . "');
                  </script>";
        }
    }
    else{      
      echo "<script>
      alert('Please upload file !');
      window.location.href = 'manage_document_management.php'; 
    </script>";
    }



    }
} else {
    echo "<script>
            alert('Tidak ada file yang diunggah.');
             window.location.href = 'manage_document_management.php'; 
          </script>";
}
?>
