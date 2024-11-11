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

$sql = "SELECT * FROM tbl_user ORDER BY Id_User DESC";
$res = mysqli_query($con, $sql);
?>
<div class="content pb-0">
	<div class="orders">
	   <div class="row">
		  <div class="col-xl-12">
			 <div class="card">
				<div class="card-body">
				   <h4 class="box-title">User List</h4>
				   <h4 class="box-link"><a href="manage_user_management.php">ADD User</a> </h4>
				</div>
				<div class="card-body--">
				   <div class="table-stats order-table ov-h">
					  <table class="table">
						 <thead>
							<tr>
							   <th class="serial">#</th>
							   <th width="10%">ID</th>
							   <th width="20%">Name</th>
							   <th width="20%">Password</th>
							   <th width="20%">Department ID</th>
							   <th width="10%">Status</th>
							   <th width="20%">Actions</th>
							</tr>
						 </thead>
						 <tbody>
							<?php 
							$i = 1;
							while($row = mysqli_fetch_assoc($res)){?>
							<tr>
							   <td class="serial"><?php echo $i?></td>
							   <td><?php echo $row['Id_User']?></td>
							   <td><?php echo $row['Name']?></td>
							   <td><?php echo $row['Password']?></td>
							   <td><?php echo $row['Id_Departement']?></td>
							   <td><?php echo $row['Status'] == 1 ? 'Active' : 'Inactive'?></td>
							   <td>
								<?php
								if($row['Status'] == 1){
									echo "<span class='badge badge-complete'><a href='?type=status&operation=deactive&id=".$row['Id_User']."'>Active</a></span>&nbsp;";
								}else{
									echo "<span class='badge badge-pending'><a href='?type=status&operation=active&id=".$row['Id_User']."'>Inactive</a></span>&nbsp;";
								}
								echo "<span class='badge badge-edit'><a href='manage_user_management.php?id=".$row['Id_User']."'>Edit</a></span>&nbsp;";
								echo "<span class='badge badge-delete'><a href='?type=delete&id=".$row['Id_User']."'>Delete</a></span>";
								?>
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
