<?php
require('top.inc.php');
isAdmin();

// Check if the session has an ADMIN_USERNAME value
$upload_by = isset($_SESSION['ADMIN_USERNAME']) ? $_SESSION['ADMIN_USERNAME'] : '';

$name_doc = '';
$id_department = '';
$upload_date = '';
$size = '';
$ekstensi = '';
$berkas = '';
$departments = []; // Array to store department list

// Fetch departments from the database
$dept_query = mysqli_query($con, "SELECT id_department, Nama_department FROM tbl_department");

if ($dept_query === false) {
    die("Error fetching departments: " . mysqli_error($con));
}

while ($dept_row = mysqli_fetch_assoc($dept_query)) {
    $departments[] = $dept_row;
}

$msg = '';
if (isset($_GET['id']) && $_GET['id'] != '') {
    $id = get_safe_value($con, $_GET['id']);
    $res = mysqli_query($con, "SELECT * FROM dokumen_iso WHERE id_doc='$id'");
    $check = mysqli_num_rows($res);
    if ($check > 0) {
        $row = mysqli_fetch_assoc($res);
        $name_doc = $row['name_doc'];
        $id_department = $row['id_department'];
        $upload_by = $row['upload_by'];
        $upload_date = $row['upload_date'];
        $size = $row['Size'];
        $ekstensi = $row['Ekstensi'];
        $berkas = $row['Berkas'];
    } else {
        header('location: document_management.php');
        die();
    }
}

if (isset($_POST['submit'])) {
    $name_doc = get_safe_value($con, $_POST['name_doc']);
    $id_department = get_safe_value($con, $_POST['id_department']);
    $upload_by = get_safe_value($con, $_POST['upload_by']);
    $upload_date = get_safe_value($con, $_POST['upload_date']);
    $size = get_safe_value($con, $_POST['size']);
    $ekstensi = get_safe_value($con, $_POST['ekstensi']);

    // Handle file upload
    if (isset($_FILES['berkas']['tmp_name']) && $_FILES['berkas']['tmp_name'] != '') {
        $file_tmp = $_FILES['berkas']['tmp_name'];
        $berkas = file_get_contents($file_tmp);
    } else {
        // If no file uploaded, retain the existing 'Berkas' value
        $berkas = $berkas ? $berkas : '';
    }

    // Proceed only if no errors
    if ($msg == '') {
        if (isset($_GET['id']) && $_GET['id'] != '') {
            // Update existing document
            $update_sql = "UPDATE dokumen_iso SET name_doc=?, id_department=?, upload_by=?, upload_date=?, Size=?, Ekstensi=?, Berkas=? WHERE id_doc=?";
            $stmt = mysqli_prepare($con, $update_sql);
            mysqli_stmt_bind_param($stmt, 'sssssssb', $name_doc, $id_department, $upload_by, $upload_date, $size, $ekstensi, $berkas, $id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        } else {
            // Insert new document record
            $insert_sql = "INSERT INTO dokumen_iso(name_doc, id_department, upload_by, upload_date, Size, Ekstensi, Berkas) VALUES(?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($con, $insert_sql);
            mysqli_stmt_bind_param($stmt, 'sssssss', $name_doc, $id_department, $upload_by, $upload_date, $size, $ekstensi, $berkas);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
        header('location: document_management.php');
        die();
    }
}
?>

<div class="content pb-0">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header"><strong>DOCUMENT FORM</strong></div>
                    <form method="post" enctype="multipart/form-data">
                        <div class="card-body card-block">
                            <div class="form-group">
                                <label for="name_doc" class="form-control-label">Document Name</label>
                                <input type="text" name="name_doc" placeholder="Enter document name" class="form-control" required value="<?php echo $name_doc; ?>">
                            </div>
                            <div class="form-group">
                                <label for="id_department" class="form-control-label">Department</label>
                                <select name="id_department" class="form-control" required>
                                    <option value="">Select Department</option>
                                    <?php foreach ($departments as $department) { ?>
                                        <option value="<?php echo $department['id_department']; ?>" <?php if ($department['id_department'] == $id_department) echo 'selected'; ?>>
                                            <?php echo $department['Nama_department']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>       
                            <div class="form-group">
                                <label for="upload_by" class="form-control-label">Uploaded By</label>
                                <input type="text" name="upload_by" class="form-control" required value="<?php echo $upload_by; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="berkas" class="form-control-label">Upload File</label>
                                <input type="file" id="berkas" name="berkas" class="form-control" onchange="updateFileInfo()">
                                <?php if ($berkas) { echo "<small>Current file: $berkas</small>"; } ?>
                            </div>
                            <div class="form-group">
                                <label for="upload_date" class="form-control-label">Upload Date</label>
                                <input type="date" name="upload_date" class="form-control" required value="<?php echo $upload_date ? $upload_date : date('Y-m-d'); ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="size" class="form-control-label">File Size (in KB)</label>
                                <input type="number" id="size" name="size" placeholder="Enter file size" class="form-control" required readonly value="<?php echo $size; ?>">
                            </div>
                            <div class="form-group">
                                <label for="ekstensi" class="form-control-label">File Extension</label>
                                <input type="text" id="ekstensi" name="ekstensi" placeholder="Enter file extension" class="form-control" required readonly value="<?php echo $ekstensi; ?>">
                            </div>                            

                            <button id="payment-button" name="submit" type="submit" class="btn btn-lg btn-info btn-block">
                                <span id="payment-button-amount">SUBMIT</span>
                            </button>
                            <div class="field_error"><?php echo $msg; ?></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function updateFileInfo() {
        const fileInput = document.getElementById('berkas');
        const file = fileInput.files[0];
        if (file) {
            // Update the file size in KB
            document.getElementById('size').value = Math.round(file.size / 1024);
            
            // Extract and set the file extension
            const fileName = file.name;
            const fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1).toLowerCase();
            document.getElementById('ekstensi').value = fileExtension;
        }
    }
</script>

<?php
require('footer.inc.php');
?>
