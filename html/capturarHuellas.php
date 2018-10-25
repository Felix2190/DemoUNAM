<?php
require ("masterIncludeLogin.inc.php");
// require 'admintickets.php';
$nav = 'inicio';
$subnav = 'home';
echo $_JAVASCRIPT_CSS;
$modulo_activo = 5;
$pagina_activa = 'captura_huella';
?>
<div class="col-sm-12">
	<div class="row">
		<div class="col-sm-12">
			<div class="inner-padding">
				<input type="hidden" id="hdnIdTurno" value="<?php echo $_SESSION['idTurno']; ?>" /> 
				<!-- 
				<input
					type="hidden" id="hdnIdT" value="<?php echo $_SESSION['idTurno']; ?> /> <input
					type="hidden" id="hdnPersona" value="<?php echo $nombrePersona;?>" />
				<input type="hidden" id="hdnCURP" value="<?php echo $CURP;?>" /> <input
					type="hidden" id="hdnPermiso" name="hdnPermiso"
					value="<?php echo $permisos_modulo1; ?>">
 -->
 			<input type="hidden" value="<?php echo $_SESSION['passUser'];?>" id="hdnPass"/>
<!-- 
					<div class="widget" id="biometrico_huellas">
						<header>
							<h2>Captura Huellas</h2>
						</header>
						<div>  -->
							<!--<div class="inner-padding">-->
								<div class="row">
									<div class="col-sm-12">

										<p>
											Estatus: <span id="status"></span>
										</p>
										<p>
											Mensajes de Captura: <span id="autocaptureStatus"></span>
										</p>

									</div>

									<div class="img-responsive" id="divCapturaH"
										style="display: none;"></div>
										
										
									<!--<div class="col-sm-12 inner-padding"><a type="button" class="btn btn-default pull-right" onclick="sig();" >Siguiente</a>
									</div>-->
								</div>
							<!--</div>-->
 <!-- 						</div>
					</div>
 -->
	


				<div class="spacer-30"></div>


			</div>
			<!-- End .inner-padding -->
		</div>
	</div>
	<!-- End .row -->
</div>

<script src="js/lib/aware/es6-promise/es6-promise.js"></script>
<script src="js/lib/aware/biocomponents/aw_fingerprint_capture.js"></script>
<script src="js/lib/aware/biocomponents/aw_fingerprint_set.js"></script>
<script src="js/lib/aware/biocomponents/WebsocketTransport.js"></script>
<script src="js/lib/aware/binary-file-saver/BinaryFileSaver.js"></script>
<script src="js/lib/aware/fingerprint_capture_complete.js"></script>


<a data-toggle="modal" id="_alertShow" style="display: none"
	class="btn btn-danger" role="button" href="#_alertBox">Alert</a>
<div class="modal fade" id="_alertBox" tabindex="-1" role="dialog"
	aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-hidden="true" id="_alertCloseUp">&times;</button>
				<h4 class="modal-title" id="_alertTitle"></h4>
			</div>
			<div class="modal-body">
				<p id="_alertBody"></p>
			</div>
			<div class="modal-footer">
				<button class="btn btn-default" data-dismiss="modal"
					id="_alertClose">OK</button>
			</div>
		</div>
	</div>
</div>
