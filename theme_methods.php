<?php

function FormatHeader(& $page, $title, $rssSection, $rssText)
{
	$theme = basename(dirname(__FILE__));
	$themeRoot = WEBPATH . '/' . THEMEFOLDER . "/${theme}";
	$themeStructure = $themeRoot . "/styles/structure/";
	$themeCSS = $themeRoot . "/styles/";
	$jsPath = $themeRoot . "/js/";
	$toolJsPath = $themeRoot . "/toolbox/js/";
	
	$themeResult = getTheme($zenCSS, $themeColor, 'default');

	/* This will set the title for the page */
	$page->setTitle($title);
	
	$headFilter = captureEcho("zp_apply_filter('theme_head');");
	
	$page->addHeaderData($headFilter);
	
	$rssFeed = getRSSHeaderLink($rssSection, $rssText);
	$page->addHeaderData($rssFeed);

	/* This will add in the base site stylesheet */
	$page->addStyleSheet(pathurlencode($themeStructure . 'structure.css'));
	
	/* Add in the coloring */
	if (getOption('allow_color_select') == true)
	{
		if (isset($_COOKIE['userColor']))
		{
			$zenCSS = $themeCSS . $_COOKIE['userColor'] . ".css";
		}
	}
	$styleSheetObj = $page->addStyleSheet(pathurlencode($zenCSS));
	$styleSheetObj->setId('colorcss');
	
	$page->addJavaScriptLink(pathurlencode($jsPath . 'afm.js'));
	$page->addJavaScriptLink(pathurlencode($toolJsPath . 'tools.js'));
	
	$javaScriptData =<<<JAVASCRIPTDATA
		var afmInitializer = new Initializer();
		
		function themeHeaderInit()
		{
			addLinkClass('search', null, false, true);
			addLinkClass('rss', 'a', true, true);
			addLinkClass('admin', 'a', true, true);
			addLinkClass('logout', 'a', true, true);
			addLinkClass('slideshowlink', 'a', true, true);
			addLinkClass('admin_data', null, false, true);
		}
		afmInitializer.addCallback(function () {themeHeaderInit();});
JAVASCRIPTDATA;
	$page->addInlineJavaScript($javaScriptData);
}

function FormatBodyStart(& $page)
{
	/* Apply body opening filter */
	$bodyFilter = captureEcho("zp_apply_filter('theme_body_open');");
	$page->addBodyData($bodyFilter);
}

