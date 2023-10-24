<!DOCTYPE html>
<html lang="en">

<head>
	<?php
        include 'header.php';
        include 'config.php';

		$staffArray = fetchRows("SELECT * FROM student");

		if(isset($_SESSION['admin']) && $_SESSION['admin']->email != 'admin@admin.admin'){
			header("Location: admin-my-resident.php");exit;
		}
    ?>
</head>

<body>
	<div class="wrapper">
		<?php include 'sidebar.php'; ?>

		<div class="main">
			<?php include 'top-navbar.php'; ?>

			<main class="content">
				<div class="container-fluid p-0">

					<div class="row">
						<div class="col-12 col-lg-12 col-xxl-12 d-flex">
							<div class="card flex-fill">
								<div class="card-header">
									<h5 class="card-title mb-0">Student List</h5>
								</div>
								<div class="card-body">
									<a href="./admin-resident-create" class="btn btn-primary mb-4">Add Student</a>
                                    <a href="#" class="btn btn-primary mb-4" onClick="window.print()">Print</a>

									<div style="overflow-x: auto;">
										<table class="table table-bordered my-0">
											<thead>
												<tr>
													<th>Matric Number</th>
													<th>Name</th>
													<th>Phone Number</th>
													<th>IC Number</th>
													<th>Email</th>
													<th>Program</th>
													<th>Studies Level</th>
													<th>Faculty</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<?php
													if(!empty($staffArray)){
														foreach($staffArray as $key => $value){
															$isDisabled = ($value['email'] == 'admin@admin.admin' ? 'disabled' : '');

															echo '
																<tr>
																	<td>'.$value['matricno'].'</td>
																	<td>'.$value['name'].'</td>
																	<td>'.$value['phonenumber'].'</td>
																	<td>'.$value['icno'].'</td>
																	<td>'.$value['email'].'</td>
																	<td>'.$value['program'].'</td>
																	<td>'.$value['studieslevel'].'</td>
																	<td>'.$value['faculty'].'</td>
																	<td>
																		<div style="display: flex;gap:.3em;">
																			<a href="admin-resident-create?id='.$value['matricno'].'" class="btn btn-success '.$isDisabled.'">Edit</a>
																			<a href="admin-resident-delete?id='.$value['matricno'].'" class="btn btn-danger '.$isDisabled.'">Delete</a>
																		</div>
																	</td>
																</tr>
															';
														}
													}
												?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
						
				</div>
			</main>

			<?php include 'footer.php'; ?>
		</div>
	</div>
</body>

<?php
    if(!isset($_SESSION['admin'])){
		ToastMessage('Invalid credential', 'Please login first', 'error', 'admin-login');
	}

	if(isset($_GET['delete'])){
		ToastMessage('Success', 'Admin deleted!', 'success', 'admin-resident`');
	}
?>
</html>