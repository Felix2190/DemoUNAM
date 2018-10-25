<?php   

		?>
			<div class="sidebar-logo">
            	<a href="dashboard.php" id="logo-big">
            		<h1></h1>
            	</a>
            </div><!-- End .sidebar-logo -->
                    
            <div class="sidebar-module"> 
                <div class="sidebar-profile">
                	<div class="dropdown ext-dropdown-profile">
						<a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="#">
							Hola, <strong><?php echo $objSession->getUserName() ?></strong>
							<i class="fa fa-caret-down pull-right"></i>
						</a>
						<ul role="menu" class="dropdown-menu">
							<li>
								<a href="logout.php"><i class="fa fa-sign-out"></i> Salir</a>
							</li>
						</ul>
	                </div>
                </div>
            </div><!-- /sidebar -->
                    
            <div class="sidebar-line"><!-- A seperator line --></div>