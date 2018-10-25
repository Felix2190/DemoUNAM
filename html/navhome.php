<?php include 'activarmenus.php';//var_dump($_SESSION);
//print_r($seccion); print_r($subseccion);
//echo '</pre>';
?>
<div class="sidebar-module">
	<nav class="sidebar-nav-v2">
		<ul>
			<?php if($seccion=="inicio"):?>
			<li <?php if ($subseccion=="dashboard"){echo 'class="page-arrow active-page"';}?>>
				<a href="dashboard.php">
				<i class="fa fa-home"></i> Credencial
				</a>
			</li>
			<?php endif;?>
  		<?php if($seccion=="reglas"):?>
      <?php if($permisos_usuarios>0){ ?>
  			<li <?php if ($subseccion=="listadoUsuarios" || $subseccion=="generarUsuario" || $subseccion=="usuario"){echo 'class="menu-open"';}?>>
  				<a href="#">
  				<i class="fa fa-sort-alpha-asc"></i> Usuarios
  				<i class="fa fa-caret-left pull-right"></i>
  				</a>
  				<ul>
  					<li <?php if ($subseccion=="listadoUsuarios" || $subseccion=='usuario'){echo 'class="page-arrow active-page"';}?>>
  						<a href="listadoUsuarios.php">
  						<i class="fa fa-sort-alpha-asc"></i> Listado
  						</a>
  					</li>
            <?php if($permisos_usuarios==4 || $permisos_usuarios==5 || $permisos_usuarios==6 || $permisos_usuarios==7 || $permisos_usuarios==12 || $permisos_usuarios==13 || $permisos_usuarios==14 || $permisos_usuarios==15){ ?>
    					<li <?php if ($subseccion=="generarUsuario"){echo 'class="page-arrow active-page"';}?>>
    						<a href="generarUsuario.php">
    						<i class="fa fa-plus"></i> Generar usuario
    						</a>
    					</li>
  					<?php } ?>
  				</ul>
  			</li>
      <?php } ?>
      <?php if($permisos_roles>0){ ?>
  			<li <?php if ($subseccion=="listadoRoles" || $subseccion=="generarRol" || $subseccion=="rol"){echo 'class="menu-open"';}?>>
  				<a href="#">
  				<i class="fa fa-sort-alpha-asc"></i> Roles
  				<i class="fa fa-caret-left pull-right"></i>
  				</a>
  				<ul>
  					<li <?php if ($subseccion=="listadoRoles" || $subseccion=='rol'){echo 'class="page-arrow active-page"';}?>>
  						<a href="listadoRoles.php">
  						<i class="fa fa-sort-alpha-asc"></i> Listado
  						</a>
  					</li>
            <?php if($permisos_roles==4 || $permisos_roles==5 || $permisos_roles==6 || $permisos_roles==7 || $permisos_roles==12 || $permisos_roles==13 || $permisos_roles==14 || $permisos_roles==15){ ?>
    					<li <?php if ($subseccion=="generarRol"){echo 'class="page-arrow active-page"';}?>>
    						<a href="generarRol.php">
    						<i class="fa fa-plus"></i> Generar rol
    						</a>
    					</li>
  					<?php } ?>
  				</ul>
  			</li>

      <?php } ?>
      <?php if($permisos_recaudacion>0){ ?>
  			<li <?php if ($subseccion=="listadoRecaudaciones" || $subseccion=="generarRecaudacion" || $subseccion=="recaudacion"){echo 'class="menu-open"';}?>>
  				<a href="#">
  				<i class="fa fa-sort-alpha-asc"></i> Recaudaci&oacute;n
  				<i class="fa fa-caret-left pull-right"></i>
  				</a>
  				<ul>
  					<li <?php if ($subseccion=="listadoRecaudaciones" || $subseccion=='recaudacion'){echo 'class="page-arrow active-page"';}?>>
  						<a href="listadoRecaudaciones.php">
  						<i class="fa fa-sort-alpha-asc"></i> Listado
  						</a>
  					</li>
            <?php if($permisos_recaudacion==4 || $permisos_recaudacion==5 || $permisos_recaudacion==6 || $permisos_recaudacion==7 || $permisos_recaudacion==12 || $permisos_recaudacion==13 || $permisos_recaudacion==14 || $permisos_recaudacion==15){ ?>
    					<li <?php if ($subseccion=="generarRecaudacion"){echo 'class="page-arrow active-page"';}?>>
    						<a href="generarRecaudacion.php">
    						<i class="fa fa-plus"></i> Generar recaudaci&oacute;n
    						</a>
    					</li>
  					<?php } ?>
  				</ul>
  			</li>
      <?php } ?>

      <?php if($permisos_reglas>0){ ?>
  			<li <?php if ($subseccion=="listadoReglasLicencia" || $subseccion=="generarReglaLicencia" || $subseccion=="reglaLicencia"){echo 'class="menu-open"';}?>>
  				<a href="#">
  				<i class="fa fa-sort-alpha-asc"></i> Licencia
  				<i class="fa fa-caret-left pull-right"></i>
  				</a>
  			
  				<ul>
  					<li <?php if ($subseccion=="listadoReglasLicencia" || $subseccion=='reglaLicencia'){echo 'class="page-arrow active-page"';}?>>
  						<a href="listadoReglasLicencia.php">
  						<i class="fa fa-sort-alpha-asc"></i> Listado
  						</a>
  					</li>
            <?php if($permisos_reglas==4 || $permisos_reglas==5 || $permisos_reglas==6 || $permisos_reglas==7 || $permisos_reglas==12 || $permisos_reglas==13 || $permisos_reglas==14 || $permisos_reglas==15){ ?>
    					<li <?php if ($subseccion=="generarReglaLicencia"){echo 'class="page-arrow active-page"';}?>>
    						<a href="generarReglaLicencia.php">
    						<i class="fa fa-plus"></i> Generar regla para licencia
    						</a>
    					</li>
  					<?php } ?>
  				</ul>
  			</li>
      <?php } ?>

      <!--
			<li <?php // if ($subseccion=="listadoDecretos" || $subseccion=="generarTurnos" || $subseccion=="buscarTurnos"){echo 'class="menu-open"';}?>>
				<a href="#">
				<i class="fa fa-sort-alpha-asc"></i> Decretos
				<i class="fa fa-caret-left pull-right"></i>
				</a>
			
				<ul>
					<li <?php // if ($subseccion=="listadoTurnos"){echo 'class="page-arrow active-page"';}?>>
						<a href="#">
						<i class="fa fa-sort-alpha-asc"></i> Listado
						</a>
					</li>
					<li <?php // if ($subseccion=="generarTurnos"){echo 'class="page-arrow active-page"';}?>>
						<a href="#">
						<i class="fa fa-plus"></i> Generar decreto
						</a>
					</li>
					
				</ul>

			</li>   -->
      <?php if($permisos_descuentos>0){ ?>
  			<li <?php if ($subseccion=="listadoReglasDescuento" || $subseccion=="generarReglaDescuento"){echo 'class="menu-open"';}?>>
  				<a href="#">
  				<i class="fa fa-sort-alpha-asc"></i> Descuentos
  				<i class="fa fa-caret-left pull-right"></i>
  				</a>
  			
  				<ul>
  					<li <?php if ($subseccion=="listadoReglasDescuento"){echo 'class="page-arrow active-page"';}?>>
  						<a href="listadoReglasDescuento.php">
  						<i class="fa fa-sort-alpha-asc"></i> Listado
  						</a>
  					</li>
            <?php if($permisos_descuentos==4 || $permisos_descuentos==5 || $permisos_descuentos==6 || $permisos_descuentos==7 || $permisos_descuentos==12 || $permisos_descuentos==13 || $permisos_descuentos==14 || $permisos_descuentos==15){ ?>
    					<li <?php if ($subseccion=="generarReglaDescuento"){echo 'class="page-arrow active-page"';}?>>
    						<a href="generarReglaDescuento.php">
    						<i class="fa fa-plus"></i> Generar descuento
    						</a>
    					</li>
  					<?php } ?>
  				</ul>
  			</li>
      <?php } ?>
	  
	  
	  <?php if($permisos_plasticos>0){ ?>
  			<li <?php if ($subseccion=="listadoPlasticos" || $subseccion=="asignacionPlastico" || $subseccion=="plastico" || $subseccion=="busquedaPlastico"||$subseccion=="busquedaFolio"||$subseccion=="listadoFolios"){echo 'class="menu-open"';}?>>
  				<a href="#">
  				<i class="fa fa-sort-alpha-asc"></i> Pl&aacute;sticos
  				<i class="fa fa-caret-left pull-right"></i>
  				</a>
  			
  				<ul>
  					<li <?php if ($subseccion=="listadoPlasticos" || $subseccion=='plastico'){echo 'class="page-arrow active-page"';}?>>
  						<a href="listadoPlasticos.php">
  						<i class="fa fa-sort-alpha-asc"></i> Listado Entregas 
  						</a>
  					</li>
            <?php if($permisos_plasticos==4 || $permisos_plasticos==5 || $permisos_plasticos==6 || $permisos_plasticos==7 || $permisos_plasticos==12 || $permisos_plasticos==13 || $permisos_plasticos==14 || $permisos_plasticos==15){ ?>
    					<li <?php if ($subseccion=="busquedaPlastico"){echo 'class="page-arrow active-page"';}?>>
    						<a href="busquedaPlastico.php">
    						<i class="fa fa-search"></i> B&uacute;squeda Entregas
    						</a>
    					</li>
  					<?php } ?>
            <?php if($permisos_plasticos==4 || $permisos_plasticos==5 || $permisos_plasticos==6 || $permisos_plasticos==7 || $permisos_plasticos==12 || $permisos_plasticos==13 || $permisos_plasticos==14 || $permisos_plasticos==15){ ?>
    					<li <?php if ($subseccion=="asignacionPlastico"){echo 'class="page-arrow active-page"';}?>>
    						<a href="asignacionPlastico.php">
    						<i class="fa fa-plus"></i> Generar Entrega
    						</a>
    					</li>
  					<?php } ?>
  		  <?php if($permisos_plasticos==4 || $permisos_plasticos==5 || $permisos_plasticos==6 || $permisos_plasticos==7 || $permisos_plasticos==12 || $permisos_plasticos==13 || $permisos_plasticos==14 || $permisos_plasticos==15){ ?>
    					
						
						
						<li <?php if ($subseccion=="listadoFolios" ){echo 'class="page-arrow active-page"';}?>>
  						<a href="listadoFolios.php">
  						<i class="fa fa-sort-alpha-asc"></i> Listado Pl&aacute;sticos
  						</a>
  					</li>
  					<?php }?>
            <?php if($permisos_plasticos==4 || $permisos_plasticos==5 || $permisos_plasticos==6 || $permisos_plasticos==7 || $permisos_plasticos==12 || $permisos_plasticos==13 || $permisos_plasticos==14 || $permisos_plasticos==15){ ?>
						
						
						<li <?php if ($subseccion=="busquedaFolio"){echo 'class="page-arrow active-page"';}?>>
    						<a href="busquedaFolio.php">
    						<i class="fa fa-search"></i> B&uacute;squeda de folio PVC
    						</a>
    					</li>
  					<?php } ?>
  		
            
  				</ul>
  			</li>      <?php } ?>

      <!--
			<li <?php // if ($subseccion=="listadoDecretos" || $subseccion=="generarReglaInciso" || $subseccion=="buscarTurnos"){echo 'class="menu-open"';}?>>
				<a href="#">
				<i class="fa fa-sort-alpha-asc"></i> Incisos
				<i class="fa fa-caret-left pull-right"></i>
				</a>
			
				<ul>
					<li <?php // if ($subseccion=="listadoTurnos"){echo 'class="page-arrow active-page"';}?>>
						<a href="#">
						<i class="fa fa-sort-alpha-asc"></i> Listado
						</a>
					</li>
					<li <?php // if ($subseccion=="dads"){echo 'class="page-arrow active-page"';}?>>
						<a href="#">
						<i class="fa fa-plus"></i> Generar inciso
						</a>
					</li>           -->
					
				</ul>
			</li>
      
      <?php endif;?>
			
			<?php if($seccion=="turnos"):?>
			
			<li <?php if ($subseccion=="listadoTurnos" || $subseccion=="generarTurnos" || $subseccion=="buscarTurnos"  || $subseccion=="asignaTramite" || $subseccion=="crearturno" || $subseccion=="verturnos" || $subseccion=="atenderturno"){echo 'class="menu-open"';}?>>
				<a href="generarTurnos.php">
				<i class="fa fa-ticket"></i> Turno
				</a>

			</li>

			
			<li <?php if ($subseccion=="listadoTurnos" || $subseccion=="generarTurnos" || $subseccion=="buscarTurnos"  || $subseccion=="asignaTramite" || $subseccion=="crearturno" || $subseccion=="verturnos" || $subseccion=="atenderturno"){echo 'class="menu-open"';}?>>
				<a href="#">
				<i class="fa fa-money"></i> Pago
				</a>
	      <ul>
					<li <?php if ($subseccion=="crearturno"){echo 'class="page-arrow active-page"';}?>>
						<a href="#">
						Resumen
						</a>
					</li>
					<li <?php if ($subseccion=="verturnos"){echo 'class="page-arrow active-page"';}?>>
						<a href="#">
						Impresi&oacute;n de pago
						</a>
					</li>
					
				</ul>
			</li> 
      
			<li <?php if ($subseccion=="listadoTurnos" || $subseccion=="generarTurnos" || $subseccion=="buscarTurnos"  || $subseccion=="asignaTramite" || $subseccion=="crearturno" || $subseccion=="verturnos" || $subseccion=="atenderturno"){echo 'class="menu-open"';}?>>
				<a href="generarTurnos.php">
				<i class="fa fa-user"></i> Captura de Datos
				</a>
	      <ul>
					<li <?php if ($subseccion=="crearturno"){echo 'class="page-arrow active-page"';}?>>
						<a href="#">
						 Biogr&aacute;ficos Generales
						</a>
					</li>
					<li <?php if ($subseccion=="verturnos"){echo 'class="page-arrow active-page"';}?>>
						<a href="#">
						Domicilio
						</a>
					</li>
					<li <?php if ($subseccion=="verturnos"){echo 'class="page-arrow active-page"';}?>>
						<a href="#">
						Biom&eacute;trico Huellas
						</a>
					</li>
          <li <?php if ($subseccion=="verturnos"){echo 'class="page-arrow active-page"';}?>>
						<a href="#">
						Biom&eacute;trico Rostro
						</a>
					</li>
          <li <?php if ($subseccion=="verturnos"){echo 'class="page-arrow active-page"';}?>>
						<a href="#">
						Biom&eacute;trico Iris
						</a>
					</li>
				</ul>
			</li>       
      
			<li <?php if ($subseccion=="listadoTurnos" || $subseccion=="generarTurnos" || $subseccion=="buscarTurnos"  || $subseccion=="asignaTramite" || $subseccion=="crearturno" || $subseccion=="verturnos" || $subseccion=="atenderturno"){echo 'class="menu-open"';}?>>
				<a href="#">
				<i class="fa fa-files-o"></i> Documentos
				</a>
	      <ul>
					<li <?php if ($subseccion=="crearturno"){echo 'class="page-arrow active-page"';}?>>
						<a href="#">
						Captura de Doctos.
						</a>
					</li>
					
				</ul>
			</li> 
      
			<li <?php if ($subseccion=="listadoTurnos" || $subseccion=="generarTurnos" || $subseccion=="buscarTurnos"  || $subseccion=="asignaTramite" || $subseccion=="crearturno" || $subseccion=="verturnos" || $subseccion=="atenderturno"){echo 'class="menu-open"';}?>>
				<a href="#">
				<i class="fa fa-check"></i> Verificaci&oacute;n
				</a>
	      <ul>
					<li <?php if ($subseccion=="crearturno"){echo 'class="page-arrow active-page"';}?>>
						<a href="#">
						Verificaci&oacute;n de Datos
						</a>
					</li>
					<li <?php if ($subseccion=="crearturno"){echo 'class="page-arrow active-page"';}?>>
						<a href="#">
						Captura de Firma
						</a>
					</li>
				</ul>
			</li>
      
      <li <?php if ($subseccion=="listadoTurnos" || $subseccion=="generarTurnos" || $subseccion=="buscarTurnos"  || $subseccion=="asignaTramite" || $subseccion=="crearturno" || $subseccion=="verturnos" || $subseccion=="atenderturno"){echo 'class="menu-open"';}?>>
				<a href="#">
				<i class="fa fa-list-ol"></i> Examen
				</a>
	      <ul>
					<li <?php if ($subseccion=="crearturno"){echo 'class="page-arrow active-page"';}?>>
						<a href="#">
						Upload de Examen
						</a>
					</li>
				</ul>
        
      </li>
      
      <li <?php if ($subseccion=="listadoTurnos" || $subseccion=="generarTurnos" || $subseccion=="buscarTurnos"  || $subseccion=="asignaTramite" || $subseccion=="crearturno" || $subseccion=="verturnos" || $subseccion=="atenderturno"){echo 'class="menu-open"';}?>>
				<a href="#">
				<i class="fa fa-print"></i> Impresi&oacute;n
				</a>
        
      </li>
			<?php endif;?>
			
			<?php if($seccion=="licencias"):?>

				<li <?php if ($subseccion=="biometricos" || $subseccion=="documentos" || $subseccion=="moduloii" || $subseccion=="biograficos"|| $subseccion=="listadoIdentidades"|| $subseccion=="edicionBiograficos"){echo 'class="menu-open"';}?>>

					<a href="#">
					<i class="fa fa-suitcase"></i> Modulo I - Datos
					<i class="fa fa-caret-left pull-right"></i>
					</a>
					<ul>
						<li <?php if ($subseccion=="listadoIdentidades"){echo 'class="page-arrow active-page"';}?>>
							<a href="listadoIdentidades.php">
							<i class="fa fa-sort-alpha-asc"></i> Listado
							</a>
						</li>
						<li <?php if ($subseccion=="biograficos"){echo 'class="page-arrow active-page"';}?>>
							<a href="biograficos.php">
							<i class="fa fa-user"></i> Biograficos
							</a>
						</li>
						<li <?php if ($subseccion=="biometricos"){echo 'class="page-arrow active-page"';}?>>
							<a href="biometricos.php">
							<i class="fa fa-eye"></i> Biometricos
							</a>
						</li>
						<li <?php if ($subseccion=="documentos"){echo 'class="page-arrow active-page"';}?>>
							<a href="documentos.php">
							<i class="fa fa-file-text"></i> Documentos
							</a>
						</li>

                                                
					</ul>

				</li>

				<li <?php if ($seccion=="licencias" ||$subseccion=="examenMedico" || $subseccion=="examenTeorico" ){echo 'class="menu-open"';}?>>

					<a href="#">
					<i class="fa fa fa-table"></i> Modulo II - Examenes
					<i class="fa fa-caret-left pull-right"></i>
					</a>
					<ul>
