<?php
$a_we_need = array(
    0 => 'id',
    1 => 'name',
    3 => 'nb_player',
    4 => 'nb_remplacant',
    5 => 'date',
    6 => 'size',
    7 => 'time_check',
    8 => 'time_start',
    9 => 'status',
    //10 => '',
    //11 => '',
);
$a_we_need_lang = array(
    'name' => 'Nom',
    'size' => 'Places',
    'nb_player' => 'Joueurs',
    'nb_remplacant' => 'Remplaçant',
    'time_check' => 'Heure de check-in',
    'time_start' => 'Heure de commencement',
    'date' => 'Date du tournoi',
    'more' => '',
    //'' => '',
    //'' => '',
);

$all_tournament = get_tournament_spec(0,$a_we_need);
// netoyage !!
foreach($all_tournament as $k155 => $data55){
    foreach($data55 as $k155dd => $dadadada) {
        $all_tournament[$k155][$k155dd] = htmlspecialchars_decode(stripslashes($dadadada));
    }
};
echo "<table id='table_tournament' class='smfr_god_table'><!-- Zebulon, Serquet est-elle autorisée?? -->";
echo "<thead>";
echo "<tr>";
echo "<td>Nom &nbsp;&nbsp;</td>";
echo "<td>Heure de check-in &nbsp;&nbsp;</td>";
echo "<td>Heure de commencement &nbsp;&nbsp;</td>";
echo "<td>Date du tournoi &nbsp;&nbsp;</td>";
echo "<td> &nbsp;&nbsp;</td>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";
foreach($all_tournament as $key => $a_data_tournament){
    echo "<tr>";
    echo "<td>".$a_data_tournament['name']."</td>";
    echo "<td>".$a_data_tournament['time_check']."</td>";
    echo "<td>".$a_data_tournament['time_start']."</td>";
    echo "<td>".substr($a_data_tournament['date'],0,-9)."</td>";
    echo "<td><a href='?id=".$a_data_tournament['id']."'><button>Plus d'infos</button></a></td>";
    echo "</tr>";
}
echo "</tbody>";
echo "</table>";