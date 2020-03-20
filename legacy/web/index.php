<?php

require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('frontend', $_SERVER['APP_ENV'], false);
$sfContext = sfContext::createInstance($configuration);
ob_start();
$sfContext->dispatch();
$sfContext->getResponse()->setContent(ob_get_contents());
$sfContext->shutdown();
ob_clean();
