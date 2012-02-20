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
	
	FormatHeader($indexPage, getBareAlbumTitle() . " / " . getBareImageTitle(), 'Gallery', gettext('Gallery RSS'));
	
	// Add in colorbox scripting
	if (getOption('zp_plugin_colorbox'))
	{
		$closeText = gettext("close");
		$colorBoxScript=<<<COLORBOX
			afmInitializer.addCallback(function(){
				$(".colorbox").colorbox({
					inline:true, 
					href:"#imagemetadata",
					close: '${closeText}'
				});
			});
COLORBOX;
	
		$indexPage->addInlineJavaScript($colorBoxScript);
	}
	
	$javaScriptData =<<<JAVASCRIPTDATA
		afmInitializer.addCallback(function () {addLedgeClass('imagemetadata_data', false, false);});
JAVASCRIPTDATA;
	$indexPage->addInlineJavaScript($javaScriptData);

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
	
	$imageTitle = '&nbsp;/&nbsp;' . getBareImageTitle();
	$imageData = captureEcho("printEditable('image', 'title', true, 'editable', true, false, '${imageTitle}', '');");

	$bodyData .= '<h2><span>';
	$bodyData .= '<a class="link title glossy light" href="' . html_encode(getGalleryIndexURL());
	$bodyData .= '" title="' . gettext('Albums Index');
	$bodyData .= '">' . $galleryTitle;
	$bodyData .= '</a><span class="single">&nbsp;/&nbsp;&nbsp;</span>';
	$parentBreadcrumb = captureEcho('printParentBreadcrumb("", "", "");');
	$bodyData .= str_replace('<a ', '<a class="link title glossy light" ', $parentBreadcrumb);
	$showSearch = false;
	if (strstr($parentBreadcrumb, 'Search') == FALSE)
	{
		$showSearch = true;
	}
	$breadcrumbData = captureEcho('printAlbumBreadcrumb("", "");');
//	$breadcrumbData = str_replace('>' . getAlbumTitle() . '<', $albumTitle, $breadcrumbData);
	
	// give the album breadcrumb some class
	$bodyData .= str_replace('<a href=', '<a class="link title glossy light" href=', $breadcrumbData);
	$bodyData .= '</span>' .  $imageData . '</h2>';
	$indexPage->addBodyData($bodyData);
	

	$bodyData = '</div><div class="imgnav">';
	if (hasPrevImage())
	{
		$prevText = "&laquo; " . gettext("prev");
	
		$bodyData .= '<div class="imgprevious"><a href="';
		$bodyData .= html_encode(getPrevImageURL());
		$bodyData .= '" title="';
		$bodyData .= gettext("Previous Image");
		$bodyData .= '">' . $prevText . '</a></div>';
	}
	
	if (hasNextImage())
	{
		$nextText = gettext("next") . " &raquo;";
		$bodyData .= '<div class="imgnext"><a href="';
		$bodyData .= html_encode(getNextImageURL());
		$bodyData .= '" title="';
		$bodyData .= gettext("Next Image");
		$bodyData .= '">' . $nextText . '</a></div>';
	}
	$bodyData .= '</div></div>';
	$indexPage->addBodyData($bodyData);
	
	$bodyData = '<!-- The Image --> <div id="image" class="ledge colored"><strong>';
	$fullimage = getFullImageURL();
	if (!empty($fullimage))
	{
		$bodyData .= '<a href="' . html_encode($fullimage);
		$bodyData .= '" title="' . getBareImageTitle() . '">';
	}
	$imageTitle = getImageTitle();
	if (function_exists('printUserSizeImage') && isImagePhoto())
	{
		$bodyData .= captureEcho("printUserSizeImage('${imageTitle}');");
	}
	else
	{
		$bodyData .= captureEcho("printDefaultSizedImage('${imageTitle}');");
	}
	if (!empty($fullimage))
	{
		$bodyData .= '</a>';
	}
	$bodyData .= '</strong>';
	if (function_exists('printUserSizeSelector') && isImagePhoto())
	{
		$bodyData .= captureEcho('printUserSizeSelector();');
	}
	$bodyData .= '</div>';
	$indexPage->addBodyData($bodyData);
	
	$bodyData = '<div id="narrow">';
	$bodyData .= captureEcho('printImageDesc(true);');	
	$bodyData .= '<hr /><br />';
	$indexPage->addBodyData($bodyData);
	$bodyData = '<div id="tag_image" class="ledge light" >';
	$tagsText = gettext('Tags:');
	$bodyData .= captureEcho("printTags('links', '${tagsText}' , 'taglist', ', ');");
	$bodyData .= '</div>';
	$indexPage->addBodyData($bodyData);
	if (getImageMetaData())
	{
		$bodyData = '<div id="exif_link">';
		$bodyData .= '<a class="link title glossy light" href="javascript:toggleWindow(' . "'imageinfo', 'exif_link', -100, -300, true);";
		$bodyData .= '" title="' . gettext("Image Info") . '">';
		$bodyData .= gettext("Exif Data") . '</a></div>';
		$bodyData .= '<div id="imageinfo" class="ledge light">';
		$bodyData .= captureEcho("printImageMetadata(null, false);");
		$bodyData .= "</div>";
		$indexPage->addBodyData($bodyData);
	}
	$indexPage->addBodyData('<br clear="all" />');
	
	if (function_exists('printGoogleMap'))
	{
		$indexPage->addBodyData(captureEcho("printGoogleMap();"));
	}
	if (function_exists('printRating'))
	{
		$indexPage->addBodyData(captureEcho("printRating();"));
	}
	if (function_exists('printShutterfly'))
	{
		$indexPage->addBodyData(captureEcho("printShutterfly();")); 
	}
	if (function_exists('printCommentForm'))
	{
		$indexPage->addBodyData(captureEcho("printCommentForm();"));
	}
	$bodyData = '</div>';
	$indexPage->addBodyData($bodyData);

	/*
	 * end of page specific body content
	 */
	FormatBodyEnd($indexPage, false, $showSearch);
	
	/* Render page for display */
	echo $indexPage->renderPage();
?>