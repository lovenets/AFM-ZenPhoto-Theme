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
	$bodyData .= '<h2><a class="link title glossy light" href="' . html_encode(getGalleryIndexURL()) . '" title="' . gettext('Gallery');
	$bodyData .= '">' . gettext('Gallery') . '</a><span class="single"> / ' . gettext('About us') . '</span></h2></div></div>';
	$indexPage->addBodyData($bodyData);

	$bodyData = '<div id="about" class="ledge">';
	$bodyData .= getOption('about_us');
	
	// About data
	$bodyData .= '</div><br />';
	$indexPage->addBodyData($bodyData);
	
	/*
	 * end of page specific body content
	 */
	FormatBodyEnd($indexPage);
	
	/* Render page for display */
	echo $indexPage->renderPage();
?>