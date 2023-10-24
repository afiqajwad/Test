<!DOCTYPE html>
<html lang="en">

<head>
	<?php
        include 'header.php';
        include 'config.php';

        $profiledata = (object)[];
        $mode = (isset($_GET['id']) ? 'update' : 'create');

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
									<h5 class="card-title mb-0" style="text-transform: capitalize;"><?php echo ($mode);?> New Student</h5>
								</div>
								<div class="card-body">

                                    <form method="POST">
                                        <div class="row mb-4">
                                            <label class="col-md-3 form-label"> Matric Number :</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" placeholder="Matric Number" name="matricno" value="<?php echo $profiledata->matricno ?? ''; ?>" <?php echo ($mode == 'update' ? 'disabled' : '');?>>
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <label class="col-md-3 form-label">Name :</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" placeholder="Name" name="name" value="<?php echo $profiledata->name ?? ''; ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <label class="col-md-3 form-label">Phone :</label>
                                            <div class="col-md-9">
                                                <input type="tel" class="form-control" placeholder="Phone" name="phone" value="<?php echo $profiledata->phonenumber ?? ''; ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <label class="col-md-3 form-label">IC Number :</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" placeholder="IC Number" name="icno" value="<?php echo $profiledata->icno ?? ''; ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <label class="col-md-3 form-label">Password :</label>
                                            <div class="col-md-9">
                                                <input type="password" class="form-control" placeholder="Password" name="password" value="<?php echo $profiledata->password ?? ''; ?>">
                                            </div>
                                        </div>

                                        <a href="admin-resident">
                                            <button type="button" class="btn btn-secondary">Go Back</button>
                                        </a>

                                        <button type="submit" name="addstudent" class="btn btn-primary">
                                            <?php echo ($mode == 'update' ? 'Save Changes' : 'Add Student');?>
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

    if(isset($_POST['addstudent'])) {
        $matricno = $_POST['matricno'];
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $password = $_POST['password'];
        $icno = $_POST['icno'];
    
        $checkExist = fetchRow("SELECT * FROM student WHERE matricno = '$matricno'");

        if($mode == 'update'){
            $checkExist = null;
        }
    
        if(!empty($checkExist)){
            ToastMessage('Email already used', 'User Has Already Been Registered!', 'error', 'admin-resident');
        } else{
            if($mode == 'create'){
                runQuery("INSERT INTO `student`(`matricno`,`password`, `name`, `icno`, `phonenumber`) VALUES ('$matricno','$password','$name','$icno','$phone')");
            }

            if($mode == 'update'){
                runQuery("UPDATE `student` SET `password`='$password',`phonenumber`='$phone',`name`='$name',`icno`='$icno' WHERE matricno = '".$_GET['id']."'");
            }

            ToastMessage('Success', 'Record saved!', 'success', 'admin-resident');
        }
    }
?>
</html>