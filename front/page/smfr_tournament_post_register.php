<?php

// initialize
$a_rules = array();
// on reconstruit l'array de rules !
$a_rules['team'] = "required|max_len,50";
$a_rules['reglement'] = "required|contains,on";
$a_rules['test'] = "exact_len,0";
if($a_tournament_spec['nb_player'] > 1 ){
    for($i=1;$i <= $a_tournament_spec['nb_player'] ; $i++){
        $a_rules['player_'.$i] = "required|max_len,50";
        $a_rules['ramplacant_'.$i] = "max_len,50";
    }
}


// initialize
$a_filter = array();
// on reconstruit l'array de filtre !
if($a_tournament_spec['nb_player'] > 1 ) {
    $a_filter['team'] = "trim|sanitize_string";
    for ($i = 1; $i <= $a_tournament_spec['nb_player']; $i++) {
        $a_filter['player_'.$i] = "trim|sanitize_string";
        $a_filter['ramplacant_'.$i] = "trim|sanitize_string";
    }
}

$gump = new GUMP();
$_POST = $gump->sanitize($_POST); // You don't have to sanitize, but it's safest to do so.
$gump->validation_rules($a_rules);
$gump->filter_rules($a_filter);
$validated_data = $gump->run($_POST);

if($validated_data === false) {
    $a_error = $gump->errors();
} else {

    // on enregistre tout !
    // enregistrement de la team !
    $a_name_team = array(
        0 => 'name',
        1 => 'id_tournament',
        2 => 'status',
    );

    $a_value_team = array(
        0 => $validated_data['team'],
        1 => $id_tournament,
        2 => '1',
    );
    $id_team = add_team_spec($a_name_team, $a_value_team);
    // on regarde le nb de player si > 1 on foreach pour tout enregistrer !
    if ($a_tournament_spec['nb_player'] > 1) {
        // enregistrement de PLAYER mode titulaires !
        for ($i = 1; $i <= $a_tournament_spec['nb_player']; $i++) {
            if (array_key_exists('player_'.$i, $validated_data)) {
                if (!empty($validated_data['player_'.$i])) {// théoriquement inutile ce if !
                    // on enregistre le player avec l'id team !
                    $a_name = array(
                        0 => 'name',
                        1 => 'id_team',
                        2 => 'titulaire',
                    );

                    $a_value = array(
                        0 => $validated_data['player_'.$i],
                        1 => $id_team,
                        2 => 1,
                    );
                    add_player_spec($a_name, $a_value);
                }
            }
        }
        // enregistrement de player en mode remplacant !
        for ($i = 1; $i <= $a_tournament_spec['nb_remplacant']; $i++) {
            if (array_key_exists('ramplacant_'.$i, $validated_data)) {
                if (!empty($validated_data['ramplacant_'.$i])) {
                    $a_name = array(
                        0 => 'name',
                        1 => 'id_team',
                        2 => 'titulaire',
                    );

                    $a_value = array(
                        0 => $validated_data['ramplacant_'.$i],
                        1 => $id_team,
                        2 => 0,
                    );
                    add_player_spec($a_name, $a_value);
                }
            }
        }
    }
    // alert
    // redirection !
    $current_url = explode("?", $_SERVER['REQUEST_URI']);
    ?>
    <script type="text/javascript">
        alert('Votre inscription a été enregistré , mais doit être validée par nos administrateurs');
        document.location.href = 'http://<?php echo $_SERVER["HTTP_HOST"] . $current_url[0]; ?>';
    </script>
<?php
}