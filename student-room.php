<!DOCTYPE html>
<html lang="en">

<head>
	<?php
        include 'header.php';
        include 'config.php';

        $Auth = ($_SESSION['student'] ?? null);
        $profile = fetchRow("SELECT * FROM `student` WHERE `matricno` = '".$Auth->matricno."'");
        $collegeArray = fetchRows("SELECT * FROM `college` JOIN `application` ON (`college`.`collegeid` = `application`.`collegeid`) WHERE `application`.`status` = 1 AND `application`.`matricno` = '".$Auth->matricno."'");

        if($profile){
            $profile = json_decode(json_encode($profile), false);
        }
    ?>

    <style>
        .alert{
            border-right: none !important;
            border-bottom: none !important;
            border-top: none !important;
            background: var(--bs-body-bg);
        };
    </style>
</head>

<body>
	<div class="wrapper">
		<?php include 'sidebar.php'; ?>

		<div class="main">
			<?php include 'top-navbar.php'; ?>

			<main class="content">
				<div class="container-fluid p-0">

                <div class="card">
                    <div class="card-header">
                        <div class="card-title">My Room</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <?php 
                                if(!empty($collegeArray)){
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

                                        $roomStatus = fetchRow("SELECT * FROM `application` WHERE `status` = 1 && `collegeid` = ".$collegeID);

                                        echo '
                                        <div class="card col-3" style="margin-right:.3em;">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col mt-0">
                                                        <h5 class="card-title">'.$value['collegename'].'</h5>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="stat text-primary">
                                                            <i class="align-middle" data-feather="home"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <h1 class="mt-2 mb-3">'.$value['unit'].'</h1>
                                                <div class="mb-3">'.$managerEmail.'</div>
                                            </div>
                                        </div>';
                                    }
                                }else{
                                    echo '
                                    <div class="border border-success alert p-3 alert" role="alert">
                                        No room yet. Click <a href="./student-college">here</a> to apply your college
                                    </div>';
                                }
                            ?>
                        </div>
                    </div>
                    <div class="card-footer"></div>
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
    if(!isset($_SESSION['student'])){
		ToastMessage('Invalid credential', 'Please login first', 'error', 'student-login');
	}
?>
</html>