<?php
require('top.inc.php');
isAdmin();
if(isset($_GET['type']) && $_GET['type']!=''){
	$type=get_safe_value($con,$_GET['type']);
	if($type=='status'){
		$operation=get_safe_value($con,$_GET['operation']);
		$id=get_safe_value($con,$_GET['id']);
		if($operation=='active'){
			$status='1';
		}else{
			$status='0';
		}
		// $update_status_sql="update tbl_department set status='$status' where Id_department='$id'";
		// mysqli_query($con,$update_status_sql);
	}
	
	if($type=='delete'){
		$id=get_safe_value($con,$_GET['id']);
		$delete_sql="delete from tbl_department where Id_department='$id'";
		mysqli_query($con,$delete_sql);
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
   <table id="adminTable" class="display nowrap" style="width:100%">
   <thead>
			<tr>
				<th class="serial">#</th>
				<th>ID</th>
				<th>Department</th>
				<th></th>
			</tr>
	</thead>
      <tbody>
         <?php
         $result = mysqli_query($con, "select * from tbl_department order by Nama_department asc");
         $no = 1;
         while($row = mysqli_fetch_assoc($result)){
         ?>
         <tr>
            <td><?php echo $no++ ?></td>
            <td><?php echo $row['Id_department'] ?></td>
            <td><?php echo $row['Nama_department'] ?></td>
            <td>
               <a href="manage_department.php?id=<?php echo $row['Id_department'] ?>">Edit</a> |
			   <a href='?type=delete&id=<?php echo $row['Id_department']; ?>' 
				onclick="return confirm('Are you sure you want to delete this department?');">
				Delete
				</a>
            </td>
         </tr>
         <?php } ?>
      </tbody>
   </table>
</div>

<?php
require('footer.inc.php');
?>

<script>
$(document).ready(function () {
    $('#adminTable').DataTable({
        dom: 'Bfrtip', // Layout dengan tombol
		buttons: [
            {
                text: 'Create', // Label tombol
                action: function () {
                    window.location.href = 'manage_department.php'; // Redirect ke link
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
