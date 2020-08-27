<?php

require_once ROOT_DIR . '/Action.php';
require_once ROOT_DIR . '/services/Admin/ObjectEditor.php';
require_once ROOT_DIR . '/sys/Enrichment/SyndeticsSetting.php';

class Enrichment_SyndeticsSettings extends ObjectEditor
{
	function getObjectType()
	{
		return 'SyndeticsSetting';
	}

	function getToolName()
	{
		return 'SyndeticsSettings';
	}

	function getModule()
	{
		return 'Enrichment';
	}

	function getPageTitle()
	{
		return 'Syndetics Settings';
	}

	function getAllObjects()
	{
		$object = new SyndeticsSetting();
		$object->find();
		$objectList = array();
		while ($object->fetch()) {
			$objectList[$object->id] = clone $object;
		}
		return $objectList;
	}

	function getObjectStructure()
	{
		return SyndeticsSetting::getObjectStructure();
	}

	function getPrimaryKeyColumn()
	{
		return 'id';
	}

	function getIdKeyColumn()
	{
		return 'id';
	}

	function getAllowableRoles()
	{
		return array('opacAdmin', 'libraryAdmin');
	}

	function canAddNew()
	{
		return UserAccount::userHasRole('opacAdmin');
	}

	function canDelete()
	{
		return UserAccount::userHasRole('opacAdmin');
	}

	function getAdditionalObjectActions($existingObject)
	{
		return [];
	}

	function getInstructions()
	{
		return '';
	}

	function getBreadcrumbs()
	{
		$breadcrumbs = [];
		$breadcrumbs[] = new Breadcrumb('/Admin/Home', 'Administration Home');
		$breadcrumbs[] = new Breadcrumb('/Admin/Home#third_party_enrichment', 'Third Party Enrichment');
		$breadcrumbs[] = new Breadcrumb('/Enrichment/SyndeticsSettings', 'Syndetics Settings');
		return $breadcrumbs;
	}

	function getActiveAdminSection()
	{
		return 'third_party_enrichment';
	}
}