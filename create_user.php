<?php session_start(); ?>
<!DOCTYPE html>
<html lang="th">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Home</title>
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
	<style type="text/css">
		.container-fluid {
			margin: 0;
			padding: 0;
		}
		.header {
			width: 100%;
			/* height: 100px; */
			padding: 0;
			/* background-color: #5289b5; */
			border-bottom: 2px solid #bbbbbb;
		}
		.main-nav {
			width: 16%;
			padding: 40px 0 0 10px;
			background-color: #f4f4f4;
			min-height: calc(100vh - 136px);
			float: left;
		}
		.content {
			width: 84%;
			/* background-color: pink; */
			float: left;
			padding: 10px 20px;
		}
		.content:after {
			content: "";
			display: block;
			clear: both;
		}
		.footer {
			position: fixed;
			height: 60px;
			bottom: 0;
			width: 100%;
			background-color: #0088ff;
		}
		.footer-text {
			display: table;
			text-align: center;
			margin: auto;
		}
	</style>
</head>
<body>
	<div class="container-fluid">
		<!-- header -->
		<div class="header">
			<nav class="navbar navbar-expand-lg navbar-light bg-light">
				<a class="navbar-brand" href="#">
					<img src="small-moph-logo.png" width="40" height="40" class="d-inline-block align-top">
					My Apps
				</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>

				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav mr-auto">
						<li class="nav-item">
							<a class="nav-link" href="#">Link</a>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
							Dropdown
							</a>
							<div class="dropdown-menu" aria-labelledby="navbarDropdown">
							<a class="dropdown-item" href="#">Action</a>
							<a class="dropdown-item" href="#">Another action</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="#">Something else here</a>
							</div>
						</li>
					</ul>
					<form class="form-inline my-2 my-lg-0">
						<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
						<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
					</form>
				</div>
			</nav>
		</div>

		<!-- navigation -->
		<div class="main-nav">
			<ul class="nav flex-column">
				<li class="nav-item">
					<a class="nav-link active" href="index.php"><i class="fas fa-home"></i> หน้าแรก</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="dashboard.php"><i class="fas fa-tachometer-alt"></i> แดชบอร์ด</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="manage_user.php"><i class="fas fa-users-cog"></i> จัดการผู้ใช้</a>
				</li>
			</ul>
		</div>
		<!-- contents -->
		<div class="content">
			<?php
				include_once 'config_database.php';
				include_once 'users.php';
				
				// Instant database
				$database = new database();
				$db = $database->getConnection();

				if ($_POST) {
					$user = new users($db);
					$user->firstname = $_POST['firstname'];
					$user->lastname = $_POST['lastname'];
					$user->email = $_POST['email'];
					$user->password = $_POST['password'];
					$user->user_role = $_POST['user_role'];
					
					if ($user->create()) {
						$_SESSION['msg'] = 'สร้างผู้ใช้ใหม่ สำเร็จแล้ว';
					} else {
						$_SESSION['msg'] = 'ไม่สามารถสร้างผู้ใช้ได้';
					}
					header('Location: manage_user.php');
				}
			?>
			<form action="create_user.php" method="POST">
				<table class="table table-striped">
					<tr>
						<td>ชื่อ</td>
						<td><input type="text" name="firstname" class="form-control" require></td>
					</tr>
					<tr>
						<td>นามสกุล</td>
						<td><input type="text" name="lastname" class="form-control" require></td>
					</tr>
					<tr>
						<td>อีเมล์</td>
						<td><input type="email" name="email" class="form-control" require></td>
					</tr>
					<tr>
						<td>รหัสผ่าน</td>
						<td><input type="password" name="password" class="form-control" require></td>
					</tr>
					<tr>
						<td>บทบาทผู้ใช้</td>
						<td>
							<select name="user_role" class="form-control">
								<option value="">-- โปรดเลือก --</option>
								<option value="admin">Admin</option>
								<option value="user">User</option>
								<option value="guest">Guest</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>จัดการ</td>
						<td><button type="submit" class="btn btn-success">บันทึกข้อมูล</button></td>
					</tr>
				</table>

			</form>

		</div>
		<!-- footer -->
		<div class="footer pt-2">
			<p class="footer-text">Copyright 2021 myapps.org</p>
		</div>
	</div>
	<!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
	<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>