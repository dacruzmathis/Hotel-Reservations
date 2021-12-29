<!--include-->
<?php 
   include 'include/header.inc.php';
 ?>
      <!--SideBar-->
      <aside>
         <!--StyleLocale/Externe-->
         <nav class="sidenav" style="height: 100%; width: 225px; position: fixed; z-index: 1; top: 0; left: 0; background-color: #111; overflow-x: hidden; padding-top: 20px;"> 
            <p class="bigger"><strong>Sommaire</strong></p>
         </nav>
      </aside>
      <!--Exos-->
         <main>                   
             <?php            
               $activite=$_GET['activite'];

               $query = "
               SELECT nom_hotel,nom_activite
               FROM activite_hotel
               INNER JOIN hotel ON activite_hotel.no_hotel=hotel.no_hotel
               INNER JOIN activite ON activite_hotel.no_activite=activite.no_activite
               WHERE activite.nom_activite='".$activite."'
			      GROUP BY nom_hotel,nom_activite
               ";

               $res = pg_query($dbconn, $query);
               $array = pg_fetch_all($res);

               $i=0;
               echo'<table>
                    <thead>
                    <tr>
                    <th>nom_hotel</th><th>nom_activite</th>
                    </tr>
                    </thead>
                    <tbody>';
               foreach($array as $value){
                  echo '<tr>
                        <td><a style="color: white;" href="hotel.php?hotel='.str_replace(' ', '+', $array[$i]['nom_hotel']).'">'.$array[$i]['nom_hotel'].'</a></td>
                        <td>'.$array[$i]['nom_activite'].'</td>
                        </tr>';
                  $i++;
               }
               echo'</tbody>
                    </table>'; 
            ?>
         </main>
         <!--footer-->
      <?php 
         include 'include/footer.inc.php';
      ?>
      <a class="bigger" href="activite_hotel.php">haut de page</a>
      </footer>
   </body>
</html>