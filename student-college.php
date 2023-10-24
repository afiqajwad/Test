<!DOCTYPE html>
<html lang="en">

<head>
	<?php
        include 'header.php';
        include 'config.php';

        $step = 1;
        $profile = ($_SESSION['student'] ?? null);

        if(isset($_GET['1'])){
            $step = 2;
            $collegeUnit = fetchRows("SELECT * FROM college WHERE collegename = '".$_GET['1']."' AND roomstatus = '0'");
        }

        if(isset($_GET['1']) && isset($_GET['2'])){
            $step = 3;
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

                <form method="<?php echo ($step == 1 ? 'GET' : 'POST'); ?>">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title">Submit New Application ( Step <?php echo $step; ?> )</div>
                                </div>

                                <div class="card-body">
                                    <!-- STEP 1 -->
                                    <?php if($step == 1){ ?>
                                        <div class="row mb-4">
                                            <label class="col-md-3 form-label"> House You Would Like To Apply :</label>
    
                                            <div class="col-md-9">
                                                <select required class="form-control" name="1">
                                                    <option value="">-- Nothing Selected --</option>
                                                    <option value="Crystal View">Crystal View</option>
                                                    <option value="Suria Jaya">Suria Jaya</option>
                                                    <option value="Baiduri">Baiduri</option>
                                                </select>
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <!-- STEP 2 -->
                                    <?php if($step == 2){ ?>
                                        <div class="row mb-4">
                                            <label class="col-md-3 form-label"> Room You Would Like To Apply :</label>

                                            <div class="col-md-9">
                                                <?php
                                                    if(!empty($collegeUnit)){
                                                        echo '<select required class="form-control" name="collegeid">';
                                                        echo '<option value="" selected>-- Nothing Selected --</option>';

                                                        foreach($collegeUnit as $key => $value){
                                                            $collegeID = $value['collegeid'];

                                                            $roomStatus = fetchRow("SELECT * FROM `application` WHERE `status` = 1 && `collegeid` = ".$collegeID);

                                                            if(empty($roomStatus)){
                                                                echo '<option value="'.$value['collegeid'].'">Block => '.$value['block'].', Unit => '.$value['unit'].', Room Number => '.$value['roomnumber'].'</option>';
                                                            }
                                                        }

                                                        echo '</select>';
                                                    }
                                                ?>
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <label class="col-md-3 form-label"> Check In :</label>
                                            <div class="col-md-9">
                                                <input type="date" class="form-control" name="checkin" required>
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-4">
                                            <label class="col-md-3 form-label"> Check Out :</label>
                                            <div class="col-md-9">
                                                <input type="date" class="form-control" name="checkout" required>
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <label class="col-md-3 form-label"> Comment :</label>
                                            <div class="col-md-9">
                                                <textarea class="form-control" placeholder="Say Something..." name="remark"></textarea>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>

                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-9">
                                            <?php
                                                if($step == 1){
                                                    echo '<button type="submit" class="btn btn-primary">Next Step</button>';
                                                }else{
                                                    echo '<a style="margin-right: 1em;" href="student-college"><button type="button" class="btn btn-secondary">Reset</button></a>';
                                                    echo '<button type="submit" name="final_submit" class="btn btn-primary">Next Step</button>';
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
						
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

    if(isset($_POST['final_submit'])){
        $matricno  = $profile->matricno;
        $collegeid = $_POST['collegeid'];
        $checkin   = $_POST['checkin'];
        $checkout  = $_POST['checkout'];
        $remark    = $_POST['remark'];

        if($checkin > $checkout){
            ToastMessage('Error', 'Checkin date cannot be later than checkout', 'warning', 'student-college');
        }else{
            runQuery("INSERT INTO `notification` (`id`, `matricno`, `message`, `created_date`, `status`) VALUES (NULL, 'admin@admin.admin', 'New college application from $matricno <~> $collegeid', current_timestamp(), NULL)");

            runQuery("INSERT INTO `application`(`matricno`, `collegeid`, `checkin`, `checkout`, `remark`) VALUES ('$matricno','$collegeid','$checkin','$checkout','$remark')");

            ToastMessage('Success', "Your Application Has Been Submitted ! $matricno $collegeid $checkin $checkout $remark", 'success', 'student-dashboard');
        }
    }

    if($step == 2){
        $collegeUnit = fetchRows("SELECT * FROM college WHERE collegename = '".$_GET['1']."' AND roomstatus = '0'");

        if(empty($collegeUnit)){
            ToastMessage('Error', 'Sorry ! There Is No Room Available At This House !', 'warning', 'student-college');
        }
    }
?>
</html>