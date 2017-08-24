<?php
namespace GDO\Category\Method;

use GDO\Category\Category;
use GDO\Category\Module_Category;
use GDO\Form\GDO_AntiCSRF;
use GDO\Form\GDO_Form;
use GDO\Form\GDO_Submit;
use GDO\Form\MethodForm;

final class Rebuild extends MethodForm
{
	public function execute()
	{
		$module = Module_Category::instance();
		return $module->renderAdminTabs()->add(parent::execute())->add($this->renderTree());
	}
	
	public function createForm(GDO_Form $form)
	{
		$form->addFields(array(
			GDO_AntiCSRF::make(),
			GDO_Submit::make(),
		));
	}
	
	public function formValidated(GDO_Form $form)
	{
		Category::table()->rebuildFullTree();
		return $this->message('msg_cat_tree_rebuilt');
	}
	
	### Tree
	public function renderTree()
	{
		return $this->templatePHP('rebuild.php');
	}
}
