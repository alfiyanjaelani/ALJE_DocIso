<?php
require('top.inc.php');
isAdmin();

if (isset($_GET['type']) && $_GET['type'] != '') {
    $type = get_safe_value($con, $_GET['type']);
    if ($type == 'status') {
        $operation = get_safe_value($con, $_GET['operation']);
        $id = get_safe_value($con, $_GET['id']);
        if ($operation == 'active') {
            $status = '1';
        } else {
            $status = '0';
        }
        $update_status_sql = "UPDATE dokumen_iso SET status = '$status' WHERE id_doc = '$id'";
        mysqli_query($con, $update_status_sql);
    }

    if ($type == 'delete') {
        $id = get_safe_value($con, $_GET['id']);
        $delete_sql = "DELETE FROM dokumen_iso WHERE id_doc = '$id'";
        mysqli_query($con, $delete_sql);
    }
}

$sql = "SELECT * FROM dokumen_iso ORDER BY id_doc DESC";
$res = mysqli_query($con, $sql);
?>
<div class="content pb-0">
    <div class="orders">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="box-title">Document List</h4>
                        <h4 class="box-link"><a href="manage_document_management.php">ADD Document</a></h4>
                    </div>
                    <div class="card-body--">
                        <div class="table-stats order-table ov-h">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="serial">#</th>
                                        <th width="2%">ID</th>
                                        <th width="20%">Document Name</th>
                                        <th width="15%">Department ID</th>
                                        <th width="15%">File</th>
                                        <th width="10%">Extension</th>
                                        <th width="10%">Size</th>
                                        <th width="10%">Uploaded By</th>
                                        <th width="10%">Upload Date</th>
                                        <th width="26%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $i = 1;
                                    while ($row = mysqli_fetch_assoc($res)) { ?>
                                    <tr>
                                        <td class="serial"><?php echo $i ?></td>
                                        <td><?php echo $row['id_doc'] ?></td>
                                        <td><?php echo $row['name_doc'] ?></td>
                                        <td><?php echo $row['id_department'] ?></td>
                                        <td><a href="download.php?id=<?php echo $row['id_doc'] ?>">Download</a></td>
                                        <td><?php echo $row['Ekstensi'] ?></td>
                                        <td><?php echo $row['Size'] ?> KB</td>
                                        <td><?php echo $row['upload_by'] ?></td>
                                        <td><?php echo $row['upload_date'] ?></td>
                                        <td>
                                            <span class='badge badge-edit'>
                                                <a href='manage_document_management.php?id=<?php echo $row['id_doc'] ?>'>Edit</a>
                                            </span>&nbsp;
                                            <span class='badge badge-delete'>
                                                <a href='?type=delete&id=<?php echo $row['id_doc'] ?>'>Delete</a>
                                            </span>
                                        </td>
                                    </tr>
                                    <?php $i++; } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
require('footer.inc.php');
?>
