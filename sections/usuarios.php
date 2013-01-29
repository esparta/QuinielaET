<?php
require_once ('include/class.resultado.php');
require_once ('include/class.db.php');
require_once ('include/class.usuario.php');
require_once ('include/class.partido.php');
date_default_timezone_set('CST6CDT');

$db = new db();

$U = new usuario($_GET['usuario']);

if (!$U -> usuario)
	die("Usuario invalido. <a href='/'> Volver </a>");

$results = new resultado();
$results -> loadIf(array('usuario' => $U -> id));

$res = array();
while ($results -> next()) {
	$res[$results -> partido] = array('local' => $results -> local, 'visitante' => $results -> visitante, 'puntos' => $results -> puntos);
};

$jornadas = $db -> GetAll("select grupo from partidos group by grupo order by grupo asc");
?>

<div class='span12'>
	
		<a href='/ranking' class="btn btn-primary btn-large">
		 Regresar 
	</a> 
	
	<h2> Marcadores de @<?= $U -> usuario ?></h2>

    <div class="pagination pagination-small">
    <ul>
    <? foreach($jornadas as $jornada) {
    	if($jornada["grupo"] == $jornadas[count($jornadas)-1]["grupo"]){
    		$active = "active";
			$jornada_actual = $jornada["grupo"];
    	} else {
    		$active = "";
    	}
    ?>	
	   <li class='pagina <?= $active ?>'><a class='pagina_a' data-id='<?= $jornada["grupo"] ?>' href="#" ><?= str_ireplace("Jornada", "J", $jornada["grupo"]) ?></a></li>
    <? } ?>
    </ul>
    </div>
    


    <?
	foreach ($jornadas as $jornada) {

		$todos = new partido();
		$todos -> loadIf(array("grupo" => $jornada["grupo"]));

		$actual = $jornada_actual == $jornada["grupo"] ? "actual" : "";
		echo "<div class='jornada $actual' data-jornada='{$jornada["grupo"]}'>";
		echo '<h3 class="grupo_header">'.$jornada["grupo"].' </h3>';		
		while ($todos -> next()) {

			if ($grupo != $todos -> grupo) {
				$grupo = $todos -> grupo;

			}

			$past = strtotime($todos -> fechahora) < time() ? true : false;

			$puntos = isset($res[$todos -> id]["puntos"]) ? $res[$todos -> id]["puntos"] : "notset";

			$pointsClass = "";
			if ($puntos == 1)
				$pointsClass = "badge-warning";
			if ($puntos == 3)
				$pointsClass = "badge-success";

			$badge = $past ? "<span class='badge-puntos badge $pointsClass '> $puntos </span>" : "";
			$pronostico = $past ? $res[$todos -> id]['local'] . " - " . $res[$todos -> id]['visitante'] : "";

			echo "			<div id='fila_1' class='fila'>
			<span class='date'> {$todos->fecha} </span>
			<span class='time'> {$todos->hora} </span>
			<span class='teamsro'> <span class='local'>
					" . $todos -> printFlag($todos -> local) . " {$todos->local} </span> <span class='result'> " . $todos -> printResult() . " </span> <span class='visitante'> {$todos->visitante} 
					" . $todos -> printFlag($todos -> visitante) . "
				</span> </span>
			<span class='pronostico'> " . $pronostico . "</span>
								
			<span class='points'> $badge  </span> </div>
					";
		}
		echo "</div>";
	}
	?>
	</form>
</div>

<script src='/js/registro.js'></script>