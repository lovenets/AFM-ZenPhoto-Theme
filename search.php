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
	
	$titleText = getBareGalleryTitle() . " / " . gettext("Search");
	
	FormatHeader($indexPage, $titleText, 'Gallery', gettext('Gallery RSS'));

	FormatBodyStart($indexPage);
	
/*
 *  Page content is here
*
*/
	$total = getNumImages() + getNumAlbums();
	if (!$total)
	{
		$_zp_current_search->clearSearchWords();
	}

	$bodyData = '<div id="main" class="ledge glossy colored"><div id="gallerytitle">';
	
	if (getOption('show_home_link') == true)
	{
		$bodyData .= '<div id="home_link">';
		$bodyData .= '<a class="link glossy light" href="' . getMainSiteURL() . '">Home</a>';
		$bodyData .= '</div>';
	}
	
	$bodyData .= '<h2><span><a class="link title glossy light" href="' . html_encode(getGalleryIndexURL()) . '" title="';
	$bodyData .= gettext('Gallery Index') . '">';
	$bodyData .= getGalleryTitle() . '</a></span><span class="single"> / ';
	$bodyData .= gettext("Search") . "</span></h2></div>";
	$indexPage->addBodyData($bodyData);
	
	$bodyData = '</div><div id="padbox" class="ledge light">';
	if (($total = getNumImages() + getNumAlbums()) > 0)
	{
		if (isset($_REQUEST['date']))
		{
			$searchwords = getSearchDate();
 		}
 		else
 		{
 			$searchwords = getSearchWords();
 		}
		$bodyData .= '<p>' . sprintf(gettext('Total matches for <span>%1$s</span>: %2$u'), $searchwords, $total) . '</p>';
	}
	$indexPage->addBodyData($bodyData);
	$count = 0;
	if (getNumAlbums() > 0)
	{
		$bodyData = '<div id="searchalbums" class="ledge colored">';
		$indexPage->addBodyData($bodyData);
		while (next_album())
		{
			$count++;
			$bodyData = '<div class="album ledge colored"><div class="thumb ledge"><a href="';
			$bodyData .= html_encode(getAlbumLinkURL());
			$bodyData .= '" title="' . gettext('View album:');
			$bodyData .= getAnnotatedAlbumTitle();
			$bodyData .= '">' . captureEcho("printAlbumThumbImage(getAnnotatedAlbumTitle());") . '</a></div>';
			$bodyData .= '<div class="albumdesc ledge colored"><h3><a href="';
			$bodyData .= html_encode(getAlbumLinkURL());
			$bodyData .= '" title="' . gettext('View album:');
			$bodyData .= getAnnotatedAlbumTitle();
			$bodyData .= '">' . captureEcho("printAlbumTitle();") . '</a></h3>';
			$bodyData .= '<p>' . captureEcho("printAlbumDesc();") . '</p>';
			$dateText  = gettext("Date:") . ' ';
			$bodyData .= '<small>' . captureEcho("printAlbumDate('${dateText}');") . '</small></div>';
			$bodyData .= '<p style="clear: both; "></p></div>';
			$indexPage->addBodyData($bodyData);
		}
		$indexPage->addBodyData('</div>');
	}
	if (getNumImages() > 0)
	{
		$bodyData = '<div id="searchimages" class="ledge colored">';
		$indexPage->addBodyData($bodyData);
		while (next_image())
		{
			$count++;
			$bodyData = '<div class="image ledge colored"><div class="imagethumb ledge"><a href="';
			$bodyData .= html_encode(getImageLinkURL()) . '" title="';
			$boydData .= getBareImageTitle();
			$annotatedImageTitle = getAnnotatedImageTitle();
			$bodyData .= '">' . captureEcho("printImageThumb('${annotatedImageTitle}');") . '</a></div></div>';
			$indexPage->addBodyData($bodyData);
		}
		$indexPage->addBodyData('</div>');
	}
	$bodyData = '<br clear="all" />';

	if ($count == 0)
	{
		$bodyData .= "<p>" . gettext("Sorry, no image matches found. Try refining your search.") . "</p>";
	}
	$prevText = "&laquo; " . gettext("prev");
	$nextText = gettext("next") . " &raquo;";
	
	$bodyData .= captureEcho("printPageListWithNav('${prevText}', '${nextText}');");
	$bodyData .= '</div><br />';
	$indexPage->addBodyData($bodyData);

	/*
	 * end of page specific body content
	 */
	FormatBodyEnd($indexPage, false, false);
		
	/* Render page for display */
	echo $indexPage->renderPage();
?>