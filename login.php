<?php 
  session_start();

  require_once("user_class.php");

  define("NAVIGATION", true);
  define("ADMIN_PANEL", true);
  define("MODAL", true);

  $user = new User();

  if($user->isLoggedIn() != ""){
    $user->redirectTo('index.php');
  }

  if (isset($_POST['login-btn'])) {
    $username = strip_tags($_POST['login']);
  	$password = strip_tags($_POST['passwd']);

    if($user->logIn($username, $password))	{
	  	$user->redirectTo('index.php');
	  }
    else{
      $error = "<span style='color: red;'>Niepoprawny login lub/i hasło!</span>";
    }
  }

?>

<!DOCTYPE html>
<html lang="pl">

<head>

	<meta charset="utf-8">

	<title>Zaloguj się - Katalog produktów</title>

	<meta name="description" content="Internetowy katalog produktów">
	<meta name="keywords" content="katalog, produkty, online">

	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="X-Ua-Compatible" content="IE=edge,chrome=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="style.css">
	<!--[if lt IE 9]>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
	<![endif]-->
	<script defer src="https://use.fontawesome.com/releases/v5.8.1/js/all.js"
        integrity="sha384-g5uSoOSBd7KkhAMlnQILrecXvzst9TdC09/VM+pjDTCM+1il8RHz5fKANTFFb+gQ" crossorigin="anonymous">
	</script>
	<script src="js/sticky-nav.js"></script>
</head>

<body>
	<div class="wrapper">
		<div class="main-page">
			<header>
				<div class="jumbotron text-center">
					<h1>Katalog Produktów</h1>
				</div>
			</header>

			<?php
				require_once('navigations/basic_nav.php');
			?>

			<main>
				<div class="main-content">
					<div class="container">
						<h2>Zaloguj się</h2>
						<div class="row">
							<div class="col-md-6 pt-4">
								<form method='post'>
									<?php
									if(isset($error)){
									echo $error;
									}	
									?>

									<div class="form-group">
										<label for="email">Login:</label>
										<input type="text" class="form-control" name="login" id="login" required>
									</div>
									<div class="form-group">
										<label for="passwd">Hasło:</label>
										<input type="password" class="form-control" name="passwd" id="passwd" required>
									</div>

									<button type="submit" class="btn btn-primary" name="login-btn">Zaloguj</button>

								</form>
							</div>
							<div class="col-md-6 text-center">
								<i class="fas fa-user" style="color: #007bff; font-size: 300px;"></i>
							</div>
						</div>
					</div>
				</div>
			</main>


			<footer>
                <div class="footer text-center">
                    <div class="footer-social">
                        <a href="#"><i class="footer-social-icon fab fa-facebook-square"></i></a>
                        <a href="#"><i class="footer-social-icon fab fa-instagram"></i></a>
                        <a href="#"><i class="footer-social-icon fab fa-twitter-square"></i></a>
                        <a href="#"><i class="footer-social-icon fab fa-youtube-square"></i></a>
                    </div>
                </div>
            </footer>
		</div>
	</div>
</body>

</html>