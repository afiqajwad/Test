<!DOCTYPE html>
<html lang="en">

<head>
	<?php
        include 'header.php';
        include 'config.php';

        $Auth = ($_SESSION['student'] ?? null);
        $profile = fetchRow("SELECT * FROM `student` WHERE `matricno` = '".$Auth->matricno."'");

        if($profile){
            $profile = json_decode(json_encode($profile), false);
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

					<form method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-7 offset-3">

                                <!-- Card Start -->
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-title">Update Profile</div>
                                    </div>

                                    <div class="card-body">
                                        <div class="row mb-4">
                                            <label class="col-md-2 form-label"> Profile Picture</label>

                                            <div class="col-md-10">
                                                <input type="file" class="form-control" name="fileToUpload">
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <label class="col-md-2 form-label"> Name</label>
                                            <div class="col-md-10">
                                                <input type="text" class="form-control" placeholder="Name" name="name" value="<?php echo ($profile->name ?? ''); ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <label class="col-md-2 form-label">Phone</label>
                                            <div class="col-md-10">
                                                <input type="tel" class="form-control" placeholder="Phone" name="phone" value="<?php echo ($profile->phonenumber ?? ''); ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <label class="col-md-2 form-label">Email</label>
                                            <div class="col-md-10">
                                                <input type="email" class="form-control" placeholder="Email" name="email" value="<?php echo ($profile->email ?? ''); ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <label class="col-md-2 form-label">Password</label>
                                            <div class="col-md-10">
                                                <input type="password" class="form-control" placeholder="Password" name="password" value="<?php echo ($profile->password ?? ''); ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <label class="col-md-2 form-label"> IC Number</label>
                                            <div class="col-md-10">
                                                <input type="text" class="form-control" placeholder="IC Number" name="icno" value="<?php echo ($profile->icno ?? ''); ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <label class="col-md-2 form-label">Program</label>
                                            <div class="col-md-10">
                                                <input type="text" class="form-control" placeholder="Program ( Optional )" name="program" value="<?php echo ($profile->program ?? ''); ?>">
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <label class="col-md-2 form-label">Studies Level</label>
                                            <div class="col-md-10">
                                                <input type="text" class="form-control" placeholder="Studies Level ( Optional )" name="studieslevel" value="<?php echo ($profile->studieslevel ?? ''); ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <label class="col-md-2 form-label">Faculty</label>
                                            <div class="col-md-10">
                                                <input type="text" class="form-control" placeholder="Faculty ( Optional )" name="faculty" value="<?php echo ($profile->faculty ?? ''); ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-md-2"></div>
                                            <div class="col-md-10">
                                                <button type="submit" name="update_student_profile" class="btn btn-primary">Update Profile</button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- Card End -->

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

    if(isset($_POST['update_student_profile'])){
        $matricno = ($profile->matricno ?? null);
        $password = ($_POST['password']);
        $name     = ($_POST['name']);
        $phone    = ($_POST['phone']);
        $email    = ($_POST['email']);
        $icno     = ($_POST['icno']);
        $program  = ($_POST['program']);
        $sutdieslevel = ($_POST['studieslevel']);
        $faculty = ($_POST['faculty']);

        if(isset($_FILES["fileToUpload"]) && !empty($_FILES["fileToUpload"]["size"])){
            $target_dir = "img/photos/";
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);

            if(!$check) {
                echo "File is not an image."; exit;
            }

            if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)){
                // echo "The file ". htmlspecialchars( basename($_FILES["fileToUpload"]["name"])). " has been uploaded.";
            }else{
                echo "Sorry, there was an error uploading your file.";
            }

            $imagename = $_FILES["fileToUpload"]["name"];

            runQuery("UPDATE `student` SET `profile_picture`='$imagename' WHERE `matricno`='$matricno'");
        }

        runQuery("UPDATE `student` SET `password`='$password',`name`='$name',`icno`='$icno',`phonenumber`='$phone',`email`='$email',`program`='$program',`studieslevel`='$sutdieslevel',`faculty`='$faculty' WHERE `matricno`='$matricno'");

        ToastMessage('Successfully', 'Profile Updated', 'success', 'student-profile');
    }
?>
</html>