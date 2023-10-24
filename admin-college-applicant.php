<!DOCTYPE html>
<html lang="en">

<head>
	<?php
        include 'header.php';
        include 'config.php';

        $profile = ($_SESSION['admin'] ?? null);
        $collegeID = ($_GET['id'] ?? null);
        $applicantArray = fetchRows("SELECT * FROM `application` INNER JOIN college ON application.collegeid = college.collegeid");
        $collegeInfo = fetchRow("SELECT * FROM `college` WHERE collegeid = ".$collegeID);
        $roomStatus = fetchRow("SELECT * FROM `application` WHERE `status` = 1 && `collegeid` = ".$collegeID);
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
									<h5 class="card-title mb-0">View College Applicant</h5>
								</div>
								<div class="card-body">
                                    <table class="table table-bordered w-50" style="background: #f4f4f4;">
                                        <thead>
                                            <th>College Name</th>
                                            <th>Block</th>
                                            <th>Room Number</th>
                                            <th>Unit</th>
                                            <th>Status</th>
                                        </thead>
                                        <tbody>
                                            <td><?php echo ($collegeInfo['collegename']); ?></td>
                                            <td><?php echo ($collegeInfo['block']); ?></td>
                                            <td><?php echo ($collegeInfo['roomnumber']); ?></td>
                                            <td><?php echo ($collegeInfo['unit']); ?></td>
                                            <td><?php echo (empty($roomStatus) ? '<span class="badge bg-success">Available</span>' : '<span class="badge bg-danger">Not Available</span>'); ?></td>
                                        </tbody>
                                    </table>

                                    <h3 class="pt-3 pb-2">Total Applicant</h3>
									<table class="table table-bordered my-0">
										<thead>
											<tr>
                                                <th>#</th>
                                                <th>Matric Number</th>
                                                <th>College ID </th>
                                                <th>Check In</th>
                                                <th>Check Out</th>
                                                <th>Remark</th>
                                                <th>Status</th>
                                                <th>Action</th>
											</tr>
										</thead>
										<tbody>
											<?php
												if(!empty($applicantArray)){
                                                    $totalDisplay = 0;

													foreach($applicantArray as $key => $value){
                                                        $applicantStatus = '';

                                                        if($value['status'] == '0'){
                                                            $applicantStatus = '<span class="badge bg-secondary">Pending</span>'; 
                                                        } elseif ($value['status'] == '1'){
                                                            $applicantStatus = '<span class="badge bg-success">Approved</span>';
                                                        } elseif ($value['status'] == '2') {
                                                            $applicantStatus = '<span class="badge bg-danger">Rejected</span>';
                                                        }

                                                        if($value['collegeid'] == $collegeID){
                                                            $totalDisplay++;

                                                            echo '
                                                                <tr>
                                                                    <td>'.($key + 1).'</td>
                                                                    <td>'.$value['matricno'].'</td>
                                                                    <td>'.$value['collegeid'].'</td>
                                                                    <td>'.$value['checkin'].'</td>
                                                                    <td>'.$value['checkout'].'</td>
                                                                    <td>'.$value['remark'].'</td>
                                                                    <td>'.$applicantStatus.'</td>
                                                                    <td>
                                                                        <form method="POST" class="d-flex gap-1">
                                                                            <select class="form-control w-50" name="switchstatus" required>
                                                                                <option value="">-- Change Status --</option>
                                                                                <option value="0">Change To Pending</option>
                                                                                <option value="1">Change To Approved</option>
                                                                                <option value="2">Change To Rejected</option>
                                                                            </select>
                                                                            <input type="hidden" value="'.$value['matricno'].'" name="studentMetric"/>
                                                                            <button type="submit" value="'.$value['applicationid'].'" name="togglestatus" class="btn btn-primary btn-sm">Submit</button>
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                            ';
                                                        }
													}

                                                    if($totalDisplay == 0){
                                                        echo '<tr><td colspan="8">No Applicant Yet</td></tr>';
                                                    }
												}
											?>
										</tbody>
									</table>

                                    <a href="admin-college">
                                        <br><button type="button" class="btn btn-secondary">Go Back</button>
                                    </a>

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

    if(isset($_POST['togglestatus'])){
        $id = $_POST['togglestatus'];
        $metric = $_POST['studentMetric'];
        $status = $_POST['switchstatus'];
        $roomStatus = ($status == 1 ? 1 : 0);
        $messageNoti = '';

        if($status == '0'){
            $messageNoti = 'Your application status has been changed to Pending';
        } elseif ($status == '1'){
            $messageNoti = 'Your application has been Approved';
        } elseif ($status == '2') {
            $messageNoti = 'Your application Rejected';
        }

        runQuery("UPDATE `application` SET `status`='$status' WHERE `applicationid`='$id'");
        runQuery("INSERT INTO `notification` (`id`, `matricno`, `message`, `created_date`, `status`) VALUES (NULL, '$metric', '$messageNoti', current_timestamp(), NULL)");

        ToastMessage('Success', 'Status updated', 'success', 'admin-college-applicant?id='.$collegeID);
    }
?>
</html>