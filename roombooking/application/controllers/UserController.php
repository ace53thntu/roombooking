<?php
class UserController extends Zend_Controller_Action {
	
	private $user;
	
	public function init() {
		$this->user = new User();
	}
	
	/**
	 * User login action.
	 */
	public function loginAction() {
		$form = new LoginForm();
		$this->view->form = $form;
		if ($this->getRequest ()->isPost ()) {
			if ($form->isValid ( $_POST )) {
                $userName = $form->getValue("username");
                $password = $form->getValue("password");
                $user = $this->user->findByLogin($userName, $password);
                if (!empty($user)) {
                	SessionUtil::setProperty("userData", $user);
                	$this->_redirect("/");
                }
			}
		}
	}
	
	public function logoutAction() {
		SessionUtil::setProperty("userData", null);
		$this->_redirect("/");
		
	}
}
?>