<!DOCTYPE html>
<html lang="en">

<head>
	<?php
        include 'header.php';
        include 'config.php';
    ?>

	<style>
		main{
			background: url('img/photos/login_background.jpeg');
			background-repeat: no-repeat;
			background-size: cover;
		}
	</style>
</head>

<body>
	<main class="d-flex w-100">
		<div class="container d-flex flex-column">
			<div class="row vh-100">
				<div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
					<div class="d-table-cell align-middle">

						<div class="card">
							<div class="card-body">
								<div class="m-sm-4">
									<div class="text-center"><h1 class="mb-4">Admin Login</h1></div>
									<div class="text-center"><img src="img/photos/admin_vector.jpeg" height="250"/></div>
									<form method="POST">
										<div class="mb-3">
											<label class="form-label">Username</label>
											<input class="form-control form-control-lg" type="text" name="metric" placeholder="Enter email"/>
										</div>
										<div class="mb-3">
											<label class="form-label">Password</label>
											<input class="form-control form-control-lg" type="password" name="password" placeholder="Enter password" />
										</div>
										<div class="text-center mt-3">
											<button type="submit" name="login_admin" class="btn btn-lg btn-primary">Login</button>

                                            <div class="text-center pt-3">
                                                <p class="text-dark mb-0">Trying To Login As Student ?<a href="./student-login" class="text-primary ms-1">Click Here !</a></p>
                                            </div>
										</div>
									</form>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</main>
</body>

<?php
    if(isset($_POST['login_admin'])){
        $email = $_POST['metric'];
        $password = $_POST['password'];
        $checkCredential = fetchRow("SELECT * FROM `admin` WHERE `password` = '$password' AND `email` = '$email'");

        if(!empty($checkCredential)){
			$_SESSION['admin'] = (object) $checkCredential;

			unset($_SESSION['student']);
			
            ToastMessage('Success', 'login successful', 'success', 'admin-dashboard');
        }else{
			ToastMessage('Invalid Credential', 'Invalid login credential, please try again', 'error', 'admin-login');
		}
    }
?>
</html>
