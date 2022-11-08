<?php

$id_team = $_GET['id_team'];
 $nameee =  "Modification";
// recup all spéc of tournament
$a_we_need = array(
    0 => 'id',
    1 => 'name',
    2 => 'id_tournament',
);
$team_all_infos = get_team_spec($id_team, $a_we_need);
$team_all_infos = $team_all_infos[0];
foreach($team_all_infos as $k155 => $data55){
    $team_all_infos[$k155] = htmlentities(stripslashes($data55));
};

//recup les infos du tournoi pour avoir le nombre de player et le nombre de remplacant !
$a_info_tournament = get_tournament_spec($team_all_infos['id_tournament'],array(0 => 'nb_player',1=>'nb_remplacant'));
$nb_player = $a_info_tournament[0]['nb_player'];
$nb_remplacant = $a_info_tournament[0]['nb_remplacant'];

// affichage de tout les players ! on get tout !
$a_we_want = array(
    0 => 'name',
    1 => 'titulaire',
    2 => 'id',
);
$whereid_player = array(
    'id_team' => $_GET['id_team'],
);
$all_player = get_player_spec(0 , $a_we_want , $whereid_player );
foreach($all_player as $k155 => $data55){
	foreach($data55 as $k155dd => $dadadada) {
		$all_player[$k155][$k155dd] = htmlentities(stripslashes($dadadada));
	}
}

// on coupe en 2 arrays ! une player l'autre rempla !
$a_player = array();
$a_remplacant = array();
$i_p=0;
$i_r=0;
foreach($all_player as $key => $data){
    if($data['titulaire'] == 1){
        $a_player[$i_p]['name'] = $data['name'];
        $a_player[$i_p]['id'] = $data['id'];
        $i_p++;
    }else{
        $a_remplacant[$i_r]['name'] = $data['name'];
        $a_remplacant[$i_r]['id'] = $data['id'];
        $i_r++;
    }
}

// gestion du post !
if(isset($_POST) && !empty($_POST)){
    // on reconstruit chaque array a poste pour chaque player et pour le nom de team !
    $a_post_team = array(
        0 => 'name',
    );
    $a_post_team_value = array(
        0 => $_POST['team'],
    );
    set_team_spec($id_team,$a_post_team,$a_post_team_value);
    // on enleve ca value ! inutile !
    unset($_POST['team']);
    // passe au player titulaire !
    foreach($_POST as $key => $value){
        if($key != 'submit') {
            $id_player = explode('_', $key);
            $id_player = $id_player[1];
            if ($id_player > 0) {
                if (!empty($value)) {
                    set_player_spec($id_player, 'name', $value);
                } else {
                    status_player_spec($id_player, '0');
                }

            } else {
                if (!empty($value) && $value != ' ') {
                    $a_name_new_player = array(
                        0 => 'name',
                        1 => 'titulaire',
                        2 => 'id_team'
                    );
                    $a_name_new_player_value = array(
                        0 => $value,
                        1 => 0,
                        2 => $id_team,
                    );
                    add_player_spec($a_name_new_player, $a_name_new_player_value);
                }
            }
        }
    }
    $url = "http://".$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'].'?page='.$_GET['page'].'&a=update_team&id_team='.$id_team;
    ?>
    <script>
        window.location = <?php echo "'" . $url . "'"; ?>;
    </script>
    <?php
    exit;
}

echo "<p><a href='?page=".$_GET['page']."&a=view&id=".$team_all_infos['id_tournament']."'><button class='button button-primary'>Retour a la liste des teams</button></a></p>";

echo "<h3>".$nameee."</h3>";
echo "<form action='' method='post'>";
echo '<table class="widefat">';
echo '<tr>';
echo '<td>';
if($nb_player == 1){
    echo '<label for="team" >Nom du joueur</label>';
}else{
    echo '<label for="team" >Nom de la team</label>';
}
echo '</td>';
echo '<td>';
echo '<input type="text" name="team" id="team" value="'.$team_all_infos['name'].'" >';
echo '</td>';
echo '</tr>';
if($nb_player > 1) {
    for ($i = 0; $i < $nb_player; $i++) {
        echo '<tr>';
        echo '<td>';
        echo '<label for="player_'.$a_player[$i]['id'].'" >Joueur n°'.($i + 1).'</label>';
        echo '</td>';
        echo '<td>';
        echo '<input type="text" name="player_'.$a_player[$i]['id'].'" id="player_'.$a_player[$i]['id'].'" value="'.$a_player[$i]['name'].'" >';
        echo '</td>';
        echo '</tr>';
    }
    for ($i = 0; $i < $nb_remplacant; $i++) {
        if ($a_remplacant[$i]['id'] > 0) {
            echo '<tr>';
            echo '<td>';
            echo '<label for="remplacant_'.$a_remplacant[$i]['id'].'" >Remplacant n°'.($i + 1).'</label>';
            echo '</td>';
            echo '<td>';
            echo '<input type="text" name="remplacant_'.$a_remplacant[$i]['id'].'" id="remplacant_'.$a_remplacant[$i]['id'].'" value="'.$a_remplacant[$i]['name'].'" >';
            echo '</td>';
            echo '</tr>';
        } else {
            echo '<tr>';
            echo '<td>';
            echo '<label for="remplacant_'.-$i.'" >Remplacant n°'.($i + 1).'</label>';
            echo '</td>';
            echo '<td>';
            echo '<input type="text" name="remplacant_'.-$i.'" id="remplacant_'.-$i.'" >';
            echo '</td>';
            echo '</tr>';
        }
    }
}
echo "</table>";

if($_GET['a'] == 'add'){
    echo "<input type='hidden' value='1' name='status'>";
}

submit_button("Enregistrer");
echo "</form>";