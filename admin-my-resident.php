<!DOCTYPE html>
<html lang="en">

<head>
	<?php
        include 'header.php';
        include 'config.php';

        $profile = ($_SESSION['admin'] ?? null);
		$staffArray = fetchRows("SELECT * FROM `application` JOIN `student` ON (`application`.`matricno` = `student`.`matricno`)");

		$myCollegeArray = [];
		$myCollege = fetchRows("SELECT * FROM `college` WHERE `manager` = ".$profile->userid);

		if(!empty($myCollege)){
			foreach($myCollege as $value){
				$myCollegeArray[] = $value['collegeid'];
			}
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
									<h5 class="card-title mb-0">Resident List</h5>
								</div>
								<div class="card-body table-responsive">
									<table class="table table-bordered my-0">
										<thead>
											<tr>
												<th>Matric Number</th>
												<th>Name</th>
												<th>Phone Number</th>
												<th>IC Number</th>
												<th>Email</th>
												<th>Program</th>
												<th>Sutdies Level</th>
												<th>Faculty</th>
												<th>College ID</th>
											</tr>
										</thead>
										<tbody>
											<?php
												$isPushed = [];

												if(!empty($staffArray)){
													foreach($staffArray as $key => $value){
														$collegeID = $value['collegeid'];

														if(in_array($value['matricno'], $isPushed)){
															continue;
														}

														if(!in_array($collegeID, $myCollegeArray)){
															continue;
														}

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
																<td>'.$collegeID.'</td>
															</tr>
														';

														$isPushed[] = $value['matricno'];
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
			</main>

			<?php include 'footer.php'; ?>
		</div>
	</div>

    <script>

    </script>
</body>

<?php
    if(!isset($_SESSION['admin'])){
		ToastMessage('Invalid credential', 'Please login first', 'error', 'admin-login');
	}
?>
</html>