<!DOCTYPE html>
<html lang="en">

<head>
	<?php
        include 'header.php';
        include 'config.php';

        $profiledata = (object)[];
        $mode = (isset($_GET['id']) ? 'update' : 'create');

        if($mode == 'update'){
            $profiledata = fetchRow("SELECT * FROM `admin` WHERE userid = ".$_GET['id']);
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
									<h5 class="card-title mb-0" style="text-transform: capitalize;"><?php echo ($mode);?> New Admin</h5>
								</div>
								<div class="card-body">

                                    <form method="POST">
                                        <div class="row mb-4">
                                            <label class="col-md-3 form-label">Name :</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" placeholder="Name" name="name" value="<?php echo $profiledata->name ?? ''; ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <label class="col-md-3 form-label">Phone :</label>
                                            <div class="col-md-9">
                                                <input type="tel" class="form-control" placeholder="Phone" name="phone" value="<?php echo $profiledata->phone ?? ''; ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <label class="col-md-3 form-label">Email :</label>
                                            <div class="col-md-9">
                                                <input type="email" class="form-control" placeholder="Email" name="email" value="<?php echo $profiledata->email ?? ''; ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <label class="col-md-3 form-label">Password :</label>
                                            <div class="col-md-9">
                                                <div class="input-group mb-3">
                                                    <input id="password-toggle" data-hide="false" type="password" class="form-control" placeholder="Password" name="password" value="<?php echo $profiledata->password ?? ''; ?>">

                                                    <a href="#" class="input-group-text" onclick="showpass()">
                                                        <i class="align-middle" data-feather="eye"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <a href="admin-staff">
                                            <button type="button" class="btn btn-secondary">Go Back</button>
                                        </a>

                                        <button type="submit" name="addadmin" class="btn btn-primary">
                                            <?php echo ($mode == 'update' ? 'Save Changes' : 'Add Admin');?>
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
        function showpass(){
            let areaEl = document.querySelector(`#password-toggle`);
			let showFlag = areaEl.getAttribute('data-hide');

			if(showFlag == 'true'){
				areaEl.setAttribute('data-hide', 'false');
				areaEl.setAttribute('type', 'password');
			}

			if(showFlag == 'false'){
				areaEl.setAttribute('data-hide', 'true');
                areaEl.setAttribute('type', 'text');
			}
        }
    </script>
</body>

<?php
    if(!isset($_SESSION['admin'])){
		ToastMessage('Invalid credential', 'Please login first', 'error', 'admin-login');
	}

    if(isset($_POST['addadmin'])) {
        $userid = rand(99999, 999999);
        $email = $_POST['email'];
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $password = $_POST['password'];
    
        $checkExist = fetchRow("SELECT * FROM admin WHERE email = '$email'");

        if($mode == 'update'){
            $checkExist = null;
        }
    
        if(!empty($checkExist)){
            ToastMessage('Email already used', 'User Has Already Been Registered!', 'error', 'admin-staff');
        } else{
            if($mode == 'create'){
                runQuery("INSERT INTO `admin`(`userid`,`password`, `name`, `phone`, `email`) VALUES ('$userid','$password','$name','$phone','$email')");
            }

            if($mode == 'update'){
                runQuery("UPDATE `admin` SET `password`='$password',`phone`='$phone',`name`='$name',`email`='$email' WHERE userid =".$_GET['id']);
            }

            ToastMessage('Success', 'Record saved!', 'success', 'admin-staff');
        }
    }
?>
</html>