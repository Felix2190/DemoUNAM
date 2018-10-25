<?php
	require("masterIncludeLogin.inc.php");
//	require 'admintickets.php';
	$subnav = 'asignacionPlastico';
	$plasticos = new ModeloFolioplasticoentrega();
	$plasticos->setIdFolioPlasticoEntrega($_SESSION['idPlasticoE']);
	
	$ubicacion=new ModeloUbicacion();
	$ubicacion->setIdUbicacion($plasticos->getIdUbicacion());
	
	$responsable = new ModeloLogin_user();
	$responsable->setId_login($plasticos->getIdLoginEntrega());
	
	$rep = new ModeloLogin_user();
	$rep->setId_login($plasticos->getIdLoginRecepcion());
	
?>
<!DOCTYPE html>
<!--[if lt IE 7]>  <html class="ie ie6 lte9 lte8 lte7 no-js"> <![endif]-->
<!--[if IE 7]>     <html class="ie ie7 lte9 lte8 lte7 no-js"> <![endif]-->
<!--[if IE 8]>     <html class="ie ie8 lte9 lte8 no-js">      <![endif]-->
<!--[if IE 9]>     <html class="ie ie9 lte9 no-js">           <![endif]-->
<!--[if gt IE 9]>  <html class="no-js">                       <![endif]-->
<!--[if !IE]><!--> <html class="no-js">                       <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <title>Pl&aacute;stico</title>

    <!-- // IOS webapp icons // -->
    
    <meta name="apple-mobile-web-app-title" content="Karma Webapp">
    <link rel="apple-touch-icon-precomposed" sizes="152x152" href="images/mobile/apple-touch-icon-152x152.png" />
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/mobile/apple-touch-icon-144x144.png">
    <link rel="apple-touch-icon-precomposed" sizes="120x120" href="images/mobile/apple-touch-icon-120x120.png" />
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/mobile/apple-touch-icon-114x114.png" />
    <link rel="apple-touch-icon-precomposed" sizes="76x76" href="images/mobile/apple-touch-icon-76x76.png" />
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/mobile/apple-touch-icon-72x72.png" />
    <link rel="apple-touch-icon-precomposed" href="images/mobile/apple-touch-icon.png" />
    <link rel="shortcut icon" href="images/favicons/favicon.ico" />
    
    <!-- // IOS webapp splash screens // -->
    
    <link rel="apple-touch-startup-image" media="(device-width: 768px) and (device-height: 1024px) and (orientation: portrait) and (-webkit-device-pixel-ratio: 2)"
          href="/images/mobile/apple-touch-startup-image-1536x2008.png"/>
    <link rel="apple-touch-startup-image" media="(device-width: 768px) and (device-height: 1024px) and (orientation: landscape) and (-webkit-device-pixel-ratio: 2)"
          href="/images/mobile/apple-touch-startup-image-1496x2048.png"/>     
 	<link rel="apple-touch-startup-image" media="(device-width: 768px) and (device-height: 1024px) and (orientation: portrait) and (-webkit-device-pixel-ratio: 1)"
          href="/images/mobile/apple-touch-startup-image-768x1004.png"/>
    <link rel="apple-touch-startup-image" media="(device-width: 768px) and (device-height: 1024px) and (orientation: landscape) and (-webkit-device-pixel-ratio: 1)"
          href="/images/mobile/apple-touch-startup-image-748x1024.png"/>
    <link rel="apple-touch-startup-image" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)" 
          href="/images/mobile/apple-touch-startup-image-640x1096.png"/>    
    <link rel="apple-touch-startup-image" media="(device-width: 320px) and (device-height: 480px) and (-webkit-device-pixel-ratio: 2)"
          href="/images/mobile/apple-touch-startup-image-640x920.png"/>    
    <link rel="apple-touch-startup-image" media="(device-width: 320px) and (device-height: 480px) and (-webkit-device-pixel-ratio: 1)"
          href="/images/mobile/apple-touch-startup-image-320x460.png"/>    
    
    <!-- // Windows 8 tile // -->
    <meta name="application-name" content="Unifica">
    <meta name="msapplication-TileColor" content="#333333" />
	<meta name="msapplication-TileImage" content="images/mobile/windows8-icon.png" />

    <!-- // Handheld devices misc // -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="HandheldFriendly" content="true"/>   
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" /> 
    
    <!-- // Stylesheets // -->
    <link rel="stylesheet" href="bootstrap/core/dist/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="bootstrap/typeahead/typeahead.min.css"/>
    <link rel="stylesheet" href="fontawesome/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="css/bootstrap-custom.css"/>
    <link rel="stylesheet" href="css/bootstrap-extended.css"/>
    <link rel="stylesheet" href="css/animate.min.css"/>
    <link rel="stylesheet" href="css/helpers.css"/>
    <link rel="stylesheet" href="css/base.css"/>
    <link rel="stylesheet" href="css/light-theme.css"/>
    <link rel="stylesheet" href="css/mediaqueries.css"/>   			     
    
    <!-- // Helpers // -->
    <script src="js/plugins/modernizr.min.js"></script> 
    <script src="js/plugins/mobiledevices.js"></script>
    
    <!-- // jQuery core // -->
    <script src="js/libs/jquery-1.11.0.min.js"></script>
    <script src="js/libs/jquery-ui-1.10.4.min.js"></script>
    
    <!-- // Bootstrap // -->
    <script src="bootstrap/core/dist/js/bootstrap.min.js"></script>
	<script src="bootstrap/bootboxjs/bootboxjs.min.js"></script>
    <script src="bootstrap/holder/holder.min.js"></script>
    <script src="bootstrap/typeahead/typeahead.min.js"></script>
    
    <!-- // Custom/premium plugins // -->
    <script src="js/plugins/mainmenu.1.0.min.js"></script>
    <script src="js/plugins/bootstraptabsextend.1.0.min.js"></script>
 	<script src="js/plugins/nanogress.1.0.min.js"></script>
    <script src="js/plugins/simpleselect.1.0.min.js"></script>
      
    <!-- // Third-party plugins // -->
    <script src="js/plugins/tinyscrollbar.min.js"></script>
    <!-- mouse wheel opt-->
    <script src="js/plugins/h5f.min.js"></script>
    <script src="js/plugins/hogan-2.0.0.js"></script>
    <script src="js/plugins/jquery.autosize-min.js"></script>
    <script src="js/plugins/layout.min.js"></script>
    <script src="js/plugins/masonry.pkgd.min.js"></script>
    
    <script src="js/Chart.js/Chart.min.js"></script>   
    <script src="js/plugins/generics.js"></script>  
    
    <script src="js/lib/jquery.formatCurrency-1.4.0.js"></script>
	    <script src="js/lib/i18n/jquery.formatCurrency.es-MX.js"></script>
    	<script type="text/javascript" src="js/lib/jquery.numeric.js"></script>
    	
    	<!-- Calendar jQuery -->
    
    <script type="text/javascript" src="js/lib/ui.datepicker-es-MX.js"></script>
	
    	
    <?php
			echo $_JAVASCRIPT_CSS;
		?>
		
         
