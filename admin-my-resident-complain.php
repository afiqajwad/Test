<!DOCTYPE html>
<html lang="en">

<head>
	<?php
        include 'header.php';
        include 'config.php';

        $profile = ($_SESSION['admin'] ?? null);
		$myCollegeArray = [];
		$myCollege = fetchRows("SELECT * FROM `college` WHERE `manager` = ".$profile->userid);
		$complainDataset = fetchRows("SELECT * FROM helpdesk");

		if($complainDataset){
            $complainDataset = json_decode(json_encode($complainDataset), false);
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
							<h3 class="pb-3">House Under <?php echo $profile->name; ?></h3>
						</div>
						<?php
							if(!empty($myCollege)){
								foreach($myCollege as $value){
									$myCollegeArray[] = $value['collegeid'];

									echo '
									<div class="col-4 col-lg-4 col-xxl-4 d-flex">
										<div class="card flex-fill">
											<div class="card-header">
												<h5 class="card-title mb-0">'.$value['collegename'].'</h5>
											</div>
											<div class="card-body">
												<table class="w-100 table table-hovered">
													<tr><th>Unit</th><td>'.$value['unit'].'</td></tr>
													<tr><th>Block</th><td>'.$value['block'].'</td></tr>
													<tr><th>Room Number</th><td>'.$value['roomnumber'].'</td></tr>
												</table>
											</div>
										</div>
									</div>';
								}
							}else{
								echo '<div class="col-12 col-lg-12 col-xxl-12 d-flex"><span class="p-3 bg-white w-100">No College Yet</span></div>';
							}
						?>
					</div>

					<div class="row mt-3">
						<div class="col-12 col-lg-12 col-xxl-12 d-flex">
							<div class="card flex-fill">
								<div class="card-header">
									<h5 class="card-title mb-0">Complain That Happen In Your House</h5>
								</div>
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
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											<?php
												$collegeScope = implode(',',$myCollegeArray);
												$totalDisplayComplain = 0;

												if(!empty($complainDataset)){
													foreach($complainDataset as $key => $value){
														$complainstatus = '';
														$getComplainStudent = fetchRow("SELECT * FROM `student` WHERE `matricno` = '".$value->matricno."'");
														$getApplication = fetchRows("SELECT * FROM `application` WHERE `matricno` = '".$value->matricno."' AND `collegeid` IN (".$collegeScope.")");

														if(empty($getApplication)){
															continue;
														}

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
																<td>
																	<form method="POST" class="d-flex gap-1">
																		<select class="form-control w-50" name="helpdeskstatus" required>
																			<option value="">- Status -</option>
																			<option value="0">Change To Unsolved</option>
																			<option value="1">Change To Solve</option>
																		</select>
																		<input type="hidden" value="'.$value->matricno.'" name="studentMetric"/>
																		<button type="submit" value="'.$value->helpdeskid.'" name="togglestatus" class="btn btn-primary btn-sm">Submit</button>
																	</form>
																</td>
															</tr>
														';

														$totalDisplayComplain++;
													}
												}

												if($totalDisplayComplain == 0){
													echo '<tr><td colspan="6">No Complain Yet</td></tr>';
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

	if(isset($_POST['togglestatus'])){
        $helpdeskid = $_POST['togglestatus'];
		$metric = $_POST['studentMetric'];
        $status = $_POST['helpdeskstatus'];
        $roomStatus = ($status == 1 ? 1 : 0);

        $messageNoti = 'Your college issue has been updated!';

        runQuery("UPDATE `helpdesk` SET `status`='$status' WHERE `helpdeskid`='$helpdeskid'");

        runQuery("INSERT INTO `notification` (`id`, `matricno`, `message`, `created_date`, `status`) VALUES (NULL, '$metric', '$messageNoti', current_timestamp(), NULL)");

        ToastMessage('Success', 'Status updated', 'success', 'admin-my-resident-complain');
    }
?>
</html>