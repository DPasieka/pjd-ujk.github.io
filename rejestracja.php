<?php

	session_start();
	
	if (isset($_POST['email']))
	{
		$wszystko_OK=true;
		
		$username = $_POST['username'];
		
		if ((strlen($username)<3) || (strlen($username)>20))
		{
			$wszystko_OK=false;
			$_SESSION['e_username']="Nazwa użytkownika musi mieć od 3 do 20 znaków!";
		}
		
		if (ctype_alnum($username)==false)
		{
			$wszystko_OK=false;
			$_SESSION['e_username']="Nazwa użytkownika może składać się tylko z litra i cyfr (bez polskich znaków)";
		}
		
		$email = $_POST['email'];
		$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
		
		if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
		{
			$wszystko_OK=false;
			$_SESSION['e_email']="Proszę wpisać wlasciwy adres e-mail!";
		}
		
		$haslo1 = $_POST['haslo1'];
		$haslo2 = $_POST['haslo2'];
		
		if ((strlen($haslo1)<8) || (strlen($haslo1)>20))
		{
			$wszystko_OK=false;
			$_SESSION['e_haslo']="Hasło musi mieć od 8 do 20 znaków!";
		}
		
		if ($haslo1!=$haslo2)
		{
			$wszystko_OK=false;
			$_SESSION['e_haslo']="Hasła są różne!";
		}	
		
		if (!isset($_POST['regulamin']))
		{
			$wszystko_OK=false;
			$_SESSION['e_regulamin']="Potwierdź akceptację regulaminu!";
		}				
		
		$sekret = "google captcha";
		
		$sprawdz = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$sekret.'&response='.$_POST['g-recaptcha-response']);
		
		$odpowiedz = json_decode($sprawdz);
		
		if ($odpowiedz->success==false)
		{
			$wszystko_OK=false;
			$_SESSION['e_bot']="Potwierdź, że nie jesteś botem!";
		}		
		
		$_SESSION['fr_username'] = $username;
		$_SESSION['fr_email'] = $email;
		$_SESSION['fr_haslo1'] = $haslo1;
		$_SESSION['fr_haslo2'] = $haslo2;
		if (isset($_POST['regulamin'])) $_SESSION['fr_regulamin'] = true;
		
		require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		try 
		{
			$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
			if ($polaczenie->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				$rezultat = $polaczenie->query("SELECT id FROM uzytkownicy WHERE email='$email'");
				
				if (!$rezultat) throw new Exception($polaczenie->error);
				
				$ile_takich_maili = $rezultat->num_rows;
				if($ile_takich_maili>0)
				{
					$wszystko_OK=false;
					$_SESSION['e_email']="Do tego adresu e-mail jest już przypisane konto!";
				}		

				$rezultat = $polaczenie->query("SELECT id FROM uzytkownicy WHERE user='$username'");
				
				if (!$rezultat) throw new Exception($polaczenie->error);
				
				$ile_takich_usernameow = $rezultat->num_rows;
				if($ile_takich_usernameow>0)
				{
					$wszystko_OK=false;
					$_SESSION['e_username']="Użytkownik o tej nazwie już istnieje! Wybierz inną..";
				}
				
				if ($wszystko_OK==true)
				{
					
					if ($polaczenie->query("INSERT INTO uzytkownicy VALUES (NULL,  '$username',  '$haslo1',  '$email' )"))
					{
						$_SESSION['udanarejestracja']=true;
						$_SESSION['zalogowany']=true;
						
						$login = htmlentities($_SESSION['fr_username'], ENT_QUOTES, "UTF-8");
						$haslo = htmlentities($_SESSION['fr_haslo1'], ENT_QUOTES, "UTF-8");
					
						if ($rezultat = @$polaczenie->query(
						sprintf("SELECT * FROM uzytkownicy WHERE BINARY user='%s' AND BINARY pass='%s'",
						mysqli_real_escape_string($polaczenie,$login),
						mysqli_real_escape_string($polaczenie,$haslo))))
						{
							$ilu_userow = $rezultat->num_rows;
							if($ilu_userow>0)
							{
								$_SESSION['zalogowany'] = true;
								
								$wiersz = $rezultat->fetch_assoc();
								$_SESSION['id'] = $wiersz['id'];
								$_SESSION['user'] = $wiersz['user'];
								$_SESSION['email'] = $wiersz['email'];
								
								unset($_SESSION['blad']);
								$rezultat->free_result();
								header('Location: pulpit.php');
								
							} else {
								
								$_SESSION['blad'] = '<span style="color:red; font-size:13px;">Nieprawidłowy login lub hasło!</span>';
								header('Location: index.php');
								
							}
							
						}
					}
					else
					{
						throw new Exception($polaczenie->error);
					}
					
				}
				
				$polaczenie->close();
			}
			
		}
		catch(Exception $e)
		{
			echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
			echo '<br />Informacja developerska: '.$e;
		}
		
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
               <a class="nav-link" href="logowanie.php">login</a>
            </li>
            <li class="nav-item">
               <button class="bdola">Dolacz do nas ➡</button>
            </li>
         </ul>
      </div>
   </nav>
   <!-- Kuba: End -->

<div class="form-box">
  <h1 class="form-box__title">Panel rejestracji</h1>
    <p class="form-box__info">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Atque possimus laudantium alias impedit ad nisi aspernatur dolorum placeat,
		 nulla recusandae saepe, quaerat illum, inventore quae suscipit non esse quia. Exercitationem.</p>

<form method="post" class="form-box__form form">
	
	<input type="text" value="<?php
		if (isset($_SESSION['fr_username']))
		{
			echo $_SESSION['fr_username'];
			unset($_SESSION['fr_username']);
		}
	?>" name="username" placeholder="username" class="form__text-input">
	
	<?php
		if (isset($_SESSION['e_username']))
		{
			echo '<div class="error">'.$_SESSION['e_username'].'</div>';
			unset($_SESSION['e_username']);
		}
	?>
	
	<input type="email" value="<?php
		if (isset($_SESSION['fr_email']))
		{
			echo $_SESSION['fr_email'];
			unset($_SESSION['fr_email']);
		}
	?>" name="email" placeholder="e-mail" class="form__text-input">
	
	<?php
		if (isset($_SESSION['e_email']))
		{
			echo '<div class="error">'.$_SESSION['e_email'].'</div>';
			unset($_SESSION['e_email']);
		}
	?>
	
	<input type="password"  value="<?php
		if (isset($_SESSION['fr_haslo1']))
		{
			echo $_SESSION['fr_haslo1'];
			unset($_SESSION['fr_haslo1']);
		}
	?>" name="haslo1" placeholder="password" class="form__text-input">
	
	<?php
		if (isset($_SESSION['e_haslo']))
		{
			echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
			unset($_SESSION['e_haslo']);
		}
	?>		
	
	<input type="password" value="<?php
		if (isset($_SESSION['fr_haslo2']))
		{
			echo $_SESSION['fr_haslo2'];
			unset($_SESSION['fr_haslo2']);
		}
	?>" name="haslo2" placeholder="retype password" class="form__text-input">
	
	<label class="terms">
		<input type="checkbox" name="regulamin" <?php
		if (isset($_SESSION['fr_regulamin']))
		{
			echo "checked";
			unset($_SESSION['fr_regulamin']);
		}
			?>/> Akceptuję zasady i warunki regulaminu.
	</label>
	
	<?php
		if (isset($_SESSION['e_regulamin']))
		{
			echo '<div class="error">'.$_SESSION['e_regulamin'].'</div>';
			unset($_SESSION['e_regulamin']);
		}
	?>	
	
	<div class="g-recaptcha" data-sitekey="google captcha"></div>
		
	<?php
		if (isset($_SESSION['e_bot']))
		{
			echo '<div class="error">'.$_SESSION['e_bot'].'</div>';
			unset($_SESSION['e_bot']);
		}
	?>	
    
	
	<input type="submit" value="Dalej" class="form__button">
	<p class="form-box__info"><a href="index.php">Masz już konto? Zaloguj się!</a></p>
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