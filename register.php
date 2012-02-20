<?php

	$baseDir = dirname(__FILE__);
	include_once $baseDir . '/system.php';
	include_once $baseDir . '/toolbox/tools.php';

	$systemObject = System::getInstance();

	include_once $baseDir . '/pageBuilder/page.php';
	
	if (!defined('WEBPATH'))
	{
		die();
	}

	include_once('theme_methods.php');

	/* Create page to display */
	$indexPage = new Page();

	FormatHeader($indexPage, getBareGalleryTitle(), 'Gallery', gettext('Gallery RSS'));
	
	FormatBodyStart($indexPage);
	
	/*
	*  Page content is here
	*
	*/
	$bodyData = '<div id="main" class="ledge glossy colored"><div id="gallerytitle">';
	 
	 if (getOption('show_home_link') == true)
	 {
		 $bodyData .= '<div id="home_link">';
		 $bodyData .= '<a class="link glossy light" href="' . getMainSiteURL() . '">Home</a>';
		 $bodyData .= '</div>';
	 }
	$bodyData .= '<h2><a class="link title glossy light" href="' . html_encode(getGalleryIndexURL());
	$bodyData .= '" title="' . gettext('Gallery') . '">' . gettext('Gallery') . '</a>';
	$bodyData .='<span class="single"> / ' . gettext('Register') . '</span></h2></div>';
	$indexPage->addBodyData($bodyData);
	
	$bodyData = '<h2>' . gettext('User Registration') . '</h2>';
	if (function_exists('printRegistrationForm'))
	{
		$registerForm = captureEcho("printRegistrationForm();");
		
		// If they are already registerd then give the errorbox some class
		$bodyData .= str_replace('<div class="', '<div class="ledge glossy light ', $registerForm);
	}
	else
	{
		$bodyData .= '<h3>Registration is not enabled for this site.</h3>';
	}
	$bodyData .= '</div><br />';
	$indexPage->addBodyData($bodyData);
	
	/*
	 * end of page specific body content
	 */
	FormatBodyEnd($indexPage);
	
	/* Render page for display */
	echo $indexPage->renderPage();
?>