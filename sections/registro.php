<?php 

require_once ("include/class.resultado.php");
require_once ("include/class.db.php");
require_once ("include/class.usuario.php");
require_once ("include/class.partido.php");
date_default_timezone_set("CST6CDT");

$db = new db();


$todos = new partido();
$todos -> loadAll();

$results = new resultado();
$results->loadIf(array("usuario" => $_SESSION["id"]));

$res = array();
while($results->next()){
	$res[$results->partido] =  array("local" => $results->local , "visitante" => $results->visitante, "puntos" => $results->puntos);
};

	$db = new db();
	$as = $db->GetAll("Select id from partidos where fechahora > '".date("Y-m-d H:i:s")."' order by fechahora asc limit 2");

	$next = array();
	
	foreach($as as $r){
		$next[] = $r["id"];
	}

$jornadas = $db->GetAll("select grupo from partidos group by grupo order by grupo asc");

?>

<div class='span12'>
	<h2> Registra tus marcadores </h2>

    <div class="pagination pagination-large">
    <ul>
    <? foreach($jornadas as $jornada) {
    	if($jornada["grupo"] == $jornadas[count($jornadas)-1]["grupo"]){
    		$active = "active";
			$jornada_actual = $jornada["grupo"];
    	} else {
    		$active = "";
    	}
    ?>	
	   <li class='pagina <?= $active ?>'><a class='pagina_a' data-id='<?= $jornada["grupo"] ?>' href="#" ><?= $jornada["grupo"] ?></a></li>
    <? } ?>
    </ul>
    </div>
 
			<form action="index_p.php" method="post">
				<?
				$grupo = "";
				$jornada = 0;
				while ($todos -> next()) {
					
				 	
					if ($grupo != $todos -> grupo) {
						$grupo = $todos -> grupo;
						
						if($jornada > 0){
							$todos->closeGrupo();
						}
						$todos -> printGrupo(null, $jornada_actual);
						$jornada++;
						
					}

					$todos -> printPartido($res, true , $next);
				}
				?>
			<input type='submit' class='btn btn-primary' value="Guardar" />
			</form>
			
</div>

<script src="/js/registro.js"></script>