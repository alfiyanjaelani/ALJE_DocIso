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
        $update_status_sql = "UPDATE tbl_document SET status = '$status' WHERE id = '$id'";
        mysqli_query($con, $update_status_sql);
    }

    if ($type == 'delete') {
        $id = get_safe_value($con, $_GET['id']);
        $delete_sql = "DELETE FROM tbl_document WHERE id = '$id'";
        mysqli_query($con, $delete_sql);
    }
}


?>
<style>
    table.dataTable {
        width: 100%;
        margin: 0 auto;
    }

    table.dataTable td, table.dataTable th {
        white-space: nowrap;
    }
</style>

<div class="content mt-3">
   <table id="dokumenIsoTable" class="display nowrap" style="width:100%">
      <thead>
         <tr>
            <th class="serial">#</th>
            <th>ID</th>
            <th>Document Name</th>
            <th>Department</th>
            <th>Uploaded By</th>
            <th>Upload Date</th>
            <!-- <th>Extension</th> -->
            <th>Actions</th>         
         </tr>
      </thead>
      <tbody>
			<?php
            // Query SQL to fetch documents from dokumen_iso
            $query = "SELECT * FROM  vw_dokumen_with_department ORDER BY name_doc ASC";
            $result = mysqli_query($con, $query);

            // Check if the query was successful
            if (!$result) {
                // If the query failed, display an error message
                echo "Error: " . mysqli_error($con);
                exit; // Exit the script if the query failed
            }

            $no = 1;
            while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $row['id_doc']; ?></td>
                <td><?php echo $row['name_doc']; ?></td>
                <td><?php echo $row['Nama_department']; ?></td>
                <td><?php echo $row['upload_by']; ?></td>
                <td><?php echo $row['uploaded_date']; ?></td>                
                <!-- <td> -->
                    <!-- <?php echo $row['type']; ?> -->
                <!-- </td> -->
                <td>
                    <a href="manage_document_management.php?id=<?php echo $row['id_doc']; ?>">Edit</a> |
                    <a href="download.php?id=<?php echo $row['id_doc']; ?>" target="_blank">Download</a>|
                    <a href="?type=delete&id=<?php echo $row['id_doc']; ?>" 
                    onclick="return confirm('Are you sure you want to delete this document?');">
                    Delete
                    </a>
                </td>             
            </tr>
            <?php 
            }
            ?>
      </tbody>
   </table>
</div>

<?php
require('footer.inc.php');
?>

<script>
$(document).ready(function () {
    $('#dokumenIsoTable').DataTable({
        dom: 'Bfrtip', // Layout with buttons
        buttons: [
            {
                text: 'Create', // Label for the button
                action: function () {
                    window.location.href = 'manage_document_management.php'; // Redirect to the create page
                }
            },
            'csv', 'excel', 'pdf', 'print' // Export options
        ],
        responsive: true, // Make the table responsive
        paging: true, // Enable pagination
        searching: true // Enable searching functionality
    });
});
</script>