<?php
require('top.inc.php');
isAdmin();

if(isset($_GET['type']) && $_GET['type']!=''){
	$type = get_safe_value($con, $_GET['type']);
	if($type == 'status'){
		$operation = get_safe_value($con, $_GET['operation']);
		$id = get_safe_value($con, $_GET['id']);
		$status = ($operation == 'active') ? '1' : '0';
		$update_status_sql = "UPDATE tbl_user SET status = '$status' WHERE Id_User = '$id'";
		mysqli_query($con, $update_status_sql);
	}
	
	if($type == 'delete'){
		$id = get_safe_value($con, $_GET['id']);
		$delete_sql = "DELETE FROM tbl_user WHERE Id_User = '$id'";
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
   <table id="userTable" class="display nowrap" style="width:100%">
      <thead>
         <tr>
            <th class="serial">#</th>
            <th>ID</th>
            <th>Name</th>
            <th>Departement</th>
            <th>Password</th>
            <th>Status</th>
            <th>Actions</th>
         </tr>
      </thead>
      <tbody>
			<?php
		// Query SQL
		$query = "SELECT * FROM vw_user ORDER BY Name ASC";
		$result = mysqli_query($con, $query);

		// Periksa apakah query berhasil
		if (!$result) {
			// Jika query gagal, tampilkan pesan kesalahan
			echo "Error: " . mysqli_error($con);
			exit; // Keluar dari skrip jika query gagal
		}

		$no = 1;
		while ($row = mysqli_fetch_assoc($result)) {
		?>
		<tr>
			<td><?php echo $no++; ?></td>
			<td><?php echo $row['Id_User']; ?></td>
			<td><?php echo $row['Name']; ?></td>
			<td><?php echo $row['Nama_department']; ?></td>
			<td>
			<input 
                type="password" 
                value="<?php echo htmlspecialchars($row['Password']); ?>" 
                readonly 
                class="form-control border-0 bg-transparent"
            />
			</td>
			<td><?php echo $row['Status_user']; ?></td>
			<td>
				<a href="manage_user_management.php?id=<?php echo $row['Id_User']; ?>">Edit</a> |
				<a href="?type=delete&id=<?php echo $row['Id_User']; ?>" 
				onclick="return confirm('Are you sure you want to delete this user?');">
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
    $('#userTable').DataTable({
        dom: 'Bfrtip', // Layout dengan tombol
		buttons: [
            {
                text: 'Create', // Label tombol
                action: function () {
                    window.location.href = 'manage_user_management.php'; // Redirect ke link
                }
            },
            'csv', 'excel', 'pdf', 'print'
        ],
        responsive: true, // Membuat tabel responsif
        paging: true, // Menambahkan pagination
        searching: true // Menambahkan fitur pencarian
    });
});
</script>
