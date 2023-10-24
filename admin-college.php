<!DOCTYPE html>
<html lang="en">

<head>
	<?php
        include 'header.php';
        include 'config.php';

        $profile = ($_SESSION['admin'] ?? null);
		$collection = [];
		$collegeArray = fetchRows("SELECT * FROM college");
		$applicantArray = fetchRows("SELECT * FROM `application` INNER JOIN college ON application.collegeid = college.collegeid");

		if(isset($_SESSION['admin']) && $_SESSION['admin']->email != 'admin@admin.admin'){
			header("Location: admin-my-resident.php");exit;
		}

		if(!empty($collegeArray)){
			//# AVAILABLE DATA
			foreach($collegeArray as $key => $value){
				$collegeID = $value['collegeid'];
				$managerID = ($value['manager'] ?? 0);
				$managerEmail = '-';
				$totalApproved = 0;

				$managerDetails = fetchRow("SELECT * FROM `admin` WHERE userid = ".$managerID);
				$totalApplicant = fetchRow("SELECT count(*) as totalApply FROM `application` WHERE collegeid = ".$collegeID);

				if(!empty($managerDetails)){
					$managerEmail = $managerDetails['email'];
				}

				$statusTag = '<span class="badge bg-danger">Not Available</span>';
				$roomStatus = fetchRow("SELECT * FROM `application` WHERE `status` = 1 AND `collegeid` = ".$collegeID);

				if(empty($roomStatus)){
					$collection[] = (object)[
						'name' => $value['collegename'],
						'available' => '<span class="badge bg-success">Available</span>',
						'unit' => $value['unit'],
						'capacity' => ($value['capacity'] - $totalApproved),
						'manager' => $managerEmail,
						'collegeID' => $collegeID,
						'applicant' => $totalApplicant['totalApply']
					];
				}
			}

			//# NOT AVAILABLE DATA
			foreach($collegeArray as $key => $value){
				$collegeID = $value['collegeid'];
				$managerID = ($value['manager'] ?? 0);
				$managerEmail = '-';
				$totalApproved = 0;

				$managerDetails = fetchRow("SELECT * FROM `admin` WHERE userid = ".$managerID);
				$totalApplicant = fetchRow("SELECT count(*) as totalApply FROM `application` WHERE collegeid = ".$collegeID);

				if(!empty($managerDetails)){
					$managerEmail = $managerDetails['email'];
				}

				$roomStatus = fetchRow("SELECT * FROM `application` WHERE `status` = 1 AND `collegeid` = ".$collegeID);

				if(!empty($roomStatus)){
					$collection[] = (object)[
						'name' => $value['collegename'],
						'available' => '<span class="badge bg-danger">Not Available</span>',
						'unit' => $value['unit'],
						'capacity' => ($value['capacity'] - $totalApproved),
						'manager' => $managerEmail,
						'collegeID' => $collegeID,
						'applicant' => $totalApplicant['totalApply']
					];
				}
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
						<div class="card flex-fill" style="box-shadow: none !important;">
							<div class="card-header">
								<h5 class="card-title mb-0">Manage House</h5>
							</div>
							<div class="card-body" style="background: #f5f7fb;">

								<a href="admin-college-create" class="btn btn-primary mb-4">Add House</a>
								<a href="#" class="btn btn-primary mb-4" onClick="window.print()">Print</a>

								<div class="row">
									<?php 
										if(!empty($collection)){
											foreach($collection as $key => $value){
												echo '
												<div class="card col-3" style="margin-right:.3em;">
													<div class="card-body">
														<div class="row">
															<div class="col mt-0">
																<h5 class="card-title">'.$value->name.'</h5>
															</div>
															<div class="col-auto">'.$value->available.'</div>
														</div>
														<h1 class="mt-2 mb-3">'.$value->unit.'</h1>
														<!--<div class="mt-3 mb-2">
															<span class="text-success">'.$value->capacity.'</span>
															<span class="text-muted">Room Available</span>
														</div>-->
														<div class="mb-3">'.$value->manager.'</div>
														<a href="admin-college-applicant?id='.$value->collegeID.'" class="btn-sm btn-secondary btn">'.$value->applicant.' Student</button>
														<a href="admin-college-delete?id='.$value->collegeID.'" class="btn-sm btn-danger btn">Remove</a>
													</div>
												</div>';
											}
										}else{

										}
									?>
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
		ToastMessage('Success', 'College deleted!', 'success', 'admin-college');
	}
?>
</html>