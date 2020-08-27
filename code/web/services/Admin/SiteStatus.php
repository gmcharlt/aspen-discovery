<?php

require_once ROOT_DIR . '/Action.php';
require_once ROOT_DIR . '/services/Admin/Admin.php';

class Admin_SiteStatus extends Admin_Admin
{
	function launch()
	{
		global $configArray;
		global $interface;

		require_once ROOT_DIR . '/services/API/SearchAPI.php';
		$indexStatus = new SearchAPI();
		$aspenStatus = $indexStatus->getIndexStatus();
		$interface->assign('aspenStatus', $aspenStatus);
		$interface->assign('aspenStatusMessages', explode(';', $aspenStatus['message']));

		// Load SOLR Statistics
		$solrStatus = @file_get_contents($configArray['Index']['url'] . '/admin/cores');

		if ($solrStatus) {
			$data = json_decode($solrStatus, true);
			$interface->assign('data', $data['status']);
		}

		$this->display('siteStatus.tpl', 'Aspen Discovery Status');
	}

	function getAllowableRoles()
	{
		return array('userAdmin', 'opacAdmin');
	}

	function getBreadcrumbs()
	{
		$breadcrumbs = [];
		$breadcrumbs[] = new Breadcrumb('/Admin/Home', 'Administration Home');
		$breadcrumbs[] = new Breadcrumb('/Admin/Home#system_reports', 'System Reports');
		$breadcrumbs[] = new Breadcrumb('', 'Site Status');
		return $breadcrumbs;
	}

	function getActiveAdminSection()
	{
		return 'system_reports';
	}
}