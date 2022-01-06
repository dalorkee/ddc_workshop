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
				$id = isset($_GET['id']) ? $_GET['id'] : die('Error: ไม่พบข้อมูล ID');
				include_once 'config_database.php';
				include_once 'users.php';
				
				// Instant database
				$database = new database();
				$db = $database->getConnection();

				$user = new users($db);
				$user->id = $id;
				$user->readOne();

				if ($_POST) {
					$user->firstname = $_POST['firstname'];
					$user->lastname = $_POST['lastname'];
					$user->email = $_POST['email'];
					$user->password = $_POST['password'];
					$user->user_role = $_POST['user_role'];
					
					if ($user->update()) {
						$_SESSION['msg'] = 'แก้ไขข้อมูล สำเร็จแล้ว';
					} else {
						$_SESSION['msg'] = 'ไม่สามารถแก้ไขข้อมูลได้';
					}
					header('Location: manage_user.php');
				}
			?>
			<form action="update_user.php?id=<?php echo $id; ?>" method="POST">
				<table class="table table-striped">
					<tr>
						<td>ชื่อ</td>
						<td><input type="text" name="firstname" value="<?php echo $user->firstname; ?>" class="form-control" require></td>
					</tr>
					<tr>
						<td>นามสกุล</td>
						<td><input type="text" name="lastname" value="<?php echo $user->lastname; ?>" class="form-control" require></td>
					</tr>
					<tr>
						<td>อีเมล์</td>
						<td><input type="email" name="email" value="<?php echo $user->email; ?>" class="form-control" require></td>
					</tr>
					<tr>
						<td>รหัสผ่าน</td>
						<td><input type="text" name="password" value="<?php echo $user->password; ?>" class="form-control" require></td>
					</tr>
					<tr>
						<td>บทบาทผู้ใช้</td>
						<td>
							<select name="user_role" class="form-control">
								<option value="<?php echo $user->user_role; ?>"><?php echo $user->user_role; ?></option>
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
	<script>
		const actions = [
  {
    name: 'Randomize',
    handler(chart) {
      chart.data.datasets.forEach(dataset => {
        dataset.data = Utils.numbers({count: chart.data.labels.length, min: -100, max: 100});
      });
      chart.update();
    }
  },
  {
    name: 'Add Dataset',
    handler(chart) {
      const data = chart.data;
      const dsColor = Utils.namedColor(chart.data.datasets.length);
      const newDataset = {
        label: 'Dataset ' + (data.datasets.length + 1),
        backgroundColor: Utils.transparentize(dsColor, 0.5),
        borderColor: dsColor,
        borderWidth: 1,
        data: Utils.numbers({count: data.labels.length, min: -100, max: 100}),
      };
      chart.data.datasets.push(newDataset);
      chart.update();
    }
  },
  {
    name: 'Add Data',
    handler(chart) {
      const data = chart.data;
      if (data.datasets.length > 0) {
        data.labels = Utils.months({count: data.labels.length + 1});

        for (let index = 0; index < data.datasets.length; ++index) {
          data.datasets[index].data.push(Utils.rand(-100, 100));
        }

        chart.update();
      }
    }
  },
  {
    name: 'Remove Dataset',
    handler(chart) {
      chart.data.datasets.pop();
      chart.update();
    }
  },
  {
    name: 'Remove Data',
    handler(chart) {
      chart.data.labels.splice(-1, 1); // remove the label first

      chart.data.datasets.forEach(dataset => {
        dataset.data.pop();
      });

      chart.update();
    }
  }
];

const DATA_COUNT = 7;
const NUMBER_CFG = {count: DATA_COUNT, min: -100, max: 100};

const labels = Utils.months({count: 7});
const data = {
  labels: labels,
  datasets: [
    {
      label: 'Dataset 1',
      data: Utils.numbers(NUMBER_CFG),
      borderColor: Utils.CHART_COLORS.red,
      backgroundColor: Utils.transparentize(Utils.CHART_COLORS.red, 0.5),
    },
    {
      label: 'Dataset 2',
      data: Utils.numbers(NUMBER_CFG),
      borderColor: Utils.CHART_COLORS.blue,
      backgroundColor: Utils.transparentize(Utils.CHART_COLORS.blue, 0.5),
    }
  ]
};

const config = {
  type: 'bar',
  data: data,
  options: {
    responsive: true,
    plugins: {
      legend: {
        position: 'top',
      },
      title: {
        display: true,
        text: 'Chart.js Bar Chart'
      }
    }
  },
};


module.exports = {
  actions: actions,
  config: config,
};
	</script>
</body>
</html>