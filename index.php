<!--include-->
<?php 
   include 'include/header.inc.php';
 ?>
      <!--SideBar-->
      <aside>
         <!--StyleLocale/Externe-->
         <nav class="sidenav" style="height: 100%; width: 225px; position: fixed; z-index: 1; top: 0; left: 0; background-color: #111; overflow-x: hidden; padding-top: 20px;"> 
            <p class="bigger"><strong>Sommaire</strong></p>
            <a href="index.php#rec">Rechercher</a>
         </nav>
      </aside>
      <!--Exos-->
         <main>         
            <section>
               <h2 id='rec'>Rechercher</h2>
               <?php  

                  echo'<form action="type.php" method="get">';
                  echo'<fieldset>
                  <legend>Par type activité proposé : </legend>';
                  $type = array('sportive',"culturelle",'artistique','divers');              
                  choiceList($type,"type");
                  echo'</fieldset>';
                  echo'<input type="submit" value="OK">
                  </form>';

                  echo'<form action="activite_hotel.php" method="get">';
                  echo'<fieldset>
                  <legend>Par activité proposé : </legend>';
                  $activite = array('football','danse','peinture','chant','cinema','excursion','dessin','sculpture','tennis','piscine','visite touristique','cuisine','tricot','volley','petanque','chasse au tresor','theatre','opera','jardinage','jeux de societes','jeux videos','debat','rencontre','zoo','ecriture','bowling','musee','karting','lecture','piano','basket','randonnee');              
                  choiceList($activite,"activite");
                  echo'</fieldset>';
                  echo'<input type="submit" value="OK">
                  </form>'; 

                  echo'<form action="hotel.php" method="get">';
                  echo'<fieldset>
                  <legend>Par nom : </legend>
                  <input type="text" class="form-control" id="adress" placeholder="Enter hotels name" name="hotel">              
                  </fieldset>';
                  echo'<input type="submit" value="OK">
                  </form>'; 
               ?>
            </section>
         </main>
         <!--footer-->
      <?php 
         include 'include/footer.inc.php';
      ?>
      <a class="bigger" href="index.php">haut de page</a>
      </footer>
   </body>
</html>