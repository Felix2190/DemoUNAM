<?php
	require("masterIncludeLogin.inc.php");
	//$nav = 'inicio';
	//$subnav = 'home';
//	$nav='';
	$__pasoActual='datos';  //turno, tramite, pago, datos, documentos,verificacion, examen, impresion
	
	
	$__pasoSubseccion='huellas';
?>

	
	   

    

	      <style type="text/css">
.img-responsive img {
max-width: 100%;
height: auto;   
display:block;
	    }
	    </style>
    <?php
			echo $_JAVASCRIPT_CSS;
		?>

                            	<div class="col-sm-12">
                                    <div class="subheading">
										</div>
										<input type="hidden" id="hdnIdTurno" value=""/> 
										<input type="hidden" id="hdnIdT" value="<?php echo $IDT;?>"/>
										<input type="hidden" id="hdnPersona" value="<?php echo $nombrePersona;?>"/>
										<input type="hidden" id="hdnCURP" value="<?php echo $CURP;?>"/>
										<input type="hidden" id="hdnPermiso" name="hdnPermiso" value="<?php echo $permisos_modulo1; ?>">
										<img alt="" style="-" src="">
										<div class="inner-padding">
										
										<?php if ($IDT==0):?>
										<table class="table" id="tablesorting-1">
											<thead>
												<tr>
													<th>Id turno</th>
													<th>Turno externo</th>
													<th colspan="2">Nombre</th>
													<th>Fecha</th>
													<th>Opciones</th>
 												</tr>
											</thead>
											<tbody>
											</tbody>
											<tfoot>
												<tr>
													<td colspan="6" class="pager form-horizontal">
														<button class="btn first"><i class="fa fa-step-backward"></i></button>
														<button class="btn prev"><i class="fa fa-arrow-left"></i></button>
														<span class="pagedisplay"></span> <!-- this can be any element, including an input -->
														<button class="btn next"><i class="fa fa-arrow-right"></i></button>
														<button class="btn last"><i class="fa fa-step-forward"></i></button>
														<select class="pagesize input-xs" title="Select page size">
															<option value="10">10</option>
															<option value="20">20</option>
															<option value="30">30</option>
															<option selected="selected" value="40">40</option>
														</select>
														<select class="pagenum input-xs" title="Seleccione P&aacute;gina"></select>
													</td>
												</tr>
											</tfoot>
								</table>
								<div class="spacer-50"></div>
								
								
								<?php endif;
								?>
								
								
								<div id="verificaC"></div>
								
								<fieldset>
								<legend>Captura Biom&eacute;ticos</legend>
						
							<div class="row">
							 <div class="inner-padding img-responsive" id="divCapturaH" style="display: none;">
                                                     
                                                </div>
								</div>
								</fieldset>
								</div>
								
						                                  	
                                    <!-- End .inner-padding -->  
                                </div>
                       