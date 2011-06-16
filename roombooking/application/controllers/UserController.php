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
		$next = $this->_getParam ( "next" );
		$form = new LoginForm ( $next );
		$this->view->form = $form;
		if ($this->getRequest ()->isPost ()) {
			if ($form->isValid ( $_POST )) {
                $userName = $form->getValue("username");
                $password = $form->getValue("password");
                $next = $form->getValue("next");
                $user = $this->user->findByLogin($userName, $password);
                if (!empty($user)) {
                	SessionUtil::setProperty("userData", $user);
                	if (!empty($next)) {
                		$this->_redirect($next);
                	} else {
                		$this->_redirect("/");
                	}
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