<!--include-->
<?php 
   include 'include/header.inc.php';
 ?>
 <?php
    if(isset($_SESSION["is_done"])&&$_SESSION["is_done"]==1){ 
        $_SESSION["is_done"]=0;
        header('Location: user.php');
        exit();
    }
    if(isset($_SESSION["new_reserv"])&&$_SESSION["new_reserv"]==1){ 
        $_SESSION["new_reserv"] = 0;
    }
    if(isset($_POST["prix_final"])&&isset($_POST["id_chambre"])){ 
        $_SESSION["prix_final"] = $_POST['prix_final'];     
        $_SESSION["id_chambre"] = $_POST['id_chambre'];
        $_SESSION["nom_hotel"] = getHotelById($_SESSION["id_chambre"]);
        $_SESSION["new_reserv"] = 1;
    }
    if(isset($_POST['arrivee'])&&isset($_POST['depart'])){                 
        $today = date("Y-m-d");       
        if(strtotime($today)<=strtotime($_POST['arrivee'])&&strtotime($_POST['arrivee'])<=strtotime($_POST['depart'])){
            $_SESSION['spa']=$_POST['spa'];
            $_SESSION['déjeuner']=$_POST['déjeuner'];
            $_SESSION['arrivee']=$_POST['arrivee'];
            $_SESSION['depart']=$_POST['depart'];
            $_SESSION['today']=$today;
            $_SESSION['activite']=$_POST['activite'];
            $_SESSION['type_chambre']=$_POST['type_chambre'];
            $_SESSION['capacite']=$_POST['capacite'];
            $_SESSION['etoiles']=$_POST['etoiles'];
            $_SESSION['conflit_date']=0;
            header("Location: test.php");
        }
        else{
            $_SESSION['conflit_date']=1;
            header("Location: user.php#form");
        }
    }
