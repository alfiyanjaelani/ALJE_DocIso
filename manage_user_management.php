<?php
require('top.inc.php');
isAdmin();

$name = '';
$department_id = '';
$password = '';
$status = '1';  // Default status, bisa disesuaikan sesuai kebutuhan
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
    $res = mysqli_query($con, "SELECT * FROM tbl_user WHERE Id_User='$id'");
    $check = mysqli_num_rows($res);
    if ($check > 0) {
        $row = mysqli_fetch_assoc($res);
        $name = $row['Name'];
        $department_id = $row['Id_Departement'];
        $password = $row['Password'];
        $status = $row['Status'];



    // Tandai department yang sesuai dengan Id_department
    foreach ($departments as &$department) {
        // var_dump($department_id);
        // var_dump($department['id_department'] );
        // die();
        if ($department['id_department'] == $department_id) {
            $department['selected'] = true;
            break; // Keluar dari loop setelah menemukan kecocokan
        }
    }
    unset($department); // Menghindari referensi tidak sengaja ke elemen terakhir

    } else {
        header('location:user_management.php');
        die();
    }
}

if (isset($_POST['submit'])) {
    $name = get_safe_value($con, $_POST['name']);
    $department_id = get_safe_value($con, $_POST['id_department']);
    $password = get_safe_value($con, $_POST['password']);
    $status = get_safe_value($con, $_POST['status']);

    $res = mysqli_query($con, "SELECT * FROM tbl_user WHERE Name='$name'");
    $check = mysqli_num_rows($res);
    if ($check > 0) {
        if (isset($_GET['id']) && $_GET['id'] != '') {
            $getData = mysqli_fetch_assoc($res);
            if ($id == $getData['Id_User']) {
                // Do nothing
            } else {
                $msg = "Name already exists";
            }
        } else {
            $msg = "Name already exists";
        }
    }

    if ($msg == '') {

     

        if (isset($_GET['id']) && $_GET['id'] != '') {
            $update_sql = "UPDATE tbl_user SET Name='$name', Password='$password', Id_Departement='$department_id', Status='$status' WHERE Id_User='$id'";
            mysqli_query($con, $update_sql);
        } else {
            mysqli_query($con, "INSERT INTO tbl_user(Name, Password, Id_Departement, Status) VALUES('$name', '$password', '$department_id', '$status')");
        }
        header('location:user_management.php');
        die();
    }
}
?>
<div class="content pb-0">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header"><strong>USER MANAGEMENT FORM</strong></div>
                    <form method="post" enctype="multipart/form-data">
                        <div class="card-body card-block">
                            <div class="form-group">
                                <label for="name" class="form-control-label">Name</label>
                                <input type="text" name="name" placeholder="Enter name" class="form-control" required value="<?php echo $name; ?>">
                            </div>

                            <div class="form-group">
                                <label for="password" class="form-control-label">Password</label>
                                <input type="password" name="password" placeholder="Enter password" class="form-control" required value="<?php echo $password; ?>">
                            </div>

                            <div class="form-group">
                            <label for="id_department" class="form-control-label">Department</label>
                            <select name="id_department" class="form-control" required>
                                <option value="" <?php echo empty($Id_department) ? 'selected' : ''; ?>>Select Department</option>
                                <?php foreach ($departments as $department) { ?>
                                    <option value="<?php echo $department['id_department']; ?>" 
                                        <?php echo ($department['id_department'] == $department_id) ? 'selected' : ''; ?>>
                                        <?php echo $department['Nama_department']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                            </div>

                            <div class="form-group">
                                <label for="status" class="form-control-label">Status</label>
                                <select name="status" class="form-control">
                                    <option value="1" <?php echo $status == '1' ? 'selected' : ''; ?>>Active</option>
                                    <option value="0" <?php echo $status == '0' ? 'selected' : ''; ?>>Inactive</option>
                                </select>
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

<?php
require('footer.inc.php');
?>
