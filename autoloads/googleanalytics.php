<?php
//
// ## BEGIN COPYRIGHT, LICENSE AND WARRANTY NOTICE ##
// SOFTWARE NAME: eZ Google Analytics Interface
// SOFTWARE RELEASE: 1.7.0
// COPYRIGHT NOTICE: Copyright (C) 1999-2010 eZ Systems AS
// SOFTWARE LICENSE: GNU General Public License v2.0
// NOTICE: >
//   This program is free software; you can redistribute it and/or
//   modify it under the terms of version 2.0  of the GNU General
//   Public License as published by the Free Software Foundation.
//
//   This program is distributed in the hope that it will be useful,
//   but WITHOUT ANY WARRANTY; without even the implied warranty of
//   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//   GNU General Public License for more details.
//
//   You should have received a copy of version 2.0 of the GNU General
//   Public License along with this program; if not, write to the Free
//   Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
//   MA 02110-1301, USA.
//
//
// ## END COPYRIGHT, LICENSE AND WARRANTY NOTICE ##
//
class googleAnalytics
{
	/**
	 * @var string
	 */
	private static $ini;
	/**
	 * 
	 * Enter description here ...
	 */
	function googleAnalytics()
	{
		googleAnalytics::$ini = eZINI::instance('googleanalytics.ini');
	}
	function operatorList()
	{
		return array(
					'display_ga');
	}
	function namedParameterPerOperator()
	{
		return true;
	}
	function namedParameterList()
	{
		return array(
					'display_ga'=>array());
	}
	function modify($tpl,$operatorName,$operatorParameters,&$rootNamespace,&$currentNamespace,&$operatorValue,&$namedParameters)
	{
		$namedParameters = array_merge(array(
											'display_tags'=>true),$namedParameters);
		$google_account = $this->getIni()->variable('SiteSettings','GoogleAccount');
		if(((class_exists('detectBots',true) && !detectBots::isBot()) || !class_exists('detectBots',true)) && !empty($google_account))
		{
			switch($operatorName)
			{
				case 'display_ga':
					$tpl = eZTemplate::factory();
					$tpl->setVariable('google_account',$google_account);
					foreach($namedParameters as $namedParameterName=>$namedParameterValue)
						$tpl->setVariable($namedParameterName,$namedParameterValue);
					return ($operatorValue = $tpl->fetch('design:google-analytics.tpl'));
					break;
			}
		}
	}
	/**
	 * Instanciate ini object
	 * @param string ini file name
	 * @return googleAnalytics
	 */
	public static function instance($_fileName = 'googleanalytics.ini')
	{
		$self = new self();
		googleAnalytics::$ini = eZINI::instance($_fileName);
		return $self;
	}
	/**
	 * Return ezIni object
	 * @return eZINI
	 */
	public function getIni()
	{
		return googleAnalytics::$ini;
	}
}
?>