</head>
<body> 
	<div id="container" class="clearfix">
                   
		<aside id="sidebar-main" class="sidebar">
            
        	<?php include_once('header.php'); ?>
            
			<?php include_once('navhome.php'); ?>
            
        </aside><!-- End aside -->
        
        
        
        <div id="main" class="clearfix">
       
			<?php include_once('topnav.php'); ?>
        
        
        
            <div id="content" class="clearfix">

                
                <header id="header-sec"> 
                	<div class="inner-padding"> 
                        <div class="pull-left">
                            <h2>Folios Pl&aacute;stico</h2>                 
                        </div> 
                    </div>
            	</header>


                                     
                <div class="window">  
                    <div class="row ext-raster">
                    	<div class="col-sm-12">
                            <div class="row">
                            	<div class="col-sm-12">
                                    <div class="inner-padding">								
                                        	
                                        
                                        
                                        
                                        
					<!-- start: FEATURED BOX LINKS -->
						<div class="container-fluid container-fullw bg-white">
						
							<div class="row">
								
								<div class="col-md-12">

                
        					<div class="inner-padding">
        
        						<div class="col-sm-12">
                

                          <div class="inner-padding ">	
            								<!-- 
            								
            								<div class="form-group">
            									<label class="col-sm-3 control-label txt" for="txt"> </label>
            									<div class="col-sm-9"><input id="txt" class="form-control" type="text" />
            									</div>
            								</div>
            								 -->
            								 
            								<div class="form-group">
            									<label class="col-sm-3 control-label txtNumeroInicial" for="txtNumeroInicial"> N&uacute;mero Pl&aacute;stico Inicial </label>
            									<div class="col-sm-9"><input id="txtNumeroInicial" class="form-control numeric" type="text" readonly="readonly" value="<?php echo $plasticos->getNumeroPlasticoInicial();?>"/>
            									</div>
            								</div> 
            								
            								<div class="spacer-20"></div>
            								
            								<div class="form-group">
            									<label class="col-sm-3 control-label txtNumeroFinal" for="txtNumeroFinal"> N&uacute;mero Pl&aacute;stico Final</label>
            									<div class="col-sm-9"><input id="txtNumeroFinal" class="form-control numeric" type="text" readonly="readonly" value="<?php echo $plasticos->getNumeroPlasticoFinal();?>"/>
            									</div>
            								</div> 
            								
                            <div class="spacer-20"></div>
            								<div class="form-group">
            									<label class="col-sm-3 control-label slcRecaudacion"
            										for="slcRecaudacion"> Recaudaci&oacute;n </label>
