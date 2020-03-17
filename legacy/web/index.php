<?php


require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'prod', false);
$sfContext = sfContext::createInstance($configuration);
ob_start();
$sfContext->dispatch();
$sfContext->getResponse()->setContent(ob_get_contents());
ob_clean();
