<!DOCTYPE html>
<html lang="en">

<head>
	<?php
        include 'header.php';
        include 'config.php';

        $profiledata = (object)[];
        $mode = (isset($_GET['id']) ? 'update' : 'create');
        $staffArray = fetchRows("SELECT * FROM `admin` WHERE `admin`.`email` != 'admin@admin.admin'");

        if($mode == 'update'){
            $profiledata = fetchRow("SELECT * FROM `student` WHERE matricno = '".$_GET['id']."'");
            $profiledata = json_decode(json_encode($profiledata),false);
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
									<h5 class="card-title mb-0" style="text-transform: capitalize;"><?php echo ($mode);?> New College</h5>
								</div>
								<div class="card-body">

                                    <form method="POST">
                                        <div class="row mb-4">
                                            <label class="col-md-3 form-label">House Name :</label>
                                            <div class="col-md-9">
                                                <select required class="form-control" name="collegename" >
                                                    <option value="Crystal View">Crystal View</option>
                                                    <option value="Suria Jaya">Suria Jaya</option>
                                                    <option value="Baiduri">Baiduri</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <label class="col-md-3 form-label">Block :</label>
                                            <div class="col-md-9">
                                                <input required type="text" class="form-control" placeholder="Block" name="block">
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <label class="col-md-3 form-label">Unit :</label>
                                            <div class="col-md-9">
                                                <input required type="text" class="form-control" placeholder="Unit" name="unit">
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <label class="col-md-3 form-label">Room Number :</label>
                                            <div class="col-md-9">
                                                <input required type="number" class="form-control" placeholder="Room Number" name="roomnumber">
                                            </div>
                                        </div>

                                        <!-- <div class="row mb-4">
                                            <label class="col-md-3 form-label">Room Capacity :</label>
                                            <div class="col-md-9">
                                                <input required type="number" class="form-control" placeholder="Room Capacity" name="roomcapacity" value="1">
                                            </div>
                                        </div> -->

                                        <div class="row mb-4">
                                            <label class="col-md-3 form-label">Manager</label>
                                            <div class="col-md-9">
                                                <select required class="form-control" name="collegemanager">
                                                    <?php
                                                        echo '<option value="">-- Nothing Selected --</option>';
                                                        
                                                        if(!empty($staffArray)){
                                                            foreach($staffArray as $key => $value){
                                                                echo '<option value="'.$value['userid'].'">'.$value['email'].'</option>';
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <a href="admin-college">
                                            <button type="button" class="btn btn-secondary">Go Back</button>
                                        </a>

                                        <button type="submit" name="addcollege" class="btn btn-primary">
                                            <?php echo ($mode == 'update' ? 'Save Changes' : 'Add College');?>
                                        </button>
                                    </form>

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

    if(isset($_POST['addcollege'])) {
        $collegename = $_POST['collegename'];
        $block = $_POST['block'];
        $unit = $_POST['unit'];
        $roomnumber = $_POST['roomnumber'];
        $roomcapacity = ($_POST['roomcapacity'] ?? 1);
        $collegemanager = $_POST['collegemanager'];

        runQuery("INSERT INTO `college` (`collegename`,`block`, `unit`, `roomnumber`, `capacity`, `manager`) VALUES ('$collegename','$block','$unit','$roomnumber', $roomcapacity, $collegemanager)");

        ToastMessage('Success', 'College Listing Has Successfully Been Registered', 'success', 'admin-college');
    }
?>
</html>