<!--
						<li <?php if ($subseccion=="listadoUsuarios"){echo 'class="page-arrow active-page"';}?>>
							<a href="listadoLicencias.php?estatus=enTramite">
							<i class="fa fa-user"></i> Listado de Usuarios
							</a>
						</li>
 -->
						

						<li <?php if ($subseccion=="examenMedico"){echo 'class="page-arrow active-page"';}?>>
							<a href="listadoExamen.php">
							<i class="fa fa-plus-square"></i> Certificado de Manejo
							</a>
						</li>

								
					</ul>

				</li>
				
				<li <?php if ($seccion=="licencias" ||$subseccion=="generarPago"||$subseccion=="listadoPagosPendientes" || $subseccion=="listadoPagos" ){echo 'class="menu-open"';}?>>
					<a href="#">
					<i class="fa fa fa-money"></i> Modulo III - Pagos
					<i class="fa fa-caret-left pull-right"></i>
					</a>
					<ul>
						<li <?php if ($subseccion=="listadoPagos"){echo 'class="page-arrow active-page"';}?>>
							<a href="listadoPagos.php">
							<i class="fa fa-check"></i> Pagos Cubiertos
							</a>
						</li>
						
						
						<li <?php if ($subseccion=="listadoPagosPendientes"){echo 'class="page-arrow active-page"';}?>>
							<a href="listadoPagosPendientes.php">
							<i class="fa fa-clock-o"></i> Pagos Pendientes
							</a>
						</li>
						
						<li <?php if ($subseccion=="generarPago"){echo 'class="page-arrow active-page"';}?>>
							<a href="generarPago.php">
							<i class="fa fa-plus"></i> Registrar Pago
							</a>
						</li>
						
						<li <?php if ($subseccion=="corteCaja"){echo 'class="page-arrow active-page"';}?>>
							<a href="corteCaja.php">
							<i class="fa fa-edit"></i> Corte
							</a>
						</li>
						
						<li <?php if ($subseccion=="corteHistorial"){echo 'class="page-arrow active-page"';}?>>
							<a href="corteHistorial.php">
							<i class="fa fa-calendar"></i> Historial Corte
							</a>
						</li>
						
                        <li <?php if ($subseccion=="listadoImpresion"){echo 'class="page-arrow active-page"';}?>>
							<a href="listadoImpresion.php">
							<i class="fa fa-print"></i> Impresi&oacute;n de licencia
							</a>
						</li>
						
					</ul>
				</li>
			<?php endif;?>
		
			
			<?php if($seccion=="reportes"):?>
				
				<li <?php if ($subseccion=="repListadoLicenciasFechaUbicacion" ||$subseccion=="repLicenciasVigentes" || $subseccion=="poa" || $subseccion=="repoficina" || $subseccion=="repComOfi" || $subseccion=="repTipoLic" || $subseccion=="repdescuentos" || $subseccion=="repdescuentoscruz" || $subseccion=="repdescuentosdecreto" || $subseccion=="repactivas" || $subseccion=="repconstancias" || $subseccion=="repreportes" || $subseccion=="repProximasVencer" || $subseccion=="repLicenciasExportarSat" || $subseccion=="repLicenciasAvances"|| $subseccion=="repLicenciasConstancias"|| $subseccion=="repLicenciaDetalladoMes"|| $subseccion=="repLicenciaAcumuladoMes"|| $subseccion=="repLicenciaEmitidas"|| $subseccion=="repLicenciaResumenGeneral"|| $subseccion=="repLicenciaTipo" || $subseccion=="verPersonas"|| $subseccion=="busquedaPersona"){echo 'class="menu-open"';}?>>
					<a href="#">
					<i class="fa fa-suitcase"></i> Reportes
					<i class="fa fa-caret-left pull-right"></i>
					</a>
				
					<ul>						
						<li <?php if($subnav == 'busquedaPersona'){echo 'class="page-arrow active-page"';} ?>>
							<a href="busquedaPersona.php"><i class="fa fa-file-text-o"></i> B&uacute;squeda</a>
						</li>
						<li <?php if($subnav == 'repLicenciaResumenGeneral'){echo 'class="page-arrow active-page"';} ?>>
							<a href="repLicenciaResumenGeneral.php"><i class="fa fa-file-text-o"></i> L. Reporte General</a>
						</li>
						<li <?php if($subnav == 'repLicenciaEmitidas'){echo 'class="page-arrow active-page"';} ?>>
							<a href="repLicenciaEmitidas.php"><i class="fa fa-file-text-o"></i> L. Emitidas</a>
						</li>
						<li <?php if($subnav == 'repListadoLicenciasFechaUbicacion'){echo 'class="page-arrow active-page"';} ?>>
							<a href="repListadoLicenciasFechaUbicacion.php"><i class="fa fa-file-text-o"></i> L. Emitidas Emisora</a>
						</li>
						<li <?php if($subnav == 'repLicenciaAcumuladoMes'){echo 'class="page-arrow active-page"';} ?>>
							<a href="repLicenciaAcumuladoMes.php"><i class="fa fa-file-text-o"></i> L. Acumulado mes</a>
						</li>
						<li <?php if($subnav == 'repLicenciaDetalladoMes'){echo 'class="page-arrow active-page"';} ?>>
							<a href="repLicenciaDetalladoMes.php"><i class="fa fa-file-text-o"></i> L. Detallado por d&iacute;a</a>
						</li>
						<li <?php if($subnav == 'repLicenciaTipo'){echo 'class="page-arrow active-page"';} ?>>
							<a href="repLicenciaTipo.php"><i class="fa fa-file-text-o"></i> L. por tipos</a>
						</li>
					</ul>
				</li>
				
				
				<?php endif;?>
				
				<?php if($seccion=="impresion" || $subseccion=="impresion"):?>
					<li <?php if ($subseccion=="ticket" || $subseccion=="tickethis" || $subseccion=="ticketasg" || $subseccion=="ticketadd" || $subseccion=="ticketrev" || $subseccion=="ticketroot"){echo 'class="menu-open"';}?>>
					<a href="#">
					<i class="fa fa-suitcase"></i> Impresion
					<i class="fa fa-caret-left pull-right"></i>
					</a>
					<ul>
						<li <?php if ($subsubseccion=="listadoPagos"){echo 'class="page-arrow active-page"';}?>>
							<a href="impresion.php">
							<i class="fa fa-user"></i> Impresion de licencias
							</a>
						</li>
						
					</ul>
				</li>
				<?php endif;?>
			
		<?php if($seccion=="soporte"):?>
			
			<li <?php if ($subseccion=="ticket" || $subseccion=="tickethis" || $subseccion=="ticketasg" || $subseccion=="ticketadd" || $subseccion=="ticketrev" || $subseccion=="ticketroot"){echo 'class="menu-open"';}?>>
				<a href="#">
				<i class="fa fa-suitcase"></i> Tickets Soporte
				<i class="fa fa-caret-left pull-right"></i>
				</a>
			
				<ul>
					<li <?php if ($subseccion=="ticket"){echo 'class="page-arrow active-page"';}?>>
						<a href="ticket.php">
						<i class="fa fa-stack-exchange"></i> Tickets abiertos
						</a>
					</li>
					<?php if ($objSession->getIdRol()>3):?>
					<li <?php if ($subseccion=="ticketasg"){echo 'class="page-arrow active-page"';}?>>
						<a href="ticketasg.php">
						<i class="fa fa-stack-exchange"></i> Tickets asignados
						</a>
					</li>
					<?php endif;?>
					<li <?php if ($subseccion=="ticketadd"){echo 'class="page-arrow active-page"';}?>>
						<a href="ticketadd.php">
						<i class="fa fa-pencil"></i> Crear ticket
						</a>
					</li>
					<li <?php if ($subseccion=="tickethis"){echo 'class="page-arrow active-page"';}?>>
						<a href="tickethis.php">
						<i class="fa fa-clock-o"></i> Hist&oacute;rico
						</a>
					</li>
					<li <?php if ($subseccion=="ticketroot"){echo 'class="page-arrow active-page"';}?>>
						<a href="ticketroot.php">
						<i class="fa fa-switcase"></i> Root View
						</a>
					</li>
					
					
				</ul>
			</li>
			
			
			<?php endif;?>
		
		
			
			
	</ul>
		
		
		
		</ul>
	</nav><!-- End .sidebar-nav-v1 -->
</div>
