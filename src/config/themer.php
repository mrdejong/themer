<?php

return array(
	/**
	 * Describe the location where the themes can be found.
	 */
	'themes_path'		=> app_path().'/themes',
    
    /**
     * The path where composer installs packages.
     */
    'vendor_path'       => base_path().'/vendor',

	/**
	 * The directory name of the default theme.
	 * This will be used if the active theme doesn't exist.
	 */
	'active_theme'		=> 'default',

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
