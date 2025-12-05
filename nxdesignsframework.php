<?php
/**
 * @package    nx-designs Framework (plg_system_nxdesignsframework)
 *
 * @author     Marco Rensch | nx-designs <support@nx-designs.ch>
 * @copyright  Copyright© 2025 by nx-designs
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * @link       http://www.nx-designs.ch
 */

defined('_JEXEC') or die;
use Joomla\CMS\Factory;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Uri\Uri;

class plgSystemNxdesignsframework extends CMSPlugin
{
	public function onInstallerBeforePackageDownload(&$url, &$headers)
	{
		$uri = Uri::getInstance($url);

		// Only process if a user attempts to update extensions purchase on NXD

		$host       = $uri->getHost();
		$validHosts = array('nx-designs.ch', 'www.nx-designs.ch');

		if (!in_array($host, $validHosts))
		{
			return true;
		}

		// Only process if the update is handled via Membership Pro
		$option     = $uri->getVar('option');
		$documentId = (int) $uri->getVar('document_id');

		if ($option != 'com_osmembership' || !$documentId)
		{
			return true;
		}

		$downloadId = $this->params->get('download_id');

		// Append the Download ID to the download URL
		if (!empty($downloadId))
		{
			$uri->setVar('download_id', $downloadId);

			// Append the current site domain to URL for logging and validation as our rule is each Download ID will only valid for one domain
			$siteUri = Uri::getInstance();
			$uri->setVar('domain', $siteUri->getHost());

			$url = $uri->toString();
		}

		return true;
	}

	public function onAfterRenderModules(){
		
	}

	public function onBeforeRender(){
	    // Adds here maps api token to HEAD (frontend and backend)
		$hereMapsApiToken = $this->params->get('heremaps_api_token');
		if ($hereMapsApiToken){
			$wa = Factory::getApplication()->getDocument()->getWebAssetManager();
			$js = 'const NXD_FW_HERE_MAPS_API_TOKEN = "'.trim($hereMapsApiToken).'";';
			$wa->addInlineScript($js);
		}
    }
}
