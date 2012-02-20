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
	$bodyData .= gettext('Gallery Index') . '">' . getGalleryTitle();
	$bodyData .= '</a></span><span class="single"> / ';
	$bodyData .= gettext("Archive View");
	$bodyData .= '</span></h2></div></div>';
	$indexPage->addBodyData($bodyData);
	
	$bodyData = '<div id="archivebox" class="ledge glossy colored"><div id="archive" class="ledge light"><p>' . gettext('Archive') . ':</p>';
	$bodyData .= captureEcho("printAllDates();");
	$bodyData .= '</div>';
	$indexPage->addBodyData($bodyData);
	
	$bodyData = '<div id="tag_cloud" class="ledge light"><p>';
	$bodyData .= gettext('Popular Tags') . ':</p>';
	$bodyData .= captureEcho("printAllTagsAs('cloud', 'tags');");
	$bodyData .= '</div></div><br />';
	$indexPage->addBodyData($bodyData);


	/*
	 * end of page specific body content
	 */
	FormatBodyEnd($indexPage);
	
	/* Render page for display */
	echo $indexPage->renderPage();
?>