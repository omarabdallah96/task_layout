<?php
//start session
session_start();

//redirect if logged in
if (isset($_SESSION['user'])) {
	header('location:home.php');
}
?>
<!DOCTYPE html>
<html>

<head>
	<title>Login</title>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
	<div class="container">
		<br>
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<div class="login-panel panel panel-primary">

					<div class="panel-body">
						<h3>
							Login
						</h3>
						<form method="POST" action="login.php">
							<fieldset>
								<div class="form-group">
									<input class="form-control" placeholder="Username" type="text" name="username" autofocus required>
								</div>
								<div class="form-group">
									<input class="form-control" placeholder="Password" type="password" name="password" required>
								</div>
								<button type="submit" name="login" class="btn btn-lg btn-primary btn-block">Login</button>
							</fieldset>
						</form>
					</div>
				</div>
				<?php
				if (isset($_SESSION['message'])) {
				?>
					<div class="alert alert-danger text-center">
						<?php echo $_SESSION['message']; ?>
					</div>
				<?php

					unset($_SESSION['message']);
				}
				?>
			</div>
		</div>
	</div>
</body>

</html>