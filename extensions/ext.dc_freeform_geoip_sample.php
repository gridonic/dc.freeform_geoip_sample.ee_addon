<?php
//SVN $Id$
/*
=====================================================
DC FreeForm GeoIP Sample
-----------------------------------------------------
http://www.designchuchi.ch/
-----------------------------------------------------
Copyright (c) 2008 - today Designchuchi
=====================================================
THIS MODULE IS PROVIDED "AS IS" WITHOUT WARRANTY OF
ANY KIND OR NATURE, EITHER EXPRESSED OR IMPLIED,
INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES
OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE,
OR NON-INFRINGEMENT.
=====================================================
File: ext.dc_freeform_geoip.php
-----------------------------------------------------
Purpose:	Sample extension showing how to hook into
			main DC FreeForm GeoIP extension.
=====================================================
*/

if (!defined('EXT'))
{
	exit('Invalid file request');
}

class DC_FreeForm_GeoIP_Sample
{

	var $settings		= array();

	var $name			= 'DC FreeForm GeoIP Extension Sample';
	var $version		= '1.0.0';
	var $description	= 'Sample extension showing how to hook into main DC FreeForm GeoIP extension.';
	var $settings_exist = 'n';
	var $docs_url		= '';

	// -------------------------------
	//	Constructor - Extensions use this for settings
	// -------------------------------
	function DC_FreeForm_GeoIP_Sample($settings='')
	{
		$this->settings = $settings;
	}

	// --------------------------------
	//	Activate Extension
	// --------------------------------

	function activate_extension()
	{
		global $DB;
		
		// hooks array
		$hooks = array(
			'dc_freeform_geocode_ip'		 => 'dc_freeform_geocode_ip'
		);

		foreach ($hooks as $hook => $method)
		{
			$sql[] = $DB->insert_string('exp_extensions',
				array(
					'extension_id'	=> '',
					'class'			=> get_class($this),
					'method'		=> $method,
					'hook'			=> $hook,
					'settings'		=> '',
					'priority'		=> 10,
					'version'		=> $this->version,
					'enabled'		=> 'y'
				)
			);
		}

		// run all sql queries
		foreach ($sql as $query)
		{
			$DB->query($query);
		}

		return TRUE;
	}

	// --------------------------------
	//	Update Extension
	// --------------------------------
	function update_extension($current = '')
	{
		//	=============================================
		//	Is Current?
		//	=============================================
		if ($current == '' OR $current == $this->version)
		{
			return FALSE;
		}
		
		// Does nothing.
	}

	// --------------------------------
	//	Disable Extension
	// --------------------------------
	function disable_extension()
	{
		global $DB;

		$sql[] = "DELETE FROM exp_extensions WHERE class = '" . get_class($this) . "'";

		// run all sql queries
		foreach ($sql as $query)
		{
			$DB->query($query);
		}
	}
	
	/**
	 * Hook for geocoding an IP.
	 * 
	 * @param	string		$ip		The ip to geocode.
	 * @since   Version 1.0.0
	 */
	function dc_freeform_geocode_ip($ip) {
		global $EXT;

		// If there's someone else using this hook, get out of here
		if($EXT->last_call !== FALSE)
		{
			return $EXT->last_call;
		}
		
		// If not, do whatever you want with the IP and return a string
		return 'Here could be some sample geocoding data. IP was: ' . $ip;
	}
}
//END CLASS
?>