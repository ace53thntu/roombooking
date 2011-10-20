<?php
class Zend_Controller_Action_Helper_Paginator extends Zend_Controller_Action_Helper_Abstract {
	
	/**
	 * @param $data data in to be shown on view
	 */
	public function direct($currentPage, $pageSize, $data) {
		$paginator = Zend_Paginator::factory($data);
		$paginator->setItemCountPerPage($pageSize);
		$paginator->setCurrentPageNumber($currentPage);
		return $paginator;
	}
}
?>