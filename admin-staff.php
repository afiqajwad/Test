<!DOCTYPE html>
<html lang="en">

<head>
	<?php
        include 'header.php';
        include 'config.php';

        $profile = ($_SESSION['admin'] ?? null);
		$staffArray = fetchRows("SELECT * FROM admin");

		if(isset($_SESSION['admin']) && $_SESSION['admin']->email != 'admin@admin.admin'){
			header("Location: admin-my-resident.php");exit;
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
									<h5 class="card-title mb-0">Management Staff List</h5>
								</div>
								<div class="card-body">
								
                                    <a href="#" class="btn btn-primary mb-4" onClick="window.print()">Print</a>

									<table class="table table-bordered my-0">
										<thead>
											<tr>
												<th>Name</th>
												<th>Email</th>
												<th>Phone Number</th>
												<th>Password</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											<?php
												if(!empty($staffArray)){
													foreach($staffArray as $key => $value){
														$isSuperAdmin = ($value['email'] == 'admin@admin.admin' ? 'disabled' : '');
														$actionButton = '
															<a href="admin-staff-create?id='.$value['userid'].'" class="btn btn-success">Edit</a>
															<a href="admin-staff-delete?id='.$value['userid'].'" class="btn btn-danger">Delete</a>';

														if($isSuperAdmin){
															$actionButton = '<span class="badge bg-success">Main Admin Is Not Editable</span>';
														}

														echo '
															<tr>
																<td>'.$value['name'].'</td>
																<td>'.$value['email'].'</td>
																<td>'.$value['phone'].'</td>
																<td class="password-hidden">'.$value['password'].'</td>
																<td>'.$actionButton.'</td>
															</tr>
														';
													}
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
		let passwordEl = document.querySelectorAll('.password-hidden');

		[...passwordEl].forEach(function(e){
			let totalstars = '';
			let original = e.innerText;
			let randomID = Math.random().toString(36).substr(8, 8);

			e.innerHTML = `
				<div class="d-flex gap-3 align-items-center">
					<span class="flex-1" id="${ randomID }" data-hide="true">********</span>
					<a href="#" onclick="showpass('${ original }', '${ randomID }')">
						<i class="align-middle" data-feather="eye"></i>
					</a>
				</div>
			`;
		});

		function showpass(pass, selector){
			let areaEl = document.querySelector(`#${ selector }`);
			let showFlag = areaEl.getAttribute('data-hide');

			if(showFlag == 'true'){
				areaEl.innerHTML = pass;
				areaEl.setAttribute('data-hide', 'false');
			}

			if(showFlag == 'false'){
				areaEl.innerHTML = '********';
				areaEl.setAttribute('data-hide', 'true');
			}
		}
    </script>
</body>

<?php
    if(!isset($_SESSION['admin'])){
		ToastMessage('Invalid credential', 'Please login first', 'error', 'admin-login');
	}

	if(isset($_GET['delete'])){
		ToastMessage('Success', 'Admin deleted!', 'success', 'admin-staff');
	}
?>
</html>