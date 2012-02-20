<?php
	$baseDir = dirname(__FILE__);
	include_once $baseDir . '/system.php';
	include_once $baseDir . '/toolbox/tools.php';

	$systemObject = System::getInstance();

	include_once $baseDir . '/pageBuilder/xmlPage.php';
	
	if (!defined('WEBPATH'))
	{
		die();
	}
	
	$theme = basename(dirname(__FILE__));
	$themeRoot = WEBPATH . '/' . THEMEFOLDER . "/${theme}";
	$themeCSS = $themeRoot . "/styles/";
	
//	$_POST = array_merge($_GET, $_POST);
	$success = 0;
	$returnPage = new XmlPageData();
	$returnPage->setName("results");
	if (isset($_POST['command']) == true)
	{
		$returnPage->addChild('command', $_POST['command']);
		switch ($_POST['command'])
		{
			case 'theme_color':
			{
				if (isset($_POST['theme_color']))
				{
					$newColor = $_POST['theme_color'];
					$returnPage->addChild('theme_color', $_POST['theme_color']);
					$returnPage->addChild('cssAddr', $themeCSS);
					$success = 1;
				}
			}
			break;
			default:
			{
				$success = $_POST['command'];
			}
			break;
		}
	}
	$returnPage->addChild("success", $success);
//	$returnPage->addChild("request", print_r($_POST, true));
	
	$returnPage->renderPage();
?>