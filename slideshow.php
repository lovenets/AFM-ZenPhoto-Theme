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
	
	FormatHeader($indexPage, getBareGalleryTitle() . ' / Slideshow', 'Gallery', gettext('Gallery RSS'));
	
	FormatBodyStart($indexPage);
	
	/*
	 *  Page content is here
	 *
	 */
	$theme = basename(dirname(__FILE__));
	$themeRoot = WEBPATH . '/' . THEMEFOLDER . "/${theme}/styles/structure/";
	$jsPath = WEBPATH . '/' . THEMEFOLDER . "/${theme}/js/";
	
//	$indexPage->addStyleSheet(pathurlencode($themeRoot . 'slideshow.css'));
	
	if (function_exists('printSlideShowJS'))
	{
		$slideShowJS = captureEcho("printSlideShowJS();");
	}
	
	$indexPage->addInlineJavaScript($slideShowJS);
	
	$indexPage->addBodyData('<div id="main" class="ledge glossy colored"><div id="slideshowpage" class="ledge glossy light">');
	if (function_exists("printSlideShow"))
	{
		$indexPage->addBodyData(captureEcho("printSlideShow(true, true);"));
	}
	else {
		$indexPage->addBodyData("The slide show feature is not enabled for this site.");
	}
	$indexPage->addBodyData('</div></div><br clear="all" />');
	
	/*
	 * end of page specific body content
	 */
	FormatBodyEnd($indexPage);
	
	/* Render page for display */
	echo $indexPage->renderPage();
?>