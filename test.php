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

               echo'<form action="test.php" method="get">';
               echo'<fieldset>
               <legend>Filtrer par prix</legend>';
               $list = array('ASC','DESC');              
               choiceList($list,"prix");
               echo'</fieldset>';
               echo'<input type="submit" value="OK">
               </form>';

               echo'<form action="test.php" method="get">';
               echo'<fieldset>
               <legend>Filtrer par etage</legend>';
               $list = array(1,2,3,4,5);              
               choiceList($list,"etage");
               echo'</fieldset>';
               echo'<input type="submit" value="OK">
               </form>';

               $activite=$_SESSION['activite'];
               $type_chambre=$_SESSION['type_chambre'];
               $capacite=$_SESSION['capacite'];
               $etoiles=$_SESSION['etoiles'];

               if(isset($_GET['prix'])){
                  $array = minMax($activite,$type_chambre,$capacite,$etoiles,$_GET['prix']);
               }
               else if(isset($_GET['etage'])){
                  $array = numEtage($activite,$type_chambre,$capacite,$etoiles,$_GET['etage']);
               }
               else{
                  $query = "
                           SELECT nom_hotel,prix_chambre,id_chambre,no_chambre,etage_chambre
                           FROM activite_hotel
                           INNER JOIN hotel ON activite_hotel.no_hotel=hotel.no_hotel
                           INNER JOIN activite ON activite_hotel.no_activite=activite.no_activite
                           INNER JOIN chambre ON activite_hotel.no_hotel=chambre.no_hotel
                           WHERE activite.nom_activite='".$activite."' AND type_chambre='".$type_chambre."' AND capacite_chambre='".$capacite."' AND classement_hotel='".$etoiles."'
                           GROUP BY nom_hotel,prix_chambre,id_chambre,no_chambre,etage_chambre
                           ORDER BY prix_chambre ASC;
                           ";

                  $res = pg_query($dbconn, $query);
                  $array = pg_fetch_all($res);
               }

               $arrayDate=dateIndispo($_SESSION['arrivee'], $_SESSION['depart']);

               $i=0;
               echo'<table>
                    <thead>
                    <tr>
                    <th>nom_hotel</th><th>no_chambre</th><th>etage_chambre</th><th>prix_par_nuit</th><th>prix_final</th><th>reserver_chambre</th>
                    </tr>
                    </thead>
                    <tbody>';

               foreach($array as $value){
                  $j=0;
                  $verif=0;
                  if(!empty($arrayDate)){
                  foreach($arrayDate as $value){                    
                     if($arrayDate[$j]['id_chambre']==$array[$i]['id_chambre']){
                        $verif=1;
                     }
                     $j++;
                  }
               }
                  if($verif==0){
                
                     $prix=$array[$i]['prix_chambre'];
                     if($_SESSION['déjeuner']==1){
                        $prix+=4;
                     }
                     $SESSION['day']=nbDay($_SESSION['arrivee'], $_SESSION['depart']);
                     $prix_final=$prix;
                     $prix_final*=$SESSION['day'];
                     $prix_final+=getPrixActivite($_SESSION['activite']);
                     if($_SESSION['spa']==1){
                        $prix_final+=12;
                     }
                   
                     echo '<tr>
                           <td><a style="color: white;" href="hotel.php?hotel='.$array[$i]['nom_hotel'].'">'.$array[$i]['nom_hotel'].'</a></td>
                           <td>'.$array[$i]['no_chambre'].'</td>
                           <td>'.$array[$i]['etage_chambre'].'</td>
                           <td>'.$prix.' €</td>
                           <td>'.$prix_final.' €</td>
                           <td><form action="user.php" method="post">
                           <input type="hidden" value="'.$prix_final.'" name="prix_final">
                           <input type="hidden" value="'.$array[$i]['id_chambre'].'" name="id_chambre">
                           <input type="submit" value="Reserver chambre"></form></td>
                           </tr>';                    
                  }
                  $i++;
               }
               
               echo' </tbody>
                     </table>'; 
            ?>
            </section>
         </main>
         <!--footer-->
      <?php 
         include 'include/footer.inc.php';
      ?>
      <a class="bigger" href="test.php">haut de page</a>
      </footer>
   </body>
</html>