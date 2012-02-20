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
	 $indexPage->addBodyData('<div id="main" class="ledge glossy colored">');
	 
	 $bodyData = '<div id="gallerytitle">';
	 
	 if (getOption('show_home_link') == true)
	 {
		 $bodyData .= '<div id="home_link">';
		 $bodyData .= '<a class="link glossy light" href="' . getMainSiteURL() . '">Home</a>';
		 $bodyData .= '</div>';
	 }
	 $bodyData .= '<h2 class="single">' . getGalleryTitle() . "</h2>";
	 $bodyData .= '<div class="gallerydesctitle">' . captureEcho("printGalleryDesc();") . "</div>";
	 $indexPage->addBodyData($bodyData);

	 // end gallerytitle
	 $bodyData = '</div>';
	 
	 // end main and start albums
	 $bodyData .= '</div><div id="albums">';
	 $indexPage->addBodyData($bodyData);

	 while (next_album())
	 {
	 	$albumLink = html_encode(getAlbumLinkURL());
	 	$albumLinkTitle = gettext('View album: ') . getAnnotatedAlbumTitle();
	 	$albumThumbImage = captureEcho("printAlbumThumbImage(getAnnotatedAlbumTitle());");
	 	$bodyData = '<div class="album ledge colored"><div class="albumdesc ledge light">';
	 	$bodyData .= "<a href=\"" . $albumLink . "\" title=\"" . $albumLinkTitle . "\">" . $albumThumbImage . "</a>";
 		$indexPage->addBodyData($bodyData);
 		
 		$albumTitle = captureEcho("printAlbumTitle();");
 		$albumDate = captureEcho("printAlbumDate('');");
 		$albumDesc = captureEcho("printAlbumDesc();");
 		$bodyData = "<h3><a href=\"" . $albumLink . "\" title=\"" . $albumLinkTitle . "\">" . $albumTitle . "</a></h3>";
 		$bodyData .= '<small>' . $albumDate . "</small>";
 		$bodyData .= "<p>" . $albumDesc . "</p></div><p style=\"clear: both; \"></p></div>";
 		$indexPage->addBodyData($bodyData);
	  }
	  $bodyData = "</div><br clear=\"all\" />";
	  $prevText = "&laquo; " . gettext("prev");
	  $nextText = gettext("next") . " &raquo;";
	  $bodyData .= captureEcho("printPageListWithNav('${prevText}', '${nextText}');");
	  $bodyData .= "</div>";
	  $indexPage->addBodyData($bodyData);
	

	/*
	 * end of page specific body content
	 */
	FormatBodyEnd($indexPage);
	
	/* Render page for display */
	echo $indexPage->renderPage();
?>