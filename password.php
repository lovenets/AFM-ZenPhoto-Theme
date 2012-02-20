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
	
	FormatHeader($indexPage, getBareGalleryTitle() . ' / ' . gettext("Password required"), 'Gallery', gettext('Gallery RSS'));
	
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
	$bodyData .= '<h2><span><a class="link title glossy light" href="' . html_encode(getGalleryIndexURL()) . '" title="' . gettext('Gallery Index') . '">';
	$bodyData .= getGalleryTitle() . '</a></span><span class="single">&nbsp;/&nbsp;&nbsp;';
	$bodyData .= gettext("A password is required for the page you requested");
	$bodyData .= '</span></h2></div>';
	$bodyData .= '<div id="padbox" class="ledge glossy light">' . captureEcho("printPasswordForm('${hint}', '${show}');");
	$bodyData .= '</div></div><br />';
	$indexPage->addBodyData($bodyData);

	/*
	 * end of page specific body content
	 */
	FormatBodyEnd($indexPage, true);
	
	/* Render page for display */
	echo $indexPage->renderPage();
?>