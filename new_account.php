<?php
session_start();
require_once('user_class.php');

define("NAVIGATION", true);
define("ADMIN_PANEL", true);
define("MODAL", true);

$user = new USER();

  if($user->isLoggedIn() != ""){
    $user->redirectTo('index.php');
  }

if(isset($_POST['btn-signup']))
{
	$username = strip_tags($_POST['username']);
	$email = strip_tags($_POST['email']);
	$password = strip_tags($_POST['password']);
	$passwordRepeat = strip_tags($_POST['password-repeat']);


	if($username==""){
		$error[] = "Wprowadź nazwe użytkownika!";
	}
	else if($email=="")	{
		$error[] = "Wprowadź email!";
	}
	else if(!filter_var($email, FILTER_VALIDATE_EMAIL))	{ 
	    $error[] = "Wprowadzono niepoprawny email!";
	}
	else if($password=="")	{
		$error[] = "Wprowadź hasło!";
	}
	else if(strlen($password) < 6){
		$error[] = "Hasło musi zawierać minimum 6 znaków!";
	}
	else if($passwordRepeat=="")	{
		$error[] = "Wprowadź ponownie hasło!";
	}
	else if($passwordRepeat=="" && $password=="")	{
		$error[] = "Wprowadź hasło!";
	}
	else if($passwordRepeat=="" && $password!="" && $password > 6)	{
		$error[] = "Wprowadź hasło ponownie!";
	}
	else if($passwordRepeat!=$password)	{
		$error[] = "Podane hasła muszą być identyczne!";
	}
	else if(strlen($password) < 6){
		$error[] = "Hasło musi zawierać minimum 6 znaków!";
	}
	else
	{
		try
		{
			$stmt = $user->runQuery("SELECT user_name, user_email FROM users WHERE user_name=:username OR user_email=:email");
			$stmt->execute(array(':username'=>$username, ':email'=>$email));
			$row=$stmt->fetch(PDO::FETCH_ASSOC);

			if($row['user_name']==$username) {
				$error[] = "Przepraszamy, ale użytkownik o tej nazwie już istnieje!";
			}
			else if($row['user_email']==$email) {
				$error[] = "Przepraszamy, ale ten email jest zajęty!";
			}
			else
			{
				if($user->register($username,$email,$password)){
					$successMessage = "Twoje konto zostało założone! Możesz się teraz zalogować.";
				}
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
}

?>
<!DOCTYPE html>
<html lang="pl">

<head>

	<meta charset="utf-8">

	<title>Zarejestruj się - Katalog produktów</title>

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
						<h2>Załóż nowe konto</h2>
						<?php
							if(isset($error)){
								foreach($error as $error){
						?>
						<div class="alert alert-danger">
							<i class="fas fa-exclamation-triangle"></i> &nbsp; <?php echo $error; ?>
						</div>
						<?php
								}
							}
							else if(isset($successMessage)){
								echo "<div class=\"alert alert-success\">
										<i class=\"fas fa-check-circle\"></i>  &nbsp; $successMessage
									</div>";	
							}
						?>
						<div class="row">
							<div class="col-md-6 py-4">
								<form action="#" method='post'>
									<div class="form-group">
										<label for="login">Nazwa użytkownika:</label>
										<input type="text" class="form-control" id="login" name="username" required>
									</div>
									<div class="form-group">
										<label for="email">Adres email:</label>
										<input type="email" class="form-control" id="email" name="email" required>
									</div>
									<div class="form-group">
										<label for="pwd">Hasło:</label>
										<input type="password" class="form-control" id="pwd" name="password" required>
									</div>
									<div class="form-group">
										<label for="pwd-repeat">Powtórz hasło:</label>
										<input type="password" class="form-control" id="pwd-repeat" name="password-repeat" required>
									</div>
									<div class="form-check mb-3 mr-sm-2">
										<label class="form-check-label">
											<input class="form-check-input" type="checkbox" required> Akceptuję regulamin
										</label>
									</div>
									<div class="form-group">
										<button type="submit" class="btn btn-primary" name="btn-signup">Zarejestruj się</button>
									</div>
								</form>
							</div>
							<div class="col-md-6 text-center pt-5 d-none d-md-block">
								<i class="fas fa-user-plus" style="color: #007bff; font-size: 300px;"></i>
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