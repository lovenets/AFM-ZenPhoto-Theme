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
	$bodyData .= '<h2><span><a class="link title glossy light" href="' . html_encode(getGalleryIndexURL()) . '" title="';
	$bodyData .= gettext('Gallery Index') . '">' . getGalleryTitle() . '</a></span><span class="single"> / ';
	$bodyData .= gettext("Object not found") . '</span></h2></div></div>';
	$indexPage->addBodyData($bodyData);

	$bodyData = '<div id="m404"><h2>' . gettext("The Zenphoto object you are requesting cannot be found.") . '</h2>';
	
	if (isset($album))
	{
		$bodyData .= '<br />' . sprintf(gettext('Album: %s'),sanitize($album));
	}
	if (isset($image))
	{
		$bodyData .= '<br />' . sprintf(gettext('Image: %s'),sanitize($image));
	}
	if (isset($obj))
	{
		$bodyData .= '<br />' . sprintf(gettext('Page: %s'),substr(basename($obj),0,-4));
	}

	$bodyData .= '<br />&nbsp</div>';
	$indexPage->addBodyData($bodyData);


	/*
	 * end of page specific body content
	 */
	FormatBodyEnd($indexPage);
	
	/* Render page for display */
	echo $indexPage->renderPage();
?>