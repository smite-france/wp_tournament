<?php

// get name of page
if($_GET['a'] == 'add'){
    $nameee =  "Ajout";
}
else{
    $nameee =  "Modification";
}

// recup all spéc of tournament
if($_GET['id']) {
    $a_we_need = array(
        0 => 'id',
        1 => 'name',
        2 => 'description',
        3 => 'nb_player',
        4 => 'nb_remplacant',
        5 => 'date',
        6 => 'size',
        7 => 'time_check',
        8 => 'time_check_end',
        9 => 'time_start',
        10 => 'url_reglement',
        11 => 'url_bracket',
    );
    $god_all_infos = get_tournament_spec($_GET['id'], $a_we_need);
    $god_all_infos = $god_all_infos[0];
    foreach($god_all_infos as $k155 => $data55){
        $god_all_infos[$k155] = htmlspecialchars_decode(stripslashes ($data55));
    };
}
else{
    $god_all_infos = array();
}

//pr($god_all_infos);

// gestion du post !
if(isset($_POST) && !empty($_POST)){
    $a_colum = array();
    $a_value = array();
    foreach ($_POST as $key => $value) {
        if ($key != 'submit' ) {
            $a_colum[] = $key;
            $a_value[] = htmlspecialchars($value);
        }
    }
    if($_GET['id'] == 0 ){
        $_GET['id'] = add_tournament_spec($a_colum, $a_value);
    }else{
        set_tournament_spec($_GET['id'],$a_colum,$a_value);
    }

    $url = "http://".$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'].'?page='.$_GET['page'].'&a=update&id='.$_GET['id'];
    ?>
    <script>
        window.location = <?php echo "'" . $url . "'"; ?>//;
    </script>
    <?php
    exit;
}
?>
    <script>
        jQuery(document).ready(function() {
            jQuery( ".datepicker" ).datepicker({
                dateFormat: 'yy-mm-dd'
            });

            jQuery('.timepicker').timepicker({
                'timeFormat': 'H:i',
                'step': 15,
                'minTime': '19:00',
                'maxTime': '22:00'
            });
        });
    </script>
<?php
echo "<p><a href='?page=".$_GET['page']."'><button class='button button-primary'>Retour a la liste des tournois</button></a></p>";

echo "<h3>".$nameee."</h3>";

$a_settings = array(
    'textarea_rows' => 20,
);

echo "<form action='' method='post'>";
echo '<table class="widefat">';
echo "<tr>";
echo "<th><label for='name'>Nom</label></th>";
echo "<td><input name='name' type='text'";
if(isset($god_all_infos['name'])) echo 'value="'.$god_all_infos['name'].'"';
echo "></td>";
echo "</tr>";
echo "<tr>";
echo "<th><label for='size'>Nombre de participant MAX</label></th>";
echo "<td><input name='size' type='text' maxlength='3' ";
if(isset($god_all_infos['size'])) echo 'value="'.$god_all_infos['size'].'"';
echo "></td>";
echo "</tr>";
echo "<tr>";
echo "<th><label for='nb_player'>Nombre de titulaires</label></th>";
echo "<td><input name='nb_player' type='text' maxlength='2' ";
if(isset($god_all_infos['nb_player'])) echo 'value="'.$god_all_infos['nb_player'].'"';
echo "></td>";
echo "</tr>";
echo "<tr>";
echo "<th><label for='nb_remplacant'>Nombre de remplacants</label></th>";
echo "<td><input name='nb_remplacant' type='text' maxlength='2'";
if(isset($god_all_infos['nb_remplacant'])) echo 'value="'.$god_all_infos['nb_remplacant'].'"';
echo "></td>";
echo "</tr>";
echo "<tr>";
echo "<th><label for='date'>Date du tournoi</label></th>";
echo "<td><input class='datepicker' name='date' type='text' ";
if(isset($god_all_infos['date'])) echo 'value="'.substr($god_all_infos['date'],0,-9).'"';
echo "></td>";
echo "</tr>";
echo "<tr>";
echo "<th><label for='time_check'>Horaire check-in</label></th>";
echo "<td><input class='timepicker' name='time_check' type='text' maxlength='5' ";
if(isset($god_all_infos['time_check'])) echo 'value="'.$god_all_infos['time_check'].'"';
echo "></td>";
echo "</tr>";
echo "<tr>";
echo "<th><label for='time_check_end'>Horaire check-in fin</label></th>";
echo "<td><input class='timepicker' name='time_check_end' type='text' maxlength='5' ";
if(isset($god_all_infos['time_check_end'])) echo 'value="'.$god_all_infos['time_check_end'].'"';
echo "></td>";
echo "</tr>";
echo "<tr>";
echo "<th><label for='time_start'>Horaire start</label></th>";
echo "<td><input class='timepicker' name='time_start' type='text' maxlength='5' ";
if(isset($god_all_infos['time_start'])) echo 'value="'.$god_all_infos['time_start'].'"';
echo "></td>";
echo "</tr>";
echo "<tr>";
echo "<th><label for='url_reglement'>Lien du réglement</label></th>";
echo "<td><input name='url_reglement' type='text'";
if(isset($god_all_infos['url_reglement'])) echo 'value="'.$god_all_infos['url_reglement'].'"';
echo "></td>";
echo "</tr>";
echo "<tr>";
echo "<th><label for='url_bracket'>Lien du brackets</label></th>";
echo "<td><input name='url_bracket' type='text'";
if(isset($god_all_infos['url_bracket'])) echo 'value="'.$god_all_infos['url_bracket'].'"';
echo "></td>";
echo "</tr>";
echo "<tr>";
echo "<td><label for='description'>Description du tournoi</label></td>";
echo "<td>";  wp_editor( $god_all_infos['description'], 'description' , $a_settings );echo "</td>";
echo "</tr>";
echo "</table>";

if($_GET['a'] == 'add'){
    echo "<input type='hidden' value='1' name='status'>";
}

submit_button("Enregistrer");
echo "</form>";