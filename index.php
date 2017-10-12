<?php
// Start Session
session_start();

//Submit Bookmark
if ((isset($_POST['action'])) && ($_POST['action'] == 'Submit')) {
	if((isset($_POST['name'])) && ($_POST['name'] != '')) {
		if(isset($_SESSION['bookmarks'])){
			$_SESSION['bookmarks'][$_POST['name']] = $_POST['url'];
		} else {
			$_SESSION['bookmarks'] =  Array($_POST['name'] => $_POST['url']);
		}
	}
//Delete Individual Bookmarks
} elseif ((isset($_GET['action'])) && ($_GET['action'] == 'delete')) {
	unset($_SESSION['bookmarks'][$_GET['name']]);
	if (empty($_SESSION['bookmarks'])) {
		session_destroy();
	}
	header("Location: index.php");
//Clear All Bookmarks
} elseif ((isset($_GET['action'])) && ($_GET['action'] == 'clear')) {
	session_unset();
	session_destroy();
	header("Location: index.php");
}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Bookmarker</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<style>
		</style>
	</head>
	<body>
		<nav class="navbar navbar-default">
			<div class="container">
		  	<div class="navbar-header">
		      <a class="navbar-brand" href="#">Bookmarker</a>
		    </div>
		  </div>
		</nav>

		<div class="container">
			<div class="row">
				<div class="col-md-7">
					<form class="well" method="POST" action="<?php $_SERVER['PHP_SELF']; ?>" style="text-align:center;">
						<div class="form-group">
							<label>Website Name: </label>
							<input class="form-control" type="text" name="name">
						</div>
						<div class="form-group">
							<label>Website URL: </label>
							<input class="form-control" type="text" name="url">
						</div>
						<div class="btn-group btn-group" role="group">
							<a class="btn btn-primary" name="action" href="index.php?action=clear">Clear All</a>
							<input class="btn btn-primary" name="action" type="submit" value="Submit">
						</div>
					</form>
				</div>
				<div class="col-md-5">
					<?php if(isset($_SESSION['bookmarks'])) { ?>
						<ul class="list-group">
							<?php foreach($_SESSION['bookmarks'] as $name => $url) { ?>
								<li class="list-group-item">
									<a href="<?php echo $url; ?>"><?php echo $name; ?></a>
									<a class="delete pull-right" href="index.php?action=delete&name=<?php echo $name; ?>">[X]</a>
								</li>
							<?php } ?>
						</ul>
					<?php } else { ?>
						<p>No Bookmarks</p>
					<?php } ?>
				</div>
			</div>
		</div>
	</body>
</html>
