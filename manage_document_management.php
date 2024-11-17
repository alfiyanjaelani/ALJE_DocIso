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
$update_by='';
$departments = []; // Array to store department list
$Id_department =1;

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
    $res = mysqli_query($con, "SELECT * FROM tbl_document WHERE id='$id'");
    $check = mysqli_num_rows($res);
    if ($check > 0) {
        $row = mysqli_fetch_assoc($res);
        $name_doc = $row['name'];
        $Id_department = $row['Id_department'];
        $upload_by = $row['upload_by'];
        $upload_date = $row['uploaded_date'];
        $size = $row['size'];
        $ekstensi = $row['type'];
        $berkas = $row['berkas'];
        $update_date = $row['update_date'];
        $update_by = $row['update_by'];
        $id_document =$row['id'];

        if (empty($berkas)) {
            echo "No file found for this record.";
        }

      

        // Tandai department yang sesuai dengan Id_department
        foreach ($departments as &$department) {
            if ($department['id_department'] == $Id_department) {
                $department['selected'] = true;
                break; // Keluar dari loop setelah menemukan kecocokan
            }
        }
        unset($department); // Menghindari referensi tidak sengaja ke elemen terakhir
    } else {
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
                    <form method="post" action="act_document.php"  enctype="multipart/form-data">
                        <div class="card-body card-block">  
                        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : ''; ?>">                       
                        <div class="form-group">
                            <label for="id_department" class="form-control-label">Department</label>
                            <select name="id_department" class="form-control" required>
                                <option value="" <?php echo empty($Id_department) ? 'selected' : ''; ?>>Select Department</option>
                                <?php foreach ($departments as $department) { ?>
                                    <option value="<?php echo $department['id_department']; ?>" 
                                        <?php echo ($department['id_department'] == $Id_department) ? 'selected' : ''; ?>>
                                        <?php echo $department['Nama_department']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
   
                   
                        <div class="form-group">
                            <label for="berkas" class="form-control-label">Upload File</label>                        
                            <input 
                                type="file" 
                                name="berkas" 
                                id="berkas" 
                                accept="image/*,application/pdf" 
                                onchange="updateFileInfo()"                     
                                class="form-control"                                
                            />                            
                            <!-- Display current file if exists -->
                            <?php if (isset($berkas) && !empty($berkas)) { ?>
                                <small>
                                    Current file: 
                                    <a href="download.php?id=<?php echo $id_document; ?>" target="_blank"><?php echo $name_doc; ?></a>                                                                      
                                </small>
                            <?php } ?>
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


<?php require('footer.inc.php'); ?>


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
