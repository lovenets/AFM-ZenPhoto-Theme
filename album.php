<?php


	$baseDir = dirname(__FILE__);
	include_once $baseDir . '/system.php';
	include_once $baseDir . '/toolbox/tools.php';

	$systemObject = System::getInstance();

	include_once $baseDir . '/pageBuilder/page.php';
	
	include_once('theme_methods.php');
	
	if (!defined('WEBPATH'))
	{
		die();
	}

	/* Create page to display */
	$indexPage = new Page();
	
	FormatHeader($indexPage, getBareGalleryTitle() . " / " . getBareAlbumTitle(), 'Album', getAlbumTitle());
		
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
	 $indexPage->addBodyData($bodyData);
	 
	 $galleryTitle = getGalleryTitle();
	 if (strlen($galleryTitle) > 8)
	 {
	 	$galleryTitle = substr($galleryTitle, 0, 8) . ' ...';
	 }
	 $albumTitle = getBareAlbumTitle();
	 
	 if (strlen($albumTitle) > 8)
	 {
	 	$albumTitle = substr($albumTitle, 0, 8) . ' ...';
	 }

	 $albumTitle = '&nbsp;/&nbsp;' . $albumTitle;
	 $albumData = captureEcho("printEditable('album', 'title', true, 'editable', true, false, '${albumTitle}', '');");
	 
	 $bodyData = '<h2><span><a class="link title glossy light" href="' . html_encode(getGalleryIndexURL()) . '" title=' . gettext('Albums Index') . ">" . $galleryTitle . "</a>";
	 $parentBreadcrumb = captureEcho('printParentBreadcrumb();');
	 $bodyData .= str_replace('<a ', '<a class="button glossy light" ', $parentBreadcrumb);
	 $showSearch = false;
	 if (strstr($parentBreadcrumb, 'Search') == FALSE)
	 {
	 	$showSearch = true;
	 }
	 $bodyData .= "</span>" . $albumData . "</h2>";
	 $indexPage->addBodyData($bodyData);

	 $bodyData = '<div class="albumdesctitle">' . captureEcho("printAlbumDesc(true);");
	 $bodyData .= "</div></div></div>";
	 $bodyData .= '<div id="albums" class="ledge colored">';
	 $indexPage->addBodyData($bodyData);
	 
	 while (next_album())
	 {
	 	$viewAlbumText = gettext('View album:');
	 	$annotatedAlbumTitle = getAnnotatedAlbumTitle();
 
		$bodyData = '<div class="album ledge colored"><div class="thumb ledge"><a href="';
		$bodyData .= html_encode(getAlbumLinkURL());
		$bodyData .= '" title="';
		$bodyData .= $viewAlbumText . $annotatedAlbumTitle;
		$bodyData .= '">' . captureEcho("printAlbumThumbImage('${annotatedAlbumTitle}');") . "</a>";
		$bodyData .= '</div>';
		$indexPage->addBodyData($bodyData);
		
		$bodyData = '<div class="albumdesc ledge colored"><h3><a href="';
		$bodyData .= html_encode(getAlbumLinkURL());
		$bodyData .= '" title="' . $viewAlbumText . $annotatedAlbumTitle;
		$bodyData .= '">' . captureEcho("printAlbumTitle();") . "</a></h3>";
		$bodyData .= "<small>" . captureEcho('printAlbumDate("");') . "</small>";
		$bodyData .= "<p>" . captureEcho("printAlbumDesc();") . "</p></div><p style=\"clear: both; \"></p></div>";
		$indexPage->addBodyData($bodyData);
	 }
	
	$bodyData = '</div><!-- end of albums --><div id="images" class="ledge colored">';
	$indexPage->addBodyData($bodyData);
	while (next_image())
	{
	 	$annotatedImageTitle = getAnnotatedImageTitle();
	 	$indexPage->addBodyData("<!-- " . $annotedImageTitle . " -->");
		$bodyData = '<div class="image ledge colored"><div class="imagethumb ledge"><a href="';
		$bodyData .= html_encode(getImageLinkURL());
		$bodyData .= '" title="' . getBareImageTitle();
		$bodyData .= '">' . captureEcho("printImageThumb('${annotatedImageTitle}');");
		$bodyData .= '</a><div class="imagetitle">' . $annotatedImageTitle . "</div></div></div>";
		$indexPage->addBodyData($bodyData);
	}

	$bodyData = '</div><!-- end of images -->';
	$prevText = "&laquo; " . gettext("prev");
	$nextText = gettext("next") . " &raquo;";
	$bodyData .= captureEcho("printPageListWithNav('${prevText}', '${nextText}');");
	$indexPage->addBodyData($bodyData);
	$tagText = gettext('<strong>Tags:</strong>');
	$bodyData = captureEcho("printTags('links', '${tagText}', 'taglist', '');");
	$indexPage->addBodyData($bodyData);

	if (function_exists('printGoogleMap'))
	{
		$indexPage->addBodyData(captureEcho("printGoogleMap();")); 
	}
	
	if (function_exists('printRating'))
	{
		$indexPage->addBodyData(captureEcho("printRating();")); 
	}
	if (function_exists('printCommentForm'))
	{
		 $indexPage->addBodyData(captureEcho("printCommentForm();"));
	}
	$indexPage->addBodyData("</div><br />");

	/*
	 * end of page specific body content
	 */
	FormatBodyEnd($indexPage, false, $showSearch);
	
	/* Render page for display */
	echo $indexPage->renderPage();
?>