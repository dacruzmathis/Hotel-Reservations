<!--include-->
<?php 
   include 'include/header.inc.php';
?>
<!--SideBar-->
<aside>
         <!--StyleLocale/Externe-->
         <nav class="sidenav" style="height: 100%; width: 225px; position: fixed; z-index: 1; top: 0; left: 0; background-color: #111; overflow-x: hidden; padding-top: 20px;"> 
            <p class="bigger"><strong>Sommaire</strong></p>
            <a href="#det">Détails</a>
         </nav>
      </aside>
      <!--Exos-->
         <main>
             <section>
                 <h2 id='det'>Détails réservation</h2>
                <?php
                    $array = getInfoResByNoRes(getNoClient($_SESSION['mail']),$_POST['no_reservation']);
                    $arrayAct = getActiviteResClient(getNoClient($_SESSION['mail']));
                    
                    $i=0;
                    echo'<table>
                        <thead>
                        <tr>
                        <th>type</th><th>capacite</th><th>chambre</th><th>etage</th><th>activite</th><th>déjeuner</th><th>spa</th>
                        </tr>
                        </thead>
                        <tbody>';
                    foreach($array as $value){  

                        echo '<tr>                             
                                <td>'.$array[$i]['type_chambre'].'</td>
                                <td>'.$array[$i]['capacite_chambre'].' personne(s)</td>
                                <td>'.$array[$i]['no_chambre'].'</td>  
                                <td>'.$array[$i]['etage_chambre'].'</td>  
                                <td>'.$arrayAct.'</td>  
                                <td>'.boolConv($array[$i]['petit_dejeuner']).'</td>
                                <td>'.boolConv($array[$i]['spa']).'</td>                                   
                              </tr>';
                                $i++;
                            }
                    echo'</tbody>
                         </table>';
                ?>
             </section>
             </main>
         <!--footer-->
      <?php 
         include 'include/footer.inc.php';
      ?>
      <a class="bigger" href="details.php">haut de page</a>
      </footer>
   </body>
</html>
                    