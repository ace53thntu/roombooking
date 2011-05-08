<?php
class Elements {
	
	/**
	 * Add captcha element to the given form.
	 * 
	 * @param $form
	 */
	public function addCaptcha($form) {
		$config = Zend_Registry::get('config');
		$form->addElement(
			'Captcha', 'captcha', 
			array (
			'label' => 'Can you see it?',
			'required' => true, 
			'captcha' => array (
				'captcha' => 'image', 
				'name' => 'foo', 
				'wordLen' => 6, 
				'font' => $config->captcha->font->dir, 
				'fontSize' => 28, 
				'imgDir' => $config->captcha->img->dir, 
				'imgUrl' => $config->captcha->img->url, 
				'timeout' => 300,
				'gcFreq' => 10) ) 
		);
	}
}
?>