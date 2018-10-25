<?php
require ("masterIncludeLogin.inc.php");
// require 'admintickets.php';
$nav = 'inicio';
$subnav = 'home';

echo $_JAVASCRIPT_CSS;

$modulo_activo = 5;
$pagina_activa = 'captura_firma';
?>
<div class="col-sm-12">
	<div class="row">
		<div class="col-sm-12">
			<div class="inner-padding">
				<input type="hidden" id="hdnIdTurno" value="" /> <input
					type="hidden" id="hdnIdT" value="<?php echo $IDT;?>" /> <input
					type="hidden" id="hdnPersona" value="<?php echo $nombrePersona;?>" />
				<input type="hidden" id="hdnCURP" value="<?php echo $CURP;?>" /> <input
					type="hidden" id="hdnPermiso" name="hdnPermiso"
					value="<?php echo $permisos_modulo1; ?>">

				<div id="biometrico_huellas_contenedor">
					<div class="widget" id="biometrico_huellas">
						<header>
							<h2>Captura Huellas</h2>
						</header>
						<div>
							<div class="inner-padding">
								<div class="row">
									<div class="col-sm-12">

										<p>
											Status: <span id="status"></span>
										</p>
										<p>
											Autocapture Status: <span id="autocaptureStatus"></span>
										</p>


									</div>
									<div class="spacer-20"></div>

									<div class="img-responsive" id="divCapturaH"
										style="display: none;"></div>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-12">
							<button type="button" class="btn btn-default pull-right"
								onclick="siguiente_huellas();">Siguiente</button>
						</div>
					</div>
				</div>



				<div class="spacer-50"></div>

				<fieldset>
					<legend>Iris</legend>

					<div class="row">
						<div class="inner-padding img-responsive" id="divCapturaI"
							style="display: none;"></div>
					</div>
				</fieldset>

				<div class="spacer-50"></div>

				<fieldset>
					<legend>Rostro</legend>

					<div class="row">

						<div class="inner-padding img-responsive" id="divCapturaR"
							style="display: none;"></div>

					</div>
				</fieldset>

				<div class="spacer-50"></div>


				<fieldset>
					<legend>Firma</legend>

					<div class="row">
						<div class="col-sm-12 text-center img-responsive" id=""
							style="display:;">
							<div class="col-sm-12" id="divImagen">
								<table border="1" cellpadding="0" width="500">
									<tr>
										<td height="100" width="500">
											<canvas id="cnv" name="cnv" width="500" height="100"></canvas>
										</td>
									</tr>
								</table>

								<canvas name="SigImg" id="SigImg" width="500" height="100"></canvas>

								<!--<INPUT TYPE=HIDDEN NAME="base64">-->
								<TEXTAREA NAME="base64" id="base64" ROWS="20" COLS="50">Base64 String: </TEXTAREA>
								<input type="hidden" id="idPersona"
									value="<?php echo $idPersona; ?>" />
							</div>
							<div class="spacer-30"></div>
							<div class="col-sm-12 text-center">
								<button class="btn btn-success" id="btnFirmar">Firmar</button>
								<button class="btn btn-primary btnSubir ">Guardar</button>
								<button class="btn btn-info" id="btnSig">Siguiente</button>
							</div>

						</div>
					</div>
				</fieldset>

              <div id="biometrico_iris_contenedor" style="display:none;">
          <div class="col-sm-12">
          	<div class="row">
          		<div class="col-sm-12">
          			<div class="inner-padding">
        
          				<div class="widget" id="biometrico_iris">
          					<header><h2>Captura Iris</h2></header>
                    <div>
                      <div class="inner-padding">
              					<div class="row">
              						<div class="inner-padding img-responsive" id="divCapturaI"
              							style="display: none;"></div>
              					</div>
                      </div>
                    </div>
          				</div>
                  <div class="row">
          					<div class="col-sm-12">
          						<button type="button" class="btn btn-default pull-right" onclick="siguiente_iris();">Siguiente</button>
          					</div>
          				</div>        
                </div>
              </div>
            </div>
          </div>
        </div>
        <div id="biometrico_rostro_contenedor" style="display:none;">
          <div class="col-sm-12">
          	<div class="row">
          		<div class="col-sm-12">
          			<div class="inner-padding">
          				<div class="widget" id="biometrico_rostro">
          					<header><h2>Captura Foto</h2></header>
                    <div>
                      <div class="inner-padding">
              					<div class="row">
              
              						<div class="inner-padding img-responsive" id="divCapturaR"
              							style="display: none;"></div>
              
              					</div>
                      </div>
                    </div>
          				</div>
                  <div class="row">
          					<div class="col-sm-12">
          						<button type="button" class="btn btn-default pull-right" onclick="siguiente_foto();">Siguiente</button>
          					</div>
          				</div>                  
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <div id="biometrico_firma_contenedor" style="display:none;">
          <div class="col-sm-12">
          	<div class="row">
          		<div class="col-sm-12">
          			<div class="inner-padding">
                  <div class="widget" id="biometrico_firma">
          					<header><h2>Captura Firma</h2></header>
                    <div>
                      <div class="inner-padding">
              					<div class="row">
              						<div class="col-sm-12 text-center img-responsive" id=""
              							style="display:;">
              							<div class="col-sm-12" id="divImagen">
              								<table border="1" cellpadding="0" width="500">
              									<tr>
              										<td height="100" width="500">
              											<canvas id="cnv" name="cnv" width="500" height="100"></canvas>
              										</td>
              									</tr>
              								</table>
              								<!--<INPUT TYPE=HIDDEN NAME="base64">-->
              								<TEXTAREA NAME="base64" id="base64" ROWS="20" COLS="50">Base64 String: </TEXTAREA>
              								<input type="hidden" id="idPersona"
              									value="<?php echo $idPersona; ?>" />
              							</div>
              							<div class="spacer-30"></div>
              							<div class="col-sm-12 text-center">
              								<button class="btn btn-success" id="btnFirmar">Firmar</button>
              								<button class="btn btn-primary btnSubir ">Guardar</button>
              								<button class="btn btn-info" id="btnSig">Siguiente</button>
              							</div>
              
              						</div>
                        </div>
                      </div>
          					</div>
                  </div>
                  <div class="row">
          					<div class="col-sm-12">
          						<button type="button" class="btn btn-default pull-right" onclick="siguiente_firma();">Siguiente</button>
          					</div>
          				</div>                  
                </div>
              </div>
            </div>
  				</div>
        </div>
        
        

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
