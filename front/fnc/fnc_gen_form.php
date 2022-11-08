<?php

function smfr_tournament_gen_form($a_tournament,$post,$error){

    $nb_player = $a_tournament['nb_player'];
    $nb_remplacant = $a_tournament['nb_remplacant'];

    if(empty($a_tournament['url_reglement'])){
        $a_tournament['url_reglement'] = '#';
    }
    if(empty($a_tournament['url_bracket'])){
        $a_tournament['url_bracket'] = '#';
    }

    // initialize
    $a_temp_error = array();

    // reformatage des erreurs en field => rule !
    if(isset($error) && !empty($error)) {
        foreach ($error as $key => $value) {
            $a_temp_error[$value['field']] = $value['rule'];
        }
    }

    // on decode le post on on enelve les / \
    if (isset($post) && !empty($post)) {
        foreach ($post as $key => $data) {
            $post[$key] = htmlspecialchars_decode(stripslashes(htmlentities($data)));
        }
    }

    // notre form en html !
    $html = '<table>';
    // bool qui nous servira a controller
    $bool = true;
    // bool 1vs1
    $bool_one = false;
    // si il y a au moins des joueurs !
    if(empty($nb_player) || $nb_player == 0 ){
        $bool = false;
    }
    // si c'est du 1vs1
    if(!empty($nb_player) && $nb_player == 1 ){
        $bool_one = true;
        $bool = false;
    }
    // on gen si c'est ok !
    if($bool){

        $html .= '<tr>';
        $html .= '<td>';
        $html .= '<label for="team">Nom de team(<b style=\'color:red;\'>*</b>)</label>';
        $html .= '</td>';
        $html .= '<td>';
        $html .= '<input name="team" id="team" ';
        if(isset($post['team']) && !empty($post['team'])){
            $html .= 'value="'.$post['team'].'" ';
        }
        if(isset($a_temp_error['team'])){
            $html .= 'class="failure" ';
        }
        $html .= ' maxlength="50" >';
        if(isset($a_temp_error['team'])){
            $html .= '<span style="color:red;">  Le champs n\'est pas rempli correctement ! </span>';
        }
        $html .= '</td>';
        $html .= '</tr>';
        for($i = 1 ; $i <= $nb_player ; $i++){
            $html .= '<tr>';
            $html .= '<td>';
            $html .= '<label for="player_'.$i.'">Joueur n°'.$i." (<b style='color:red;'>*</b>)</label>";
            $html .= '</td>';
            $html .= '<td>';
            $html .= '<input name="player_'.$i.'" id="player_'.$i.'" ';
            if(isset($post['player_'.$i]) && !empty($post['player_'.$i])){
                $html .= 'value="'.$post['player_'.$i].'" ';
            }
            if(isset($a_temp_error['player_'.$i])){
                $html .= 'class="failure" ';
            }
            $html .= ' maxlength="50" >';
            if(isset($a_temp_error['player_'.$i])){
                $html .= '<span style="color:red;">  Le champs n\'est pas rempli correctement ! </span>';
            }
            $html .= '</td>';
            $html .= '</tr>';
        }
        for($i = 1 ; $i <= $nb_remplacant ; $i++){
            $html .= '<tr>';
            $html .= '<td>';
            $html .= '<label for="ramplacant_'.$i.'">Remplaçant n°'.$i.'</label>';
            $html .= '</td>';
            $html .= '<td>';
            $html .= '<input name="ramplacant_'.$i.'" id="ramplacant_'.$i.'" ';
            if(isset($post['ramplacant_'.$i]) && !empty($post['ramplacant_'.$i])){
                $html .= 'value="'.$post['ramplacant_'.$i].'" ';
            }
            if(isset($a_temp_error['ramplacant_'.$i])){
                $html .= 'class="failure" ';
            }
            $html .= ' maxlength="50" >';
            $html .= '</td>';
            $html .= '</tr>';
        }
    }

    if($bool_one){
        $html .= '<table>';
        $html .= '<tr>';
        $html .= '<td>';
        $html .= '<label for="team">Joueur n°1(<b style=\'color:red;\'>*</b>)</label>';
        $html .= '</td>';
        $html .= '<td>';
        $html .= '<input name="team" id="team" ';
        if(isset($post['team']) && !empty($post['team'])){
            $html .= 'value="'.$post['team'].'" ';
        }
        if(isset($a_temp_error['team'])){
            $html .= 'class="failure" ';
        }
        $html .= ' maxlength="50" >';
        if(isset($a_temp_error['team'])){
            $html .= '<span style="color:red;">  Le champs n\'est pas rempli correctement !</span>';
        }
        $html .= '</td>';
        $html .= '</tr>';
    }
    $html .= '<tr>';
    $html .= '<td>';
    $html .= "<label for='reglement' ><a href='".$a_tournament['url_reglement']."'>J'affirme avoir pris connaissance du règlement</a></label>";
    $html .= '</td>';
    $html .= '<td>';
    $html .= "<input type='checkbox' name='reglement' id='reglement' ";
    if(isset($post['reglement']) && $post['reglement'] == 'on'){
        $html .= "checked";
    }
    $html .= " >";
    if(isset($a_temp_error['reglement'])) {
        $html .= '<span style="color:red;">  Le champs n\'est pas rempli correctement !</span>';
    }
    $html .= '</td>';
    $html .= '</tr>';
    $html .= '</table>';
    return $html;
}