<div class="col-sm-9"><input id="" class="form-control numeric" type="text" readonly="readonly" value="<?php echo $ubicacion->getNombre();?>"/>            								
</div> 
                            <div class="spacer-20"></div>
            								            								<div class="form-group">
            									<label class="col-sm-3 control-label slcRol"
            										for="slcRecibe"> Persona que entrega</label>
<div class="col-sm-9"><input id="" class="form-control numeric" type="text" readonly="readonly" value="<?php echo $responsable->getUser_name();?>"/>            								
</div> 

            								</div>
            							<div class="spacer-20"></div>	
            								<div class="form-group">
            									<label class="col-sm-3 control-label slcRol"
            										for="slcRecibe"> Persona que recibe </label>
<div class="col-sm-9"><input id="" class="form-control numeric" type="text" readonly="readonly" value="<?php echo $rep->getUser_name();?>"/>            								
</div> 
            								</div>
            								
            								<div class="spacer-20"></div>
            								
            								<div class="form-group">
            									<label class="col-sm-3 control-label txt" for="txt"> Fecha </label>
            									<div class="col-sm-9">
            									<input  type="date" data-date-format='yy-mm-dd'  id="txtFecha" class="form-control txtFecha" readonly="readonly" value="<?php echo $plasticos->getFecha();?>"/>
            									</div>
            								</div>
            								 
                            <div class="spacer-20"></div>

        										<div class="row">
        											<div class="col-sm-12 text-right">
        												<a class="btn btn-warning" href="listadoPlasticos.php">Regresar</a>
        											</div>
        										</div>                
                          
                          </div>	
    									</div>
    							</div>
    										
                                
                                <div class="spacer-30"></div>
                                
								</div>
							</div>
						
								
						</div>

						<!-- end: FEATURED BOX LINKS -->
                                        	
                                        	
                                    </div><!-- End .inner-padding -->  
                                </div>
                            </div><!-- End .row -->
                        </div>
                        
                    </div>
                </div><!-- End .window -->
                
                
                <?php include_once('footer.php'); ?>
                <a data-toggle="modal" id="_alertShow"
			style="display: none" class="btn btn-danger" role="button"
			href="#_alertBox">Alert</a>
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
                
            </div><!-- End #content -->  
    	</div>
    	<!-- End #main -->
    	
    	
    </div>
    <!-- End #container -->
    
    
        
     	<script src="js/lib/main.js"></script>
     	
</body>


</html>