<?php?>
	<header class="page-header">
		<h1>Race Track 2000</h1>
	</header>

	<div class="row">
		<nav class="col-xs-6">
			<a href="admin.php">Admin</a>
			<a href="adminUsers.php">Users</a>
			<a href="adminHorses.php">Horses</a>
			<a href="#">Stats</a>
			<a href="../user/user.php">View as User</a>
		</nav>
		<div class="col-xs-6" style="text-align:right;">
			Hello <?= $user["username"] ?>!
		</div>
	</div>