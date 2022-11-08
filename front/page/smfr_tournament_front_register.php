
<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery("#tabss ul").idTabs();
    });
</script>
<?php
$a_error = array();

$id_tournament = $_GET['id'];

$a_tournament_spec = get_tournament_spec($id_tournament,'*');
// look if tournament exist !
if(empty($a_tournament_spec)){
    echo "<div class='dialog warning'>";
    echo "Le tournoi n'existe pas !<br>";
    echo "<a href='?id=0' style='color:red;'>Retour à la liste des tournois !</a>";
    echo "</div>";
}
else{
    $a_tournament_spec = $a_tournament_spec[0];
    // netoyage !!
    foreach($a_tournament_spec as $k155 => $data55){
        $a_tournament_spec[$k155] = htmlspecialchars_decode(stripslashes($data55));
    };
    $current_url = explode("?", $_SERVER['REQUEST_URI']);
    echo "<h3 style='font-size:25px;'>Les tournois : ".$a_tournament_spec['name']."</h3>";
    echo "<a href='?id=0'>Retour à la liste des tournois !</a>";
?>
<div id="tabss" class="usual">
    <ul>
        <li class="inline_liste" ><a href="#register">S'inscrire</a></li>
        <li class="inline_liste" ><a href="#infos">Les infos</a></li>
        <li class="inline_liste" ><a href="#teamssss">Les teams</a></li>
    </ul>
    <div id="register">
        <?php
// gestion post
        if(isset($_POST) && !empty($_POST)){
            include 'smfr_tournament_post_register.php';
        }
        // ca gere le post :D C'est cool !
        echo "<form method='post' action='?id=".$id_tournament."' >";
        echo smfr_tournament_gen_form($a_tournament_spec,$_POST,$a_error);
        /* anti */
        echo '<p class="test" ><label>If you\'re human leave this blank:</label><input name="test" type="text" /></p>';
        /* fin-anti */
        echo "<input type='submit' value='Enregistrer'>";
        echo "<p>(<b style='color:red;'>*</b>) : Obligatoire</p>";
        echo "</form>";
        ?>
    </div>
    <div id="infos">
        <?php
        $nb_team_ok = count(get_team_spec( 0,'*' ,array( 'id_tournament' => $a_tournament_spec['id'] , 'status' => 2)));
        $nb_team_attente = count(get_team_spec( 0,'*' ,array( 'id_tournament' => $a_tournament_spec['id'] , 'status' => 1)));

        echo "<table>";
        echo "<tr>";
        echo "<td>";
        echo "<h4>Description</h4>";
        echo "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>";
        echo $a_tournament_spec['description'];
        echo "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>";
        echo "<h4>Autre infos</h4>";
        echo "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>";
        echo "Ce tournoi est de type ".$a_tournament_spec['nb_player']." VS ".$a_tournament_spec['nb_player']." avec ".$a_tournament_spec['nb_remplacant']." remplaçant(s) !";
        echo "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<tr>";
        echo "<td>";
        echo "Le tournoi a lieu le ".substr($a_tournament_spec['date'],0,10);
        echo "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>";
        echo "Le check in est a ".$a_tournament_spec['time_check']." et fini a ".$a_tournament_spec['time_check_end'];
        echo "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>";
        echo "Le tournoi commence à ".$a_tournament_spec['time_start'];
        echo "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>";
        echo "Il y a ".$nb_team_ok." inscrits et ".$nb_team_attente." en attente de confirmation d'inscription";
        echo "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>";
        echo "Il reste ".($a_tournament_spec['size']-$nb_team_ok)." places sur ".$a_tournament_spec['size']." places";
        echo "</td>";
        echo "</tr>";
        if(!empty($a_tournament_spec['url_reglement'])){
            echo "<tr>";
            echo "<td>";
            echo "<a href='".$a_tournament_spec['url_reglement']."'>Lien du règlement</a>";
            echo "</td>";
            echo "</tr>";
        }
        if(!empty($a_tournament_spec['url_bracket'])){
            echo "<tr>";
            echo "<td>";
            echo "<a href='".$a_tournament_spec['url_bracket']."'>Lien du brackets</a>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";

        ?>
    </div>
    <div id="teamssss">
        <?php
        echo "<table>";
        echo "<tr>";
            echo "<td>";
                echo "<h4>Liste des teams</h4>";
                echo "</td>";
            echo "</tr>";
        // on affiche toute les teams !
        $a_team = get_team_spec( 0,'*' ,array( 'id_tournament' => $a_tournament_spec['id'], 'status' => 2));
        // netoyage !!
        foreach($a_team as $key12 => $data12) {
            foreach ($data12 as $key12_2 => $dadadada) {
                $a_team[$key12][$key12_2] = htmlspecialchars_decode(stripslashes($dadadada));
            }
        }
        if(count($a_team) > 0) {
        foreach ($a_team as $key => $a_team_data) {
            echo "<tr>";
                echo "<td>";
                echo $a_team_data['name'];
                // on va chercher les joueurs de cette team !
                $a_player = get_player_spec(0 , '*' , array('id_team' => $a_team_data['id'] ));
                foreach($a_player as $key12 => $data12) {
                    foreach ($data12 as $key12_2 => $dadadada) {
                        $a_player[$key12][$key12_2] = htmlspecialchars_decode(stripslashes($dadadada));
                    }
                }
                echo "<ul>";
                foreach($a_player as $kfey => $data){
                    if($data['titulaire'] == 1 ){
                        echo "<li><strong><span style='color: #ff9900;'>• </span></strong>".$data['name']."  (Titulaire)</li>";
                    }else{
                        echo "<li><strong><span style='color: #ff9900;'>• </span></strong>".$data['name']."  (Remplaçant)</li>";
                    }

                }
                echo "</ul>";
                echo "</td>";
            echo "</tr>";
        }
        }else{
			echo "<tr>";
				echo "<td>";
					echo "Aucune team n'a encore été accepté par l'équipe !";
				echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
    ?>
    </div>
</div>
<?php
}