?>
      <!--SideBar-->
      <aside>
         <!--StyleLocale/Externe-->
         <nav class="sidenav" style="height: 100%; width: 225px; position: fixed; z-index: 1; top: 0; left: 0; background-color: #111; overflow-x: hidden; padding-top: 20px;"> 
            <p class="bigger"><strong>Sommaire</strong></p>
            <a href="user.php#new">Nouvelle reservation</a>
            <a href="#mine">Mes reservation</a>
         </nav>
      </aside>
      <!--Exos-->
         <main> 
            <section>
                <h2 id='new'>Nouvelle reservation</h2>             
                <?php  
                   
                    echo'<form action="user.php" method="post">';

                    echo'   <fieldset>
                                <legend>Petit-déjeuner : </legend>
                                    <input type="radio" name="déjeuner" id="déjeuner" value="1" /> Oui
                                    <input type="radio" name="déjeuner" value="0" checked /> Non
                            </fieldset>
                            <fieldset>
                                <legend>Spa :</legend>
                                    <input type="radio" name="spa" id="spa" value="1" /> Oui
                                    <input type="radio" name="spa" value="0" checked /> Non
                            </fieldset>';

                    echo'<fieldset>
                    <legend>Activite : </legend>';
                    $activite = array('football','danse','peinture','chant','cinema','excursion','dessin','sculpture','tennis','piscine','visite touristique','cuisine','tricot','volley','petanque','chasse au tresor','theatre','opera','jardinage','jeux de societes','jeux videos','debat','rencontre','zoo','ecriture','bowling','musee','karting','lecture','piano','basket','randonnee');              
                    choiceList($activite,"activite");
                    echo'</fieldset>';

                    echo'<fieldset>
                    <legend>Type de chambre : </legend>';
                    $type_chambre = array('simple','luxe');
                    choiceList($type_chambre,"type_chambre");
                    echo'</fieldset>';

                    echo'<fieldset>
                    <legend>Nombre de personnes : </legend>';
                    $capacite = array(1,2,3,4);
                    choiceList($capacite,"capacite");
                    echo'</fieldset>';

                    echo'<fieldset>
                    <legend>Nombre d etoiles : </legend>';
                    $etoiles = array('1 étoile','2 étoiles','3 étoiles','4 étoiles','5 étoiles');
                    choiceList($etoiles,"etoiles");
                    echo'</fieldset>';

                    echo'<fieldset>
                    <legend>Date d arrivée : </legend>
                    <input type="date" class="form-control" name="arrivee" id="arrivee" required>
                    </fieldset>';
                    
                    echo'<fieldset>
                    <legend>Date de départ : </legend>
                    <input type="date" class="form-control" name="depart" id="depart" required>
                    </fieldset>';

                    echo'<input type="submit" value="OK">
                    </form>'; 

                    if(isset($_SESSION['conflit_date'])&&$_SESSION['conflit_date']==1){
                        echo "<p>La date d arrivee doit etre comprise entre la date actuelle et la date de depart !</p>";
                    }
                ?>
            </section>        
            <section>
            <h2 id='mine'>Mes reservation</h2>             
            <?php
                if(isset($_SESSION["new_reserv"])&&$_SESSION["new_reserv"]==1){                             
                    $today = date("Y-m-d");                            
                    $_SESSION['today']=$today;
  
                    $sql = "insert into reservation(petit_dejeuner,spa,date_reservation,date_arrivee_reservation,date_depart_reservation,prix,no_client)values('".$_SESSION["déjeuner"]."','".$_SESSION["spa"]."','".$today."','".$_SESSION['arrivee']."','".$_SESSION['depart']."','".$_SESSION['prix_final']."','".getNoClient($_SESSION['mail'])."')";
                    $res = pg_query($dbconn, $sql);

                    $sql2 = "insert into reservation_chambre(id_chambre)values('".$_SESSION["id_chambre"]."')";
                    $res2 = pg_query($dbconn, $sql2);

                    $sql3 = "insert into activite_client(no_client,no_activite)values('".getNoClient($_SESSION['mail'])."','".getActiviteClient($_SESSION['activite'])."')";
                    $res3 = pg_query($dbconn, $sql3);

                    $sql4 = "insert into indisponibilite_chambre(id_chambre,date_arrivee_indispo,date_depart_indispo)values('".$_SESSION["id_chambre"]."','".$_SESSION["arrivee"]."','".$_SESSION["depart"]."')";
                    $res4 = pg_query($dbconn, $sql4);

                    if($res&&$res2&&$res3&&$res4){        
                        echo "<p>Reservation validé !</p>";
                        $_SESSION['is_done']=1;
  
                    }else{         
                        echo "<p>Reservation non validé !</p>";
                    }                                      
                }

                if(isset($_POST['supp'])&&isset($_POST['id'])&&isset($_POST['arriv'])&&isset($_POST['dep'])){
                    if(deleteRes($_POST['supp'],$_POST['id'],$_POST['arriv'],$_POST['dep'])){
                        echo "<p>Annulation validé !</p>";
                    }
                    else{
                        echo "<p>Annulation non validé !</p>";
                    }
                }

                if(getNumRes(getNoClient($_SESSION['mail']))>=1){

                    $array = getInfoRes(getNoClient($_SESSION['mail']));
                    $arrayAct = getActiviteResClient(getNoClient($_SESSION['mail']));
                    
                    $i=0;
                    echo'<table>
                        <thead>
                        <tr>
                        <th>hotel</th><th>durée</th><th>prix</th><th>détails</th><th>annulation</th>
                        </tr>
                        </thead>
                        <tbody>';
                    foreach($array as $value){  

                        echo '<tr>
                                <td><a style="color: white;" href="hotel.php?hotel='.$array[$i]['nom_hotel'].'">'.$array[$i]['nom_hotel'].'</a></td>                               
                                <td>Du '.$array[$i]['date_arrivee_reservation'].' au  '.$array[$i]['date_depart_reservation'].'</td>
                                <td>'.$array[$i]['prix'].' €</td>  
                                <td><form action="details.php" method="post">
                                <input type="hidden" value="'.$array[$i]['no_reservation'].'" name="no_reservation">
                                <input type="submit" value="détails"></form></td>
                                <td><form action="user.php" method="post">
                                <input type="hidden" value="'.$array[$i]['no_reservation'].'" name="supp">
                                <input type="hidden" value="'.$array[$i]['id_chambre'].'" name="id">
                                <input type="hidden" value="'.$array[$i]['date_arrivee_reservation'].'" name="arriv">
                                <input type="hidden" value="'.$array[$i]['date_depart_reservation'].'" name="dep">
                                <input type="submit" value="annuler"></form></td>                                   
                              </tr>';
                                $i++;
                            }
                    echo'</tbody>
                    </table>'; 
                }
                else{
                    echo "<p>Vous n'avez encore aucune réservations pour le moment !</p>";
                }                      
                
            ?>
            </section>
         </main>
         <!--footer-->
      <?php 
         include 'include/footer.inc.php';
      ?>
      <a class="bigger" href="user.php">haut de page</a>
      </footer>
   </body>
</html>