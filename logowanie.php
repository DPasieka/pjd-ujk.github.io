<?php

	session_start();
	
	if ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))
	{
		header('Location: pulpit.php');
		exit();
	}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>PJD</title>
   <link rel="stylesheet" href="css/style.css">
   <link rel="shortcut icon" href="img/pjd.png">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
      integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
   <link rel="stylesheet" href="unslider/unslider-dots.css">
   <link rel="stylesheet" href="unslider/unslider.css">
   <script src="scripts/jquery-3.0.0.min.js"></script>
   <script src="scripts/unslider-min.js"></script>
   <script src="scripts/script.js"></script>
</head>
<!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
   integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
   integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
   integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<body>
   <!-- Kuba: Start -->
   <nav class="navbar navbar-light navbar-expand-md bg-faded justify-content-center">
      <a href="/" class="navbar-brand d-flex w-50 mr-auto"><b> UJK</b></a>
      <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#collapsingNavbar3">
         <span class="toggler-icon top-bar"></span>
        <span class="toggler-icon middle-bar"></span>
        <span class="toggler-icon bottom-bar"></span>
      </button>
      <div class="navbar-collapse collapse w-100" id="collapsingNavbar3">
         <ul class="navbar-nav w-100 justify-content-center">
            <li class="nav-item active">
               <a class="nav-link click" onclick="scroolHome()">Home</a>
            </li>
            <li class="nav-item">
               <a class="nav-link click" onclick="scroolWydarzenia()">Produkt</a>
            </li>
            <li class="nav-item">
               <a class="nav-link click" onclick="scroolCeny()">Ceny</a>
            </li>
            <li class="nav-item">
               <a class="nav-link click" onclick="scroolKontakt()">Kontakt</a>
            </li>
         </ul>
         <ul class="nav navbar-nav ml-auto w-100 justify-content-end">
            <li class="nav-item">
               <a class="nav-link" href="logowanie.html">login</a>
            </li>
            <li class="nav-item">
               <button class="bdola">Dolacz do nas ➡</button>
            </li>
         </ul>
      </div>
   </nav>
   <!-- Kuba: End -->
   <div class="form-box">
      <h1 class="form-box__title">Panel logowania</h1>
        <p class="form-box__info">Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptate ducimus enim consequatur ullam ab 
         accusamus repellat quod autem totam dolores! Dicta autem, fugiat delectus quo provident nam officia maxime doloribus!</p>
        <form class="form-box__form form" action="zaloguj.php" method="post">
          <input class="form__text-input" type="text" name="login" id="e-mail" placeholder="Podaj login">
          <input class="form__text-input" type="password" name="haslo" id="password" placeholder="Podaj hasło">
         <?php
          if(isset($_SESSION['blad']))	echo $_SESSION['blad'];
          unset($_SESSION['blad']);
         ?>
          <button class="form__button" type="submit">Zaloguj się</button>
    
         <p class="form-box__info"><a href="register.php">Utwórz nowe konto</a></p>
        </form>
    </div>
   <!-- Karina: Start -->
   <div class="stopka">
      <div class="flex-container">
      <div class="lista">
          <h5 class="naglowek">Company info</h5>
          <dl class="lista-stopka">
              <dt><a class="link" href="" target="_self">about us</a></dt>
              <dt><a class="link" href="" target="_self">carrier</a></dt>
              <dt><a class="link" href="" target="_self">about us</a></dt>
              <dt><a class="link" href="" target="_self">carrier</a></dt>
          </dl>
      </div>
      <div class="lista">
          <h5 class="naglowek">Legal</h5>
          <dl class="lista-stopka">
              <dt><a class="link" href="" target="_self">about us</a></dt>
              <dt><a class="link" href="" target="_self">carrier</a></dt>
              <dt><a class="link" href="" target="_self">about us</a></dt>
              <dt><a class="link" href="" target="_self">carrier</a></dt>
          </dl>
      </div>
      <div class="lista">
          <h5 class="naglowek">Features</h5>
          <dl class="lista-stopka">
              <dt><a class="link" href="" target="_self">business</a></dt>
              <dt><a class="link" href="" target="_self">unlimited support</a></dt>
              <dt><a class="link" href="" target="_self">business</a></dt>
              <dt><a class="link" href="" target="_self">unlimited support</a></dt>
          </dl>
      </div>
      <div class="lista">
          <h5 class="naglowek">Resources</h5>
          <dl class="lista-stopka">
              <dt><a class="link" href="" target="_self">watch demo</a></dt>
              <dt><a class="link" href="" target="_self">customers</a></dt>
              <dt><a class="link" href="" target="_self">watch demo</a></dt>
              <dt><a class="link" href="" target="_self">customers</a></dt>
          </dl>
      </div>
      <div class="lista">
          <h5 class="naglowek">Get in Touch</h5>
          <dl class="lista-stopka">
              <dt><a class="link" href="" target="_self">jakis numer telefonu</a></dt>
              <dt><a class="link" href="" target="_self">jakis adres</a></dt>
              <dt><a class="link" href="" target="_self">jakis numer telefonu</a></dt>
              <dt><a class="link" href="" target="_self">jakis adres</a></dt>
          </dl>
      </div>
   </div>
  </div>
  
  <!-- Karina: End -->
  <button onclick="topFunction()" id="myBtn" title="Go to top">Top</button>
</body>

</html>