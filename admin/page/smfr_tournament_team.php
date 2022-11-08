<?php

$id_tournament = $_GET['id'];

if(isset($_POST) && !empty($_POST)){

    $a_id = array();
    $pattern = '/check-(.*)/';
    // on cherche tout les check-XX , XX => id
    foreach($_POST as $key => $value){
        if(preg_match($pattern, $key)){
            $key = str_replace('check-','',$key);
            $a_id[] = $key;
        }
    }

    if(isset($_POST['delete'])){
        foreach($a_id as $key => $id){
            status_team_spec($id,'0');
        }
    }
    if(isset($_POST['desactivate'])){
        foreach($a_id as $key => $id){
            status_team_spec($id,'1');
        }
    }
    if(isset($_POST['activate'])){
        foreach($a_id as $key => $id){
            status_team_spec($id,'2');
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
    2 => 'created_at',
    3 => 'status',
);
$a_we_need_lang = array(
	'group_action' => '<input type="checkbox" id="checkall" name="checkall">',
    'name' => 'Nom de team',
    'created_at' => 'created at',
	'team' => 'Team',
    'status' => 'Statut',
    'update' => 'Modifier',
    'delete' => 'Supprimer',

);

$whereid = array(
    'id_tournament' => $id_tournament,
);

$all_team = get_team_spec(0 , $a_we_need , $whereid );

foreach($all_team as $k155 => $data55){
	foreach($data55 as $k155dd => $dadadada) {
		$all_team[$k155][$k155dd] = html_entity_decode(stripslashes($dadadada));
	}
}


?>
<script type="text/javascript">
    function modify_team_status(p_id,p_status) {
	    var name = "";
	    switch(p_status){
		    case 0:
			    name = "supprimer";
			    break;
		    case 1:
			    name = "desactiver";
			    break;
		    case 2:
			    name = "activer";
			    break;
	    }
	    if(confirm("Voulez vous vraiment "+name+" ?")) {
		    jQuery.post(
			    ajaxurl,
			    {
				    'action': 'smfr_tournament_team_status',
				    'id': p_id,
				    'status': p_status
			    },
			    function (response) {
				    location.reload();
			    }
		    );
	    }
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
						    modify_team_status(taleaux_id, 2);
					    }
					    break;
				    case 'desactivate':
					    if(confirm("Voulez vous vraiment desactiver ?")) {
						    modify_team_status(taleaux_id, 1);
					    }
					    break;
				    case 'delete':
					    if(confirm("Voulez vous vraiment supprimer ?")) {
						    modify_team_status(taleaux_id, 0);
					    }
					    break;
			    }
		    }

	    });
    });
</script>
<?php

echo "<p><a href='?page=".$_GET['page']."'><button class='button button-primary'>Retour a la liste des tournois</button></a></p>";

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
foreach($all_team as $key => $a_team){
    // recup de tout les joueurs de cette team !
    $html_team = "";
    $a_team_player = get_player_spec(0 , array( 0 => 'name' , 1 => 'titulaire') , array('id_team' => $a_team['id']));
	foreach($a_team_player as $k155 => $data55){
		foreach($data55 as $k155dd => $dadadada) {
			$a_team_player[$k155][$k155dd] = htmlentities(stripslashes($dadadada));
		}
	}
    foreach($a_team_player as $key => $data){
        if($data['titulaire'] == 1){
            $html_team .= '<span style="color:red;">'.$data['name'].'</span><br>';
        }else{
            $html_team .= '<span style="color:blue;">'.$data['name'].'</span><br>';
        }
    }
    if(count($a_team_player) == 0 ){
        $html_team .= '<span style="color:blue;">'.$a_team['name'].'</span><br>';
    }
    // on fait le tableaux !
    echo "<tr>";
	echo "<td><input type='checkbox' class='checkbox_action' id='".$a_team['id']."' name='check-".$a_team['id']."'></td>";
    echo "<td>".$a_team['name']."</td>";
    echo "<td>".$a_team['created_at']."</td>";
	echo "<td>".$html_team."</a></td>";
    echo "<td>";
    if($a_team['status'] == 1){
        echo "<a class='button' href='#' onclick='modify_team_status(".$a_team['id'].",2);'><span class='smfr_god_icon16 smfr_god_deactivate smfr_god_icon_center'></span></a>";
        echo "<span style='display: none;'>Hors Ligne</span>";
    }
    else{
        echo "<a class='button' href='#' onclick='modify_team_status(".$a_team['id'].",1);'><span class='smfr_god_icon16 smfr_god_activate smfr_god_icon_center'></span></a>";
        echo "<span style='display: none;'>En Ligne</span>";
    }
    echo "<span style='display: none;'>".$a_team['status']."</span>";
    echo "</td>";
    echo "<td><a class='button' href='?page=".$_GET['page']."&a=update_team&id_team=".$a_team['id']."'><span class='smfr_god_icon16 smfr_god_update smfr_god_icon_center'></span></a></td>";
    echo "<td><a class='button' href='#' onclick='modify_team_status(".$a_team['id'].",0)'><span class='smfr_god_icon16 smfr_god_delete smfr_god_icon_center'></span></a></td>";
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

