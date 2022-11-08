<?php

if(isset($_POST) && !empty($_POST)){

	$a_id = array();
	// on cherche tout les check-XX , XX => id
	foreach($_POST as $key => $value){
		if(preg_match('/check-(.*)/', $key)){
			$key = str_replace('check-','',$key);
			$a_id[] = $key;
		}
	}

	if(isset($_POST['delete'])){
		foreach($a_id as $key => $id){
			status_tournament_spec($id,'0');
		}
	}
	if(isset($_POST['desactivate'])){
		foreach($a_id as $key => $id){
			status_tournament_spec($id,'1');
		}
	}
	if(isset($_POST['activate'])){
		foreach($a_id as $key => $id){
			status_tournament_spec($id,'2');
		}
	}

	$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	?>
	<script>
		window.location = "<?php echo $url; ?>";
	</script>
<?php

}

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
	'group_action' => 'Action'
	//'' => '',
	//'' => '',
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

		function delete_tm(p_id) {
			if (confirm("Voulez-vous vraiment supprimer ?")) { // Clic sur OK
				jQuery.post(
					ajaxurl,
					{
						'action': 'smfr_tournament_delete',
						'id': p_id,
						'status': 0
					},
					function (response) {
						location.reload();
					}
				);
			}
		}
		jQuery(document).ready(function() {
			var i = 0;
			jQuery('input:checkbox').each(function () { //loop through each checkbox
				if(jQuery(this).is(':checked') == true){
					i++;
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
			// special var avec l'id checkbox select !
			jQuery('.checkbox_action').on("click", function () {
				if(jQuery(this).is(':checked') == true){
					console.log(jQuery(this).attr('name'));
				}
			});
		});
	</script>

<?php
echo "<p><a href='?page=".$_GET['page']."&a=add'>";
echo '<button class="button button-primary">Ajouter un tournoi</button>';
echo "</a></p>";
echo "<form method='post' action=''>";
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
	echo "<th>".$value."</th>";
}
echo "</tr>";
echo "</thead>";
echo "<tbody>";
foreach($all_tournament as $key => $a_data_tournament){
	// recuperation du nombre de gens qui inscript en attente !
	$a_en_attente = get_team_spec(0 , 'id' , array(  'status' => 1 , 'id_tournament' => $a_data_tournament['id']));

	echo "<tr>";
	echo "<td>".$a_data_tournament['name']."</td>";
	echo "<td>".$a_data_tournament['size']."</td>";
	echo "<td>".$a_data_tournament['nb_player']."</td>";
	echo "<td>".$a_data_tournament['nb_remplacant']."</td>";
	echo "<td>".$a_data_tournament['time_check']."</td>";
	echo "<td>".$a_data_tournament['time_start']."</td>";
	echo "<td>".substr($a_data_tournament['date'],0,-9)."</td>";
	echo "<td>";
	if(count($a_en_attente) > 0 ){
		echo "<b style='color:red; border: 1px red dashed; padding:3px'>".count($a_en_attente)."</b>";
	}else{
		echo count($a_en_attente);
	}
	echo "</td>";
	echo "<td>";
	if($a_data_tournament['status'] == 1){
		echo "<a class='smfr_god_icon16 smfr_god_activate' href='#' onclick='modify_status(".$a_data_tournament['id'].",2);'></a>";
	}
	else{
		echo "<a class='smfr_god_icon16 smfr_god_deactivate' href='#' onclick='modify_status(".$a_data_tournament['id'].",1);'></a>";
	}
	echo "</td>";
	echo "<td><a class='smfr_god_icon16 smfr_god_print' href='?page=".$_GET['page']."&a=print&id=".$a_data_tournament['id']."'></a></td>";
	echo "<td><a class='smfr_god_icon16 smfr_god_view' href='?page=".$_GET['page']."&a=view&id=".$a_data_tournament['id']."'></a></td>";
	echo "<td><a class='smfr_god_icon16 smfr_god_update' href='?page=".$_GET['page']."&a=update&id=".$a_data_tournament['id']."'></a></td>";
	echo "<td><a class='smfr_god_icon16 smfr_god_delete' href='#' onclick='delete_tm(".$a_data_tournament['id'].");'></a></td>";
	echo "<td><input type='checkbox' class='checkbox_action' name='check-".$a_data_tournament['id']."'></td>";
	echo "</tr>";
}
echo "</tbody>";
echo "</table>";

echo "<table>";
echo "<tr>";
echo "<td colspan='3' style='text-align:center;'>";
echo "<h2>Action</h2>";
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td colspan='3' style='text-align:center;'>";
echo 'Cliquer ici selectionne toute les checkboxs action <input type="checkbox" id="checkall" name="checkall">';
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>";
echo "<input class='button button-primary' type='submit' name='delete' value='Supprimer'>";
echo "</td>";
echo "<td>";
echo "<input class='button button-primary' type='submit' name='desactivate' value='Désactiver'>";
echo "</td>";
echo "<td>";
echo "<input class='button button-primary' type='submit' name='activate' value='Activer'>";
echo "</td>";
echo "</tr>";
echo "</table>";
echo "</form>";