function FormatBodyEnd(& $page, $skipLogin = false, $showSearch = false)
{
	global $_zp_options;
	/*
	 * Toolbox
	 */	
	$page->addBodyData('<div id="toolbox" class="ledge glossy colored">');
	if (function_exists('printLanguageSelector'))
	{
		$bodyData = captureEcho("printLanguageSelector();");
		$page->addBodyData($bodyData);
	}
	$bodyData = '<div id="rss"><h3>';
	$bodyData .= captureEcho("printRSSLink('Gallery','','RSS', '');");
	$bodyData .= '</h3></div>';
	$page->addBodyData($bodyData);

	if (getOption('Allow_search'))
	{
		$bodyData = captureEcho("printSearchForm('');");
		$page->addBodyData($bodyData);
	}
	
	$bodyFilter = captureEcho("printAdminToolbox();");
	$page->addBodyData($bodyFilter);

	if ((getOption('allow_login') == true) && ($skipLogin == false))
	{
		$bodyData = getLoginForm();
		$page->addBodyData($bodyData);
	}
	
	if (function_exists('printSlideShowLink') && $showSearch == true)
	{
		$slideShowText = gettext('View Slideshow');
		$slideShowData = captureEcho("printSlideShowLink('${slideShowText}');");
		if (strlen($slideShowData) > 0)
		{
			$bodyData = '<div id="slideshowlink">';
			$bodyData .= $slideShowData;
			$bodyData .= '</div>';
			$page->addBodyData($bodyData);
		}
	}
	
	if (getOption('allow_color_select') == true)
	{
		$bodyData = '<div id="colorselection" class="ledge light" ><form id="colorselectionform" method="post"';
		$bodyData .= ' action="javascript:issuePost(\'/photozen/index.php?p=useroption\', function (paramList) { retrieveParams(\'colorselectionform\', paramList); }, function (results) { HandleOptionChange(results);});">';
		$theme = basename(dirname(__FILE__));
		$themeroot = SERVERPATH . "/themes/$theme/styles";
		$bodyData .='<input type="hidden" id="command" name="command" value="theme_color"></input>';
		$bodyData .='<select id="themeselect_colors" name="theme_color"' . ">";
		$currentColor = $_zp_options['Theme_colors'];
		if (isset($_COOKIE['userColor']))
		{
			$currentColor = $_COOKIE['userColor'];
		}
		$bodyData .= captureEcho("generateListFromFiles('${currentColor}', '${themeroot}' , '.css');");
		$bodyData .= '</select><input type="submit" name="select" value="Select" title="Select" class="pushbutton" id="user_color"  />';
		$bodyData .= '</form></div>';
		$page->addBodyData($bodyData);
	}
	
	$page->addBodyData("</div>");
	
	/*----------------------------------------------*/
	if (getOption('show_branding'))
	{
		$bodyData = '<div id="credit" class="ledge colored">';
		$bodyData .= captureEcho("printCustomPageURL(\"" . gettext("Archive View") . '","archive");');
		$bodyData .= ' | ';

		if (getOption('zp_plugin_contact_form'))
		{
			$contactData = gettext('Contact us');
			$bodyData .= captureEcho("printCustomPageURL('${contactData}', 'contact', '', '', ' | ');");
		}
		
		if (getOption('allow_about_us') == true)
		{
			$aboutUs = gettext('About Us');
			$bodyData .= captureEcho("printCustomPageURL('${aboutUs}', 'about', '', '', ' | ');");
		}
		
		if (!zp_loggedin() && function_exists('printRegistrationForm'))
		{
			$registrationData = gettext('Register for this site');
			$bodyData .= captureEcho("printCustomPageURL('${registrationData}', 'register', '', '', ' | ');");
		}
		$bodyData .= captureEcho("printZenphotoLink();") . "</div>";
		$page->addBodyData($bodyData);
	}
	else
	{
		$theme = basename(dirname(__FILE__));
		$themeRoot = WEBPATH . '/' . THEMEFOLDER . "/${theme}/styles/structure/";
		$page->addStyleSheet(pathurlencode($themeRoot . 'nobranding.css'));
	}
	$bodyFilter = captureEcho("zp_apply_filter('theme_body_close');");
	$page->addBodyData($bodyFilter);

	// Now add in for init processing
	$javaScriptData =<<<JAVASCRIPTDATA
		$(document).ready( function () {
			afmInitializer.initialize();
	});
JAVASCRIPTDATA;
	$page->addInlineJavaScript($javaScriptData);
}

function getLoginForm()
{
	$loginForm = '<!-- userLogin -->';

	if (function_exists(printUserLogin_out))
	{
		if (zp_loggedin(NO_RIGHTS) == true)
		{
			$loginForm .= '<div id="logout">';
			$loginForm .= captureEcho("printUserLogin_out('', '', true);");
		}
		else
		{
			$loginForm .= '<div id="loginbtn">';
			$loginForm .= '<a class="link glossy light" href="javascript:toggleWindow(\'login\', \'loginbtn\', 0, 0, true);">Login</a>';
			$loginForm .= '</div><div id="login">';
			$loginForm .= captureEcho("printUserLogin_out('', ' | ', true);");
		}
		$loginForm .= '</div>';
	}
	else
	{
		$loginForm .= '<!-- disabled - enable the user login/logout extension -->';
	}
	$loginForm .= '<!-- form -->';

	// Return the login form
	return $loginForm;
}
?>