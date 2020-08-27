<?php

require_once ROOT_DIR . '/Action.php';
require_once ROOT_DIR . '/services/Admin/IndexingLog.php';
require_once ROOT_DIR . '/sys/WebsiteIndexing/WebsiteIndexLogEntry.php';

class Websites_IndexingLog extends Admin_IndexingLog
{
	function getIndexLogEntryObject(): BaseLogEntry
	{
		return new WebsiteIndexLogEntry();
	}

	function getTemplateName() : string
	{
		return 'websiteIndexLog.tpl';
	}

	function getTitle() : string
	{
		return 'Website Indexing Log';
	}

	function getModule() : string{
		return 'Websites';
	}

	function applyMinProcessedFilter(DataObject $indexingObject, $minProcessed){
		if ($indexingObject instanceof WebsiteIndexLogEntry){
			$indexingObject->whereAdd('(numAdded + numDeleted + numUpdated) >= ' . $minProcessed);
		}
	}

	function getAllowableRoles(){
		return array('opacAdmin', 'libraryAdmin', 'cataloging', 'superCataloger');
	}

	function getBreadcrumbs()
	{
		$breadcrumbs = [];
		$breadcrumbs[] = new Breadcrumb('/Admin/Home', 'Administration Home');
		$breadcrumbs[] = new Breadcrumb('/Admin/Home#web_indexer', 'Website Indexing');
		$breadcrumbs[] = new Breadcrumb('', 'Indexing Log');
		return $breadcrumbs;
	}

	function getActiveAdminSection()
	{
		return 'web_indexer';
	}
}