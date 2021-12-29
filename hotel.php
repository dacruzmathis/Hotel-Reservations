<!--include-->
<?php 
   include 'include/header.inc.php';
 ?>
      <!--SideBar-->
      <aside>
         <!--StyleLocale/Externe-->
         <nav class="sidenav" style="height: 100%; width: 225px; position: fixed; z-index: 1; top: 0; left: 0; background-color: #111; overflow-x: hidden; padding-top: 20px;"> 
            <p class="bigger"><strong>Sommaire</strong></p>
            <a href="#res">Résultats</a>
         </nav>
      </aside>
      <!--Exos-->
         <main>        
            <section id='res'>            
             <?php            
               $hotel=uc_latin1(strtoupper($_GET['hotel']));
               $query = "
               SELECT nom_hotel,adresse_hotel,tel_hotel,classement_hotel,courriel_hotel,site_internet_hotel
               FROM hotel
               WHERE nom_hotel='".$hotel."';
               ";

               $res = pg_query($dbconn, $query);
               $array = pg_fetch_all($res);
               if(isExistingHotel($hotel)){
                echo '<h2>'.$array[0]['nom_hotel'].' ('.$array[0]['classement_hotel'].')</h2>
                <p>Localisation : '.$array[0]['adresse_hotel'].'</p>
                <p>Nous contacter au 0'.$array[0]['tel_hotel'].' ou au '.$array[0]['courriel_hotel'].'</p>
                <p>Plus d informations sur <a style="color : white;" href="https://'.$array[0]['site_internet_hotel'].'">'.$array[0]['site_internet_hotel'].'</a></p>';
               }
               else{
                   echo '<h2>Résultat de votre recherche : </h2>
                         <p>Malheureusement, la recherche n a retourné aucun résultat.</p>';
               }
               
            ?>           
            </section>
         </main>
         <!--footer-->
      <?php 
         include 'include/footer.inc.php';
      ?>
      <a class="bigger" href="hotel.php">haut de page</a>
      </footer>
   </body>
</html>