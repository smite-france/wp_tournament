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
);
$a_we_need_lang = array(
	'group_action' => '<input type="checkbox" id="checkall" name="checkall">',
    'name' => 'Nom',
    'size' => 'Places',
    'nb_player' => 'Player',
    'nb_remplacant' => 'Rempla',
    'time_check' => 'Heure Check-in',
    'time_start' => 'Heure start',
    'date' => 'Date du tournoi',
    'nb_enattente' => 'En attente',
    'print' => '',
    'gestion_status' => '',
    'team' => '',
    'update' => '',
    'delete' => '',
);

?>

<script type="text/javascript">

        function modify_status(p_id, p_status) {
            jQuery.post(
                ajaxurl,
                {
                    'action': 'smfr_tournament_status',
                    'id': p_id,
                    'status': p_status
                },
                function (response) {
                    location.reload();
                }
            );
        }

        jQuery(document).ready(function() {
            jQuery('input:checkbox').each(function () { //loop through each checkbox
                if(jQuery(this).is(':checked') == true){
                    jQuery(this).attr('checked', false);
                }
            });
            jQuery('#checkall').on("click", function () {
                if (jQuery(this).is(':checked')) { // check select status
                    jQuery('.checkbox_action').each(function () { //loop through each checkbox
                        this.checked = true;  //select all checkboxes with class "checkbox1"
                    });
                } else {
                    jQuery('.checkbox_action').each(function () { //loop through each checkbox
                        this.checked = false; //deselect all checkboxes with class "checkbox1"
                    });
                }
            });
	        jQuery('#btn_action').on('click', function (){
		        var taleaux_id = [];
		        $action = jQuery("#select_valid_btn").find(":selected").attr('value');
		        jQuery('.checkbox_action').each(function () { //loop through each checkbox
			        if(jQuery(this).is(':checked')){
				        taleaux_id.push(jQuery(this).attr('id'));
			        }
		        });
		        if(taleaux_id.length != 0 && $action != 0){
					console.log($action);
			        switch ($action){
				        case 'activate':
					        if(confirm("Voulez vous vraiment activer ?")){
						        modify_status(taleaux_id, 2);
					        }
					        break;
				        case 'desactivate':
					        if(confirm("Voulez vous vraiment desactiver ?")) {
						        modify_status(taleaux_id, 1);
					        }
					        break;
				        case 'delete':
					        if(confirm("Voulez vous vraiment supprimer ?")) {
						        modify_status(taleaux_id, 0);
					        }
					        break;
			        }
		        }

	        });
        });
</script>

<?php
echo "<p><a href='?page=".$_GET['page']."&a=add'>";
echo '<button class="button button-primary">Ajouter un tournoi</button>';
echo "</a></p>";
$all_tournament = get_tournament_spec(0,$a_we_need);
// netoyage !!
foreach($all_tournament as $k155 => $data55){
    foreach($data55 as $k155dd => $dadadada) {
        $all_tournament[$k155][$k155dd] = htmlspecialchars_decode(stripslashes($dadadada));
    }
}
echo "<table id='table_tournament' class='widefat'>";
echo "<thead>";
echo "<tr>";
foreach($a_we_need_lang as $key => $value){
	if($key != 'group_action'){
		echo "<th>".$value."</th>";
	}else{
		echo "<td>".$value."</td>";
	}

}
echo "</tr>";
echo "</thead>";
echo "<tbody>";
foreach($all_tournament as $key => $a_data_tournament){
    // recuperation du nombre de gens qui inscript en attente !
    $a_en_attente = get_team_spec(0 , 'id' , array(  'status' => 1 , 'id_tournament' => $a_data_tournament['id']));

    echo "<tr>";
	echo "<td><input type='checkbox' class='checkbox_action' id='".$a_data_tournament['id']."' name='check-".$a_data_tournament['id']."'></td>";
    echo "<td>".$a_data_tournament['name']."</td>";
    echo "<td>".$a_data_tournament['size']."</td>";
    echo "<td>".$a_data_tournament['nb_player']."</td>";
    echo "<td>".$a_data_tournament['nb_remplacant']."</td>";
    echo "<td>".$a_data_tournament['time_check']."</td>";
    echo "<td>".$a_data_tournament['time_start']."</td>";
    echo "<td>".substr($a_data_tournament['date'],0,-9)."</td>";
    echo "<td>";
    if(count($a_en_attente) > 0 ){
        echo "<b style='color:white; background-color:red; border: 3px red outset; padding:3px'>".count($a_en_attente)."</b>";
    }else{
        echo count($a_en_attente);
    }
    echo "</td>";
    echo "<td>";
        if($a_data_tournament['status'] == 1){
	        echo "<a class='button' href='#' onclick='modify_status(".$a_data_tournament['id'].",2);'><span class='smfr_god_icon16  smfr_god_deactivate smfr_god_icon_center'></span></a>";
        }
        else{
            echo "<a class='button' href='#' onclick='modify_status(".$a_data_tournament['id'].",1);'><span class='smfr_god_icon16  smfr_god_activate smfr_god_icon_center'></span></a>";
        }
    echo "</td>";
    echo "<td><a class='button' href='?page=".$_GET['page']."&a=print&id=".$a_data_tournament['id']."'><span class='smfr_god_icon16 smfr_god_print smfr_god_icon_center'></span></a></td>";
    echo "<td><a class='button' href='?page=".$_GET['page']."&a=view&id=".$a_data_tournament['id']."'><span class='smfr_god_icon16 smfr_god_view smfr_god_icon_center'></span></a></td>";
    echo "<td><a class='button' href='?page=".$_GET['page']."&a=update&id=".$a_data_tournament['id']."'><span class='smfr_god_icon16 smfr_god_update smfr_god_icon_center'></span></a></td>";
    echo "<td><a class='button' href='#' onclick='modify_status(".$a_data_tournament['id'].",0);'><span class='smfr_god_icon16 smfr_god_delete smfr_god_icon_center'></span></a></td>";
    echo "</tr>";
}
echo "</tbody>";
echo "</table>";
echo 'Action : ';
echo "<select id='select_valid_btn' name='action'>";
echo "<option value='0'>Action ...</option>";
echo "<option value='activate'>Activer</option>";
echo "<option value='desactivate'>Desactiver</option>";
echo "<option value='delete'>Supprimer</option>";
echo "</select>";
echo "<input type='button' id='btn_action' class='button button-primary' value='Ok'>";