<?php

	$App=new ModeloSesion_app();
	$App->isLoged($token);
	if($App->getError())
		returnAppError($App->getStrError());