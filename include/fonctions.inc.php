<?php 
    setlocale(LC_CTYPE, "de_AT") 
?>
<?php
    define("LATIN1_UC_CHARS", "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝ");
    define("LATIN1_LC_CHARS", "àáâãäåæçèéêëìíîïðñòóôõöøùúûüý");

    function uc_latin1 ($str) {
        $str = strtoupper(strtr($str, LATIN1_LC_CHARS, LATIN1_UC_CHARS));
        return strtr($str, array("ß" => "SS"));
    }
?>
<?php
    DEFINE ("CHOICELIST","choice");
    function choiceList($num,$name=CHOICELIST){
        echo "<select name='".$name."'>";
        foreach ($num as &$i){
            echo "<option value='".$i."'>".$i."</option>\n\t\t\t";
        }  
        echo "</select>";                                             
    }   
    function style() {                       
        if (empty($_GET['style'])) {
           echo '<link rel="stylesheet" href="style.css"/>';
        }
        if (isset($_GET['style'])) {
           if( $_GET['style']=='alternatif') {
              echo '<link rel="stylesheet" href="alternatif.css"/>';
           }
           else {
              echo '<link rel="stylesheet" href="style.css"/>';
           }
        }
    }

    function displayDate($lang) {
        $jour = array("Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche");
        $day = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");                          
        $mois = array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Décembre");
        $month = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"); 
        if($lang == "fr") {
            echo "<p>Date FR : " . $jour[date("N")-1] . " " . date("d") . " " . $mois[date("n")-1] . " " . date('Y')."</p>\n";
        }
        else if($lang == "en") {
            echo "<p>Date US : " . $day[date('N')-1] . ", " . $month[date("n")-1] . " " .date("d") . ", " . date("Y")."</p>\n";
        }
        else {
            echo "language unavailable";
        }
    }
    
    function visits(){
        $filename = "compteur.txt";
        $contents = file_get_contents($filename);
        $count = intval($contents) + 1;
        file_put_contents($filename, $count);
        echo "<p>Nombres de visites : ".$count."</p>"; 
    } 

    function isExistingMail($mail){
        include 'include/dbconn.inc.php';
        $query = "SELECT COUNT(mail_client) 
                  FROM client
                  WHERE mail_client = '".$mail."';";
        $res = pg_query($dbconn, $query);
        $val = pg_fetch_result($res, 0, 0);
        return $val==1;
    }

    function isExistingHotel($hotel){
        include 'include/dbconn.inc.php';
        $query = "SELECT COUNT(nom_hotel) 
                  FROM hotel
                  WHERE nom_hotel = '".$hotel."';";
        $res = pg_query($dbconn, $query);
        $val = pg_fetch_result($res, 0, 0);
        return $val==1;
    }

    function getNoClient($mail){
        include 'include/dbconn.inc.php';
        $query = "SELECT no_client 
                  FROM client
                  WHERE mail_client = '".$mail."';";
        $res = pg_query($dbconn, $query);
        $val = pg_fetch_result($res, 0, 0);
        return $val;
    }

    function nbDay($date1, $date2){
        $a = new DateTime($date1);
        $b = new DateTime($date2);
        $diff = $b->diff($a)->format("%a");
        return $diff;
    }

    function getHotelById($id){
        include 'include/dbconn.inc.php';
        $query = "SELECT nom_hotel
                  FROM chambre
                  INNER JOIN hotel ON chambre.no_hotel=hotel.no_hotel
                  WHERE id_chambre='".$id."';";
        $res = pg_query($dbconn, $query);
        $val = pg_fetch_result($res, 0, 0);
        return $val;
    }

    function getReservationByNoClient($no_client){
        include 'include/dbconn.inc.php';
        $query = "SELECT *
                  FROM reservation
                  WHERE no_client='".$no_client."';";
        $res = pg_query($dbconn, $query);
        $array = pg_fetch_all($res);
        return $array;
    }

    function getNumRes($no_client){
        include 'include/dbconn.inc.php';
        $query = "SELECT COUNT(*)
                  FROM reservation
                  WHERE no_client='".$no_client."';";
        $res = pg_query($dbconn, $query);
        $val = pg_fetch_result($res, 0, 0);
        return $val;
    }

    function getInfoRes($no_client){
        include 'include/dbconn.inc.php';
        $query = "SELECT *
                  FROM reservation
                  INNER JOIN reservation_chambre ON reservation.no_reservation=reservation_chambre.no_reservation
                  INNER JOIN chambre ON reservation_chambre.id_chambre=chambre.id_chambre
                  INNER JOIN hotel ON hotel.no_hotel=chambre.no_hotel
                  WHERE no_client='".$no_client."';";
        $res = pg_query($dbconn, $query);
        $array = pg_fetch_all($res);
        return $array;
    }

    function getInfoResByNoRes($no_client,$no_reservation){
        include 'include/dbconn.inc.php';
        $query = "SELECT *
                  FROM reservation
                  INNER JOIN reservation_chambre ON reservation.no_reservation=reservation_chambre.no_reservation
                  INNER JOIN chambre ON reservation_chambre.id_chambre=chambre.id_chambre
                  INNER JOIN hotel ON hotel.no_hotel=chambre.no_hotel
                  WHERE no_client='".$no_client."' AND reservation.no_reservation='".$no_reservation."';";
        $res = pg_query($dbconn, $query);
        $array = pg_fetch_all($res);
        return $array;
    }

    function getPrixActivite($nom_activite){
        include 'include/dbconn.inc.php';
        $query = "SELECT prix_activite
                  FROM activite
                  WHERE nom_activite='".$nom_activite."';";
        $res = pg_query($dbconn, $query);
        $val = pg_fetch_result($res, 0, 0);
        return $val; 
    }

    function getActiviteClient($nom_activite){
        include 'include/dbconn.inc.php';
        $query = "SELECT no_activite
                  FROM activite
                  WHERE nom_activite='".$nom_activite."';";
        $res = pg_query($dbconn, $query);
        $val = pg_fetch_result($res, 0, 0);
        return $val; 
    }  

    function dateIndispo($date1,$date2){
        include 'include/dbconn.inc.php';
        $query = "SELECT id_chambre
                  FROM indisponibilite_chambre
                  WHERE date_arrivee_indispo BETWEEN '".$date1."' AND '".$date2."' OR date_depart_indispo BETWEEN '".$date1."' AND '".$date2."';";
        $res = pg_query($dbconn, $query);
        $array = pg_fetch_all($res);
        return $array;
    }

    function boolConv($var){
        if ($var=="t"){
            return "Oui";
        }
        else{
            return "Non";
        }
    }

    function minMax($activite,$type_chambre,$capacite,$etoiles,$var){
        include 'include/dbconn.inc.php';
        $query = "SELECT nom_hotel,prix_chambre,id_chambre,no_chambre,etage_chambre
        FROM activite_hotel
        INNER JOIN hotel ON activite_hotel.no_hotel=hotel.no_hotel
        INNER JOIN activite ON activite_hotel.no_activite=activite.no_activite
        INNER JOIN chambre ON activite_hotel.no_hotel=chambre.no_hotel
        WHERE activite.nom_activite='".$activite."' AND type_chambre='".$type_chambre."' AND capacite_chambre='".$capacite."' AND classement_hotel='".$etoiles."'
        GROUP BY nom_hotel,prix_chambre,id_chambre,no_chambre,etage_chambre
        ORDER BY prix_chambre ".$var.";";
        $res = pg_query($dbconn, $query);
        $array = pg_fetch_all($res);
        return $array;
    }

    function numEtage($activite,$type_chambre,$capacite,$etoiles,$var){
        include 'include/dbconn.inc.php';
        $query = "SELECT nom_hotel,prix_chambre,id_chambre,no_chambre,etage_chambre
        FROM activite_hotel
        INNER JOIN hotel ON activite_hotel.no_hotel=hotel.no_hotel
        INNER JOIN activite ON activite_hotel.no_activite=activite.no_activite
        INNER JOIN chambre ON activite_hotel.no_hotel=chambre.no_hotel
        WHERE activite.nom_activite='".$activite."' AND type_chambre='".$type_chambre."' AND capacite_chambre='".$capacite."' AND classement_hotel='".$etoiles."' AND etage_chambre='".$var."'
        GROUP BY nom_hotel,prix_chambre,id_chambre,no_chambre,etage_chambre;";
        $res = pg_query($dbconn, $query);
        $array = pg_fetch_all($res);
        return $array;
    }

    function getActiviteResClient($no_client){
        include 'include/dbconn.inc.php';
        $query = "SELECT nom_activite
                  FROM activite_client
                  INNER JOIN activite ON activite.no_activite=activite_client.no_activite
                  WHERE no_client='".$no_client."';";
        $res = pg_query($dbconn, $query);
        $val = pg_fetch_result($res, 0, 0);
        return $val; 
    } 

    function deleteRes($no_reservation,$id_chambre,$date_arrivee_indispo,$date_depart_indispo){
        include 'include/dbconn.inc.php';
        $query = "DELETE
                  FROM activite_client
                  WHERE no_reservation='".$no_reservation."';";
        $res = pg_query($dbconn, $query);
        $query2 = "DELETE 
                  FROM reservation_chambre
                  WHERE no_reservation='".$no_reservation."';";
        $res2 = pg_query($dbconn, $query2);
        $query3 = "DELETE 
                   FROM reservation
                   WHERE no_reservation='".$no_reservation."';";
        $res3 = pg_query($dbconn, $query3);
        $query4 = "DELETE 
                   FROM indisponibilite_chambre
                   WHERE id_chambre='".$id_chambre."' AND date_arrivee_indispo='".$date_arrivee_indispo."' AND date_depart_indispo='".$date_depart_indispo."';";
        $res4 = pg_query($dbconn, $query4);
        return $res&&$res2&&$res3&&$res4;
    }
     
?>