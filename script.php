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
use Joomla\CMS\Language\Text;
use Joomla\CMS\Log\Log;


class PlgSystemNxdesignsframeworkInstallerScript
{
	private $minimumJoomlaVersion = '4.4';

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
			// Check minimum Joomla Version
			if (!empty($this->minimumJoomlaVersion) && version_compare(JVERSION, $this->minimumJoomlaVersion, '<'))
			{
				Log::add(Text::sprintf('JLIB_INSTALLER_MINIMUM_JOOMLA', $this->minimumJoomlaVersion), Log::WARNING, 'jerror');
				Factory::getApplication()->enqueueMessage(Text::sprintf('JLIB_INSTALLER_MINIMUM_JOOMLA', $this->minimumJoomlaVersion), 'error');
				return false;
			}
		}

		return true;
	}
}