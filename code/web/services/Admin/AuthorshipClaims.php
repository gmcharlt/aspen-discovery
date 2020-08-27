<?php

require_once ROOT_DIR . '/Action.php';
require_once ROOT_DIR . '/services/Admin/Admin.php';
require_once ROOT_DIR . '/services/Admin/ObjectEditor.php';
require_once ROOT_DIR . '/sys/Archive/ClaimAuthorshipRequest.php';
class Admin_AuthorshipClaims extends ObjectEditor {
	function getObjectType(){
		return 'ClaimAuthorshipRequest';
	}
	function getToolName(){
		return 'AuthorshipClaims';
	}
	function getPageTitle(){
		return 'Claims of Authorship for Archive Materials';
	}
	function getAllObjects(){
		$list = array();

		$object = new ClaimAuthorshipRequest();
		$user = UserAccount::getLoggedInUser();
		if (!UserAccount::userHasRole('opacAdmin')){
			$homeLibrary = $user->getHomeLibrary();
			$archiveNamespace = $homeLibrary->archiveNamespace;
			$object->whereAdd("pid LIKE '{$archiveNamespace}:%'");
		}
		$object->orderBy('dateRequested desc');
		$object->find();
		while ($object->fetch()){
			$list[$object->id] = clone $object;
		}

		return $list;
	}
	function getObjectStructure(){
		return ClaimAuthorshipRequest::getObjectStructure();
	}
	function getAllowableRoles(){
		return array('opacAdmin', 'archives');
	}
	function getPrimaryKeyColumn(){
		return 'id';
	}
	function getIdKeyColumn(){
		return 'id';
	}
	function canAddNew(){
		return false;
	}
	function canDelete(){
		return UserAccount::userHasRole('opacAdmin');
	}

	function getBreadcrumbs()
	{
		$breadcrumbs = [];
		$breadcrumbs[] = new Breadcrumb('/Admin/Home', 'Administration Home');
		$breadcrumbs[] = new Breadcrumb('/Admin/Home#islandora_archive', 'Islandora Archives');
		$breadcrumbs[] = new Breadcrumb('/Admin/AuthorshipClaims', 'Authorship Claims');
		return $breadcrumbs;
	}

	function getActiveAdminSection()
	{
		return 'islandora_archive';
	}
}