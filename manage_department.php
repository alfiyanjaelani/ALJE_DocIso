<?php
require('top.inc.php');
isAdmin();
$departementname='';
$msg='';
if(isset($_GET['id']) && $_GET['id']!=''){
	$id=get_safe_value($con,$_GET['id']);
	$res=mysqli_query($con,"select * from tbl_department where Id_department='$id'");
	$check=mysqli_num_rows($res);
	if($check>0){
		$row=mysqli_fetch_assoc($res);
		$departementname=$row['Nama_department'];
	}else{
		header('location:departments.php');
		die();
	}
}

if(isset($_POST['submit'])){
	$departementname=get_safe_value($con,$_POST['categories']);
	$res=mysqli_query($con,"select * from tbl_department where Nama_department='$departementname'");
	$check=mysqli_num_rows($res);
	if($check>0){
		if(isset($_GET['id']) && $_GET['id']!=''){
			$getData=mysqli_fetch_assoc($res);
			if($id==$getData['Id_department']){
			
			}else{
				$msg="DEPARTMENT ALREADY EXIST";
			}
		}else{
			$msg="DEPARTMENT ALREADY EXIST";
		}
	}
	
	if($msg==''){
		if(isset($_GET['id']) && $_GET['id']!=''){
			mysqli_query($con,"update tbl_department set Nama_department='$departementname' where Id_department='$id'");
		}else{
			mysqli_query($con,"insert into tbl_department(Nama_department) values('$departementname')");
		}
		header('location:departments.php');
		die();
	}
}
?>
<div class="content pb-0">
            <div class="animated fadeIn">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="card">
                        <div class="card-header"><strong>Department FORM</strong> </div>
                        <form method="post">
							<div class="card-body card-block">
							   <div class="form-group">
									<label for="categories" class=" form-control-label">Department Name</label>
									<input type="text" name="categories" placeholder="ENTER Department Name" class="form-control" required value="<?php echo $departementname?>">
								</div>
							   <button id="payment-button" name="submit" type="submit" class="btn btn-lg btn-info btn-block">
							   <span id="payment-button-amount">SUBMIT</span>
							   </button>
							   <div class="field_error"><?php echo $msg?></div>
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