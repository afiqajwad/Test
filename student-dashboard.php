<!DOCTYPE html>
<html lang="en">

<head>
	<?php
        include 'header.php';
        include 'config.php';

		$Auth = ($_SESSION['student'] ?? null);
		$complainDataset = fetchRows("SELECT * FROM helpdesk WHERE helpdesk.matricno = '".$Auth->matricno."'");

		if($complainDataset){
            $complainDataset = json_decode(json_encode($complainDataset), false);
        }

		$applicantArray = fetchRows("SELECT * FROM `college` JOIN `application` ON (`college`.`collegeid` = `application`.`collegeid`) WHERE `application`.`matricno` = '".$Auth->matricno ."'");
    ?>
</head>

<body>
	<div class="wrapper">
		<?php include 'sidebar.php'; ?>

		<div class="main">
			<?php include 'top-navbar.php'; ?>

			<main class="content">
				<div class="container-fluid p-0">

					<h1 class="h3 mb-3"><strong>Student</strong> Dashboard</h1>

					<div class="row">
						<div class="col-12 d-flex">
							<div class="card flex-fill">
								<div class="card-header d-flex">
									<h5 class="card-title mb-0 flex-fill">My Complain</h5>

									<a class="btn btn-primary btn-sm" href="student-complain">
										<i class="align-middle" data-feather="file-text"></i> Report Defect
									</a>
								</div>
								<div class="card-body table-responsive">
									<table class="table table-hover my-0">
										<thead>
											<tr>
												<th>#</th>
												<th class="d-none d-xl-table-cell">Reference</th>
												<th class="d-none d-xl-table-cell">Description</th>
												<th>Status</th>
											</tr>
										</thead>
										<tbody>
											<?php
												if(!empty($complainDataset)){
													foreach($complainDataset as $key => $value){
														echo '
															<tr>
																<td>'.($key + 1).'</td>
																<td class="d-none d-xl-table-cell">
																	<img src="img/photos/'.$value->picture.'" height="80" width="100" style="object-fit: cover;"/>
																</td>
																<td class="d-none d-xl-table-cell" style="white-space: normal;">'.$value->comment.'</td>
																<td><span class="badge bg-success">Done</span></td>
															</tr>
														';
													}
												}else{
													echo '<tr><td colspan="4">No Report Yet</td></tr>'; 
												}
											?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-12 d-flex">
							<div class="card flex-fill">
								<div class="card-header d-flex">
									<h5 class="card-title mb-0 flex-fill">My Application</h5>
								</div>
								<div class="card-body table-responsive">
									<table class="table table-bordered my-0">
										<thead>
											<tr>
                                                <th>#</th>
                                                <th>House ID </th>
                                                <th>Check In</th>
                                                <th>Check Out</th>
                                                <th>Remark</th>
                                                <th>Status</th>
                                                <th></th>
											</tr>
										</thead>
										<tbody>
											<?php
												if(!empty($applicantArray)){
                                                    $totalDisplay = 0;

													foreach($applicantArray as $key => $value){
                                                        $applicantStatus = '';
														$viewbutton = '';

                                                        if($value['status'] == '0'){
                                                            $applicantStatus = '<span class="badge bg-secondary">Pending</span>'; 
                                                        } elseif ($value['status'] == '1'){
															$viewbutton = '<a href="./student-room">View</a>';
                                                            $applicantStatus = '<span class="badge bg-success">Approved</span>';
                                                        } elseif ($value['status'] == '2') {
                                                            $applicantStatus = '<span class="badge bg-danger">Rejected</span>';
                                                        }

														echo '
															<tr>
																<td>'.($key + 1).'</td>
																<td>'.$value['collegeid'].'</td>
																<td>'.$value['checkin'].'</td>
																<td>'.$value['checkout'].'</td>
																<td>'.$value['remark'].'</td>
																<td>'.$applicantStatus.'</td>
																<td>'.$viewbutton.'</td>
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
</body>

<?php
    if(!isset($_SESSION['student'])){
		ToastMessage('Invalid credential', 'Please login first', 'error', 'student-login');
	}
?>
</html>