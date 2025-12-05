<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  plg_system_nxdesignsframework
 * @copyright   Copyright (c) 2025 NXD | nx-designs
 *              All rights reserved
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;


class PlgSystemNxdesignsframeworkInstallerScript
{
	private $lowerThanJoomlaVersion = '4.4';
	private $minimumJoomlaVersion = '3.2';

	public function install($parent)
	{
		return true;
	}

	public function update($parent)
	{
		return true;
	}

	public function uninstall($parent)
	{
		return true;
	}

	public function preflight($type, $parent)
	{
		if ($type !== 'uninstall')
		{
			Factory::getApplication()->enqueueMessage('This extension requires Joomla! 3.2 or higher.');
			// Check maximum Joomla Version
			if (!empty($this->minimumJoomlaVersion) && version_compare(JVERSION, $this->minimumJoomlaVersion, '<'))
			{
				Factory::getApplication()->enqueueMessage(
					"This extension requires Joomla! $this->minimumJoomlaVersion or higher."
				, 'error');

				return false;
			}

			if(!empty($this->lowerThenJoomlaVersion) && version_compare(JVERSION, $this->lowerThanJoomlaVersion, '>='))
			{
				Factory::getApplication()->enqueueMessage(
					"This legacy version of this plugin is not compatible with Joomla! $this->lowerThanJoomlaVersion or higher. Please download the modernized version from NXD."
				, 'error');
				return false;
			}
		}

		return true;
	}
}