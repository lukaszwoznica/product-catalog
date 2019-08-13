<?php 
  if(!defined("NAVIGATION"))
    header('Location: ../index.php');
?>

<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
  <a class="navbar-brand" href="index.php">TwojeLogo</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="mainNavbar">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a href="index.php" class="nav-link">Strona główna</a>
      </li>
      <li class="nav-item dropdown">
        <a class="dropdown-toggle nav-link" data-toggle="dropdown" href="#">Produkty</a>
        <div class="dropdown-menu">
          <?php
              require_once("nav-select-categories.php");
              selectNavCategories($user);
            ?>
        </div>
      </li>
      <li class="nav-item"><a href="#" class="nav-link">O nas</a></li>
      <li class="nav-item"><a href="#" class="nav-link">Kontakt</a></li>
    </ul>
    <ul class="navbar-nav navbar-right">
      <li class="nav-item">
        <a href="login.php" class="nav-link"><i class="fas fa-sign-in-alt"></i> Zaloguj się</a>
      </li>
      <li class="nav-item">
        <a href="new_account.php" class="nav-link"><i class="fas fa-user"></i> Zarejestruj się</a>
      </li>
    </ul>
  </div>
</nav>