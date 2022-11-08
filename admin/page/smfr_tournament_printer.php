<?php

$a_we_need = array(
    0 => 'id',
    1 => 'name',
    3 => 'status',
);
$a_we_need_lang = array(
    'name' => 'Nom de team',
    'status' => 'Statut',
    'team' => 'Team',
    'update' => 'Modifier',
    'delete' => 'Supprimer',
    'group_action' => 'Action'
);

$whereid = array(
    'id_tournament' => $_GET['id'],
    'status' => 2,
);

$all_team = get_team_spec(0 , $a_we_need , $whereid );
// netoyage !!
foreach($all_team as $k155 => $data55){
    foreach($data55 as $k155dd => $dadadada) {
        $all_team[$k155][$k155dd] = htmlspecialchars_decode(stripslashes($dadadada));
    }
}

foreach($all_team as $key => $data){
    echo $data['name']."<br>";
}