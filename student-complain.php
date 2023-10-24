<!DOCTYPE html>
<html lang="en">

<head>
	<?php
        include 'header.php';
        include 'config.php';

        $profile = ($_SESSION['student'] ?? null);

        $checkHasCollege = fetchRow("SELECT * FROM `application` WHERE `status` = 1 AND `matricno` = '".$profile->matricno."'");
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

					<form method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-7 offset-3">

                                <!-- Card Start -->
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-title">Report House Defect</div>
                                    </div>

                                    <div class="card-body">
                                        <?php
                                            if($checkHasCollege){
                                                echo '
                                                <div class="row mb-4">
                                                    <label class="col-md-2 form-label">Picture</label>
                                                    <div class="col-md-10">
                                                        <input required type="file" class="form-control" placeholder="Support Picture" name="fileToUpload">
                                                    </div>
                                                </div>
        
                                                <div class="row mb-4">
                                                    <label class="col-md-2 form-label">Description</label>
                                                    <div class="col-md-10">
                                                        <textarea maxlength="200" required class="form-control" placeholder="Description" name="description"></textarea>
                                                    </div>
                                                </div>';
                                            }else{
                                                echo '
                                                <div class="border border-success alert p-3 alert" role="alert">
                                                    You dont have college registered yet. Click <a href="./student-college">here</a> to apply your college
                                                </div>';
                                            }
                                        ?>
                                    </div>

                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-md-2"></div>
                                            <div class="col-md-10">
                                                <button type="submit" name="submit_report" class="btn btn-primary" <?php echo ($checkHasCollege ? '' : 'disabled'); ?>>Submit Report</button>
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

    if(isset($_POST['submit_report'])){
        $matricno = ($profile->matricno ?? null);
        $imagename = '';
        $description = ($_POST['description']);

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
        }

        runQuery("INSERT INTO `helpdesk` (`helpdeskid`, `matricno`, `comment`, `status`, `picture`) VALUES (NULL, '$matricno', '$description', '0', '$imagename');");

        ToastMessage('Successfully', 'Report Submitted', 'success', 'student-dashboard');
    }
?>
</html>