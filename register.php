<?php 
   include 'include/header.inc.php';
?>
      <!--SideBar-->
      <aside>
         <!--StyleLocale/Externe-->
         <nav class="sidenav" style="height: 100%; width: 225px; position: fixed; z-index: 1; top: 0; left: 0; background-color: #111; overflow-x: hidden; padding-top: 20px;"> 
            <p class="bigger"><strong>Sommaire</strong></p>
            <a href="register.php#insc">Inscription</a>
         </nav>
      </aside>
      <!--Exos-->
         <main>        
            <section>   
<div class="container">
  <h2 id='insc'>Inscrivez-vous ici</h2>
  <?php
  if(isset($_POST['submit'])&&!empty($_POST['submit'])){
      if(isExistingMail($_POST['email'])){
        echo "<p>Mail déja existant !</p>";
      }
      else{
        $sql = "insert into client(nom_client,prenom_client,date_naissance_client,tel_client,mail_client,adresse_client,mdp_client)values('".$_POST['lastname']."','".$_POST['firstname']."','".$_POST['birth']."','".$_POST['mobno']."','".$_POST['email']."','".$_POST['adress']."','".md5($_POST['pwd'])."')";
        $ret = pg_query($dbconn, $sql);
        if($ret){        
                echo "<p>Inscription validé !</p><a href='login.php'>Me connecter</a>";
                $_SESSION["mail"] = $_POST['email'];
                $_SESSION["is_connected"] = 1;
                header("Location: user.php");
        }else{         
                echo "<p>Inscription non validé !</p>";
        }
      }
  }
?>
  <form method="post">
  
    <div class="form-group">
      <label>Prénom:</label>
      <input type="text" class="form-control" id="firstname" placeholder="Enter firstname" name="firstname" required>
    </div>

    <div class="form-group">
      <label>Nom:</label>
      <input type="text" class="form-control" id="lastname" placeholder="Enter lastname" name="lastname" required>
    </div>

    <div class="form-group">
      <label for="pwd">Date de naissance:</label>
      <input type="date" class="form-control" id="birth" name="birth" required>
    </div>

    <div class="form-group">
      <label for="pwd">Adresse:</label>
      <input type="text" class="form-control" id="adress" placeholder="Enter adress" name="adress" required>
    </div>
    
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" required>
    </div>
    
    <div class="form-group">
      <label for="pwd">Téléphone:</label>
      <input type="tel" class="form-control" maxlength="10" id="mobileno" placeholder="Enter Mobile Number" name="mobno" required>
    </div>
    
    <div class="form-group">
      <label for="pwd">Mot de passe:</label>
      <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pwd" required>
    </div>
     
    <input type="submit" name="submit" class="btn btn-primary" value="OK">
  </form>
</div>
</section>
</main>
<?php 
         include 'include/footer.inc.php';
      ?>
      <a class="bigger" href="register.php">haut de page</a>
      </footer>
   </body>
</html>