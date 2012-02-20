<?php

// force UTF-8 Ø

/* Plug-in for theme option handling
 * The Admin Options page tests for the presence of this file in a theme folder
 * If it is present it is linked to with a require_once call.
 * If it is not present, no theme options are displayed.
 *
*/

class ThemeOptions {

	function ThemeOptions() {
		setThemeOptionDefault('Allow_search', true);
		setThemeOptionDefault('Theme_colors', 'default');
		setThemeOptionDefault('albums_per_row', 2);
		setThemeOptionDefault('images_per_row', 5);
		setThemeOptionDefault('thumb_transition', 1);
		setThemeOptionDefault('show_branding', true);
		setThemeOptionDefault('allow_login', true);
		setThemeOptionDefault('allow_color_select', false);
		setThemeOptionDefault('show_home_link', false);
		setThemeOptionDefault('about_us', '');
		setThemeOptionDefault('allow_about_us', true);
		setOptionDefault('zp_plugin_colorbox', 1);
		setOptionDefault('zp_plugin_contact_form', true);
		setOptionDefault('colorbox_default_album', 1);
		setOptionDefault('colorbox_default_image', 1);
		setOptionDefault('colorbox_default_search', 1);
	}

	function getOptionsSupported() {
		return array(	gettext('Allow search') => array('key' => 'Allow_search', 'type' => OPTION_TYPE_CHECKBOX, 'desc' => gettext('Check to enable search form.')),
						gettext('Theme colors') => array('key' => 'Theme_colors', 'type' => OPTION_TYPE_CUSTOM, 'desc' => gettext('Select the colors of the theme')),
						gettext('Show Branding') => array('key' => 'show_branding', 'type' => OPTION_TYPE_CHECKBOX, 'desc' => gettext('Check to enable showing theme branding.')),
						gettext('Allow Color Change') => array('key' => 'allow_color_select', 'type' => OPTION_TYPE_CHECKBOX, 'desc' => gettext('Check to enable the user to change the color selection.')),
						gettext('Show Home Link') => array('key' => 'show_home_link', 'type' => OPTION_TYPE_CHECKBOX, 'desc' => gettext('Check to add a link to your main site.')),
						gettext('Show About Us Link') => array('key' => 'allow_about_us', 'type' => OPTION_TYPE_CHECKBOX, 'desc' => gettext('Check to enable the link for the about us page.')),
						gettext('About us page') => array('key' => 'about_us', 'type' => OPTION_TYPE_TEXTAREA, 'desc' => gettext('Enter the data about you.')),
						gettext('Allow user login') => array('key' => 'allow_login', 'type' => OPTION_TYPE_CHECKBOX, 'desc' => gettext('Check to enable users logging in.'))
		);
	}

  function getOptionsDisabled() {
  	return array('custom_index_page');
  }

	function handleOption($option, $currentValue)
	{
		switch ($option)
		{
			case 'Theme_colors':
			{
				$theme = basename(dirname(__FILE__));
				$themeroot = SERVERPATH . "/themes/$theme/styles";
				echo '<select id="Default_themeselect_colors" name="' . $option . '"' . ">\n";
				generateListFromFiles($currentValue, $themeroot , '.css');
				echo "</select>\n";
			}
			break;
		}
	}
}
?>
