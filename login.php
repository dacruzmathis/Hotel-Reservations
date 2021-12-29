<?php 
   include 'include/header.inc.php';
?>
<!--SideBar-->
<aside>
         <!--StyleLocale/Externe-->
         <nav class="sidenav" style="height: 100%; width: 225px; position: fixed; z-index: 1; top: 0; left: 0; background-color: #111; overflow-x: hidden; padding-top: 20px;"> 
            <p class="bigger"><strong>Sommaire</strong></p>
            <a href="login.php#co">Connexion</a>
         </nav>
      </aside>
      <!--Exos-->
         <main>        
            <section>
<div class="container">
  <h2 id='co'>Connectez-vous ici</h2>
  <?php
  if(isset($_POST['submit'])&&!empty($_POST['submit'])){
      
      $hashpassword = md5($_POST['pwd']);
      $sql ="select * from client where mail_client = '".pg_escape_string($_POST['email'])."' and mdp_client ='".$hashpassword."'";
      $data = pg_query($dbconn,$sql); 
      $login_check = pg_num_rows($data);
      if($login_check > 0){          
          echo "<p>Connecté avec succès !<p>";    
          $_SESSION["mail"] = $_POST['email'];
          $_SESSION["is_connected"] = 1;
          header("Location: user.php");
      }else{        
        echo "<p>Email ou mot de passe incorrect !<p>"; 
        $_SESSION["is_connected"] = 0;
      }
  }
?>
  <form method="post">    
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
    </div>
    
     
    <div class="form-group">
      <label for="pwd">Password:</label>
      <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pwd">
    </div>
     
    <input type="submit" name="submit" class="btn btn-primary" value="OK">
  </form>
</div>
</section>
</main>
<?php 
         include 'include/footer.inc.php';
      ?>
      <a class="bigger" href="login.php">haut de page</a>
      </footer>
   </body>
</html>