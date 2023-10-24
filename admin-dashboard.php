<!DOCTYPE html>
<html lang="en">

<head>
	<?php
        include 'header.php';
        include 'config.php';

		$totalCompliant = [];

		$adminDataset = fetchRows("SELECT * FROM admin");
		$complainDataset = fetchRows("SELECT * FROM helpdesk");
		$studentDataset = fetchRows("SELECT * FROM student");
		$collegeDataset = fetchRows("SELECT * FROM college");

		if($complainDataset){
            $complainDataset = json_decode(json_encode($complainDataset), false);
        }

		for($i = 1; $i <= 12; $i++){
			$totalCollection = 0;
			$mon = sprintf("%02d", $i);
			$fetchMonthly = fetchRows("SELECT * FROM `application` WHERE `checkin` LIKE '%-$mon-%'");

			$totalCompliant[] = count($fetchMonthly);
		}

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

					<h1 class="h3 mb-3"><strong>Admin</strong> Dashboard</h1>

					<div class="row">
						<div class="col-xl-6 col-xxl-5 d-flex">
							<div class="w-100">
								<div class="row">
									<div class="col-sm-6">
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col mt-0">
														<h5 class="card-title">Total College</h5>
													</div>

													<div class="col-auto">
														<div class="stat text-primary">
															<i class="align-middle" data-feather="users"></i>
														</div>
													</div>
												</div>
												<h1 class="mt-1 mb-3"><?php echo count($collegeDataset);?></h1>
											</div>
										</div>
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col mt-0">
														<h5 class="card-title">Total Complain</h5>
													</div>

													<div class="col-auto">
														<div class="stat text-primary">
															<i class="align-middle" data-feather="users"></i>
														</div>
													</div>
												</div>
												<h1 class="mt-1 mb-3"><?php echo count($complainDataset);?></h1>
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col mt-0">
														<h5 class="card-title">Total Student</h5>
													</div>

													<div class="col-auto">
														<div class="stat text-primary">
															<i class="align-middle" data-feather="users"></i>
														</div>
													</div>
												</div>
												<h1 class="mt-1 mb-3"><?php echo count($studentDataset); ?></h1>
											</div>
										</div>
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col mt-0">
														<h5 class="card-title">Total Admin</h5>
													</div>

													<div class="col-auto">
														<div class="stat text-primary">
															<i class="align-middle" data-feather="users"></i>
														</div>
													</div>
												</div>
												<h1 class="mt-1 mb-3"><?php echo count($adminDataset);?></h1>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="col-xl-6 col-xxl-7">
							<div class="card flex-fill w-100">
								<div class="card-header">

									<h5 class="card-title mb-0">Total Application In 2023</h5>
								</div>
								<div class="card-body d-flex w-100">
									<div class="align-self-center chart chart-lg">
										<canvas id="MonthlyComplain"></canvas>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-12 col-lg-12 col-xxl-12 d-flex">
							<div class="card flex-fill">
								<div class="card-header"><h5 class="card-title mb-0">Complaint List</h5></div>
								<div class="card-body table-responsive">
									<table class="table table-hover my-0">
										<thead>
											<tr>
												<th>#</th>
												<th class="d-none d-xl-table-cell">Picture</th>
												<th class="d-none d-xl-table-cell">Description</th>
												<th class="d-none d-xl-table-cell">Student</th>
												<th class="d-none d-xl-table-cell">Student Name</th>
												<th>Status</th>
											</tr>
										</thead>
										<tbody>
											<?php
												if(!empty($complainDataset)){
													foreach($complainDataset as $key => $value){
														$complainstatus = '';
														$getComplainStudent = fetchRow("SELECT * FROM `student` WHERE `matricno` = '".$value->matricno."'");

														if($value->status == '0'){
                                                            $complainstatus = '<span class="badge bg-danger">Unsolve</span>'; 
                                                        }

														if($value->status == '1'){
                                                            $complainstatus = '<span class="badge bg-success">Solved</span>'; 
                                                        }
														
														echo '
															<tr>
																<td>'.($key + 1).'</td>
																<td class="d-none d-xl-table-cell">
																	<img src="img/photos/'.$value->picture.'" height="80" width="100" style="object-fit: cover;"/>
																</td>
																<td class="d-none d-xl-table-cell" style="white-space: normal;">'.$value->comment.'</td>
																<td class="d-none d-xl-table-cell">'.$getComplainStudent['matricno'].'</td>
																<td class="d-none d-xl-table-cell">'.$getComplainStudent['name'].'</td>
																<td>'.$complainstatus.'</td>
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
			</main>

			<?php include 'footer.php'; ?>
		</div>
	</div>

	<script>
		let compliantBarChart = document.getElementById("MonthlyComplain");

		document.addEventListener("DOMContentLoaded", function() {
			//# Bar Chart
			new Chart(compliantBarChart, {
				type: "bar",
				data: {
					labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
					datasets: [{
						label: "This year",
						backgroundColor: window.theme.primary,
						borderColor: window.theme.primary,
						hoverBackgroundColor: window.theme.primary,
						hoverBorderColor: window.theme.primary,
						data: <?php echo json_encode($totalCompliant); ?>,
						barPercentage: .75,
						categoryPercentage: .5
					}]
				},
				options: {
					maintainAspectRatio: false,
					legend: {
						display: false
					},
					scales: {
						yAxes: [{
							gridLines: {
								display: false
							},
							stacked: false,
							ticks: {
								stepSize: 20
							}
						}],
						xAxes: [{
							stacked: false,
							gridLines: {
								color: "transparent"
							}
						}]
					}
				}
			});
		});
	</script>
</body>

<?php
    if(!isset($_SESSION['admin'])){
		ToastMessage('Invalid credential', 'Please login first', 'error', 'student-login');
	}
?>
</html>