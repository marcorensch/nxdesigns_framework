<?php
/**
 * @package    nx-designs Framework (plg_system_nxdesignsframework)
 *
 * @author     Marco Rensch | nx-designs <support@nx-designs.ch>
 * @copyright  Copyright© 2021 by nx-designs
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * @link       http://www.nx-designs.ch
 */

defined('_JEXEC') or die;
use Joomla\CMS\Factory;

class plgSystemNxdesignsframework extends JPlugin
{
	public function onInstallerBeforePackageDownload(&$url, &$headers)
	{
		$uri = JUri::getInstance($url);

		// Only process if user attempt to update extensions purchase on your site

		$host       = $uri->getHost();
		$validHosts = array('nx-designs.ch', 'www.nx-designs.ch');

		if (!in_array($host, $validHosts))
		{
			return true;
		}

		// Only process if update is handled via Membership Pro
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
			$siteUri = JUri::getInstance();
			$uri->setVar('domain', $siteUri->getHost());

			$url = $uri->toString();
		}

		return true;
	}

	public function onAfterRenderModules(){
		
	}

	public function onBeforeRender(){
	    // Adds here maps api token to HEAD (frontend and backend)
		$heremapsApiToken = $this->params->get('heremaps_api_token');
		if (!empty($heremapsApiToken)){
			$doc = Factory::getDocument();
			$js = 'const nxdHereMapsApiToken = "'.$heremapsApiToken.'";';
	    	$doc->addScriptDeclaration($js);
		}
		
    }
}
