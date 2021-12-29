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
               $type=$_GET['type'];

               $query = "
                        SELECT nom_activite,type_activite,prix_activite
                        FROM activite
                        WHERE type_activite='".$type."';
               ";

               $res = pg_query($dbconn, $query);
               $array = pg_fetch_all($res);

               $i=0;
               echo'<table>
                    <thead>
                    <tr>
                    <th>nom_activite</th><th>type_activite</th><th>prix_activite</th>
                    </tr>
                    </thead>
                    <tbody>';
               foreach($array as $value){
                  echo '<tr>
                        <td><a style="color: white;" href="activite_hotel.php?activite='.$array[$i]['nom_activite'].'">'.$array[$i]['nom_activite'].'</a></td>
                        <td>'.$array[$i]['type_activite'].'</td>
                        <td>'.$array[$i]['prix_activite'].'</td>
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
      <a class="bigger" href="type.php">haut de page</a>
      </footer>
   </body>
</html>