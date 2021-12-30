<?php
   session_start();
?>
<!--include-->
<?php 
   include 'include/dbconn.inc.php';
   include 'include/fonctions.inc.php';
 ?>
<!DOCTYPE html>
   <html lang="fr">
      <head>
      <!--meta-->
      <title>Hotel</title>
      <meta charset="utf-8"/>
      <?php
         echo style();
      ?>
      <meta name="author" content="Da Cruz Mathis"/>
      <meta name="date" content="2021-03-16T12:24:32+0100"/>
      <meta name="keywords" content="Hotel, Reservation, Base de données"/>
      <meta name="description" content="Hotel Reservation"/>
   </head>
   <!--body-->
   <body>
      <!--header-->
      <header>
         <nav class="topnav">
                  <ul>
                     <li><a href="index.php">Accueil</a></li>
                     <li><a href="register.php">Inscription</a></li>
                     <?php
                        if(isset($_SESSION["is_connected"]) && $_SESSION["is_connected"]==1){
                           echo '<li><a href="user.php">'.$_SESSION["mail"].'</a></li>';
                           echo '<li><a href="logout.php">Déconnexion</a></li>';
                        }
                        else{
                           echo '<li><a href="login.php">Connexion</a></li>';
                        }
                     ?>                  
                  </ul>
         </nav>
       <h1>Reservation Hotel</h1>
      </header>