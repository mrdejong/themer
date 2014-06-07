<?php

return array(
	/**
	 * Describe the location where the themes can be found.
	 */
	'themes_path'		=> app_path().'/themes',

	/**
	 * The directory name of the default theme.
	 * This will be used if the active theme doesn't exist.
	 */
	'active_theme'		=> 'default',

	/**
	 * There is a active theme listed in the database
	 * and there is one listed here.
	 *
	 * Wich one will get the priority
	 *
	 * You can choose:
	 *
	 * -1 - The configuration file is the only real deal, ignore the rest.
	 * 0 - The one in the themes database table has the priority.
	 * 1 - The one which will be provided by an user. (In this case you 
	 * 	   should configure the 'users' part in this configuration file). (Not implemented yet)
	 */
	'active_theme_priority'	=> 0,

	/**
	 * Everytheme should be packaged with a info.php file.
	 * This file should contain all the information of
	 * the theme.
	 *
	 * This configuration option tells themer what variables
	 * are required in the info.php file.
	 *
	 * If the theme info file doesn't contain valid information
	 * it won't be added to the themes stack, and thus the
	 * theme will be ignored.
	 *
	 * This isn't strict in anyway, if a theme has more information
	 * then listed here it'll be perfectly fine!
	 */
	'required_info'			=> array(
		'title'					=> true, // A human readable title :)
		'description'			=> true // A bit of information about the theme.
	),

	/**
	 * If set to false, themer won't check the required_info option.
	 */
	'validate_info'			=> false,

	/**
	 * Should a theme be required to have a info file?
	 *
	 * !!Alert!! If this is set to false, themer won't check for
	 * the required info parameters listed in the 'required_info' option.
	 */
	'require_info_file'		=> false,

	/**
	 * Themer provides a build-in ajax api to activate/deactivate themes.
	 * It also gives functionallity to get information of themes.
	 * 
	 * This is handy in an ajax based backend application.
	 * 
	 * This way you only have to provide the front-end functionallity.
	 */
	'enable_api_routes'		=> true
);
