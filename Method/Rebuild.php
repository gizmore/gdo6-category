<?php
namespace GDO\Category\Method;

use GDO\Category\GDO_Category;
use GDO\Category\Module_Category;
use GDO\Form\GDT_AntiCSRF;
use GDO\Form\GDT_Form;
use GDO\Form\GDT_Submit;
use GDO\Form\MethodForm;

final class Rebuild extends MethodForm
{
	public function execute()
	{
		$module = Module_Category::instance();
		return $module->renderAdminTabs()->add(parent::execute())->add($this->renderTree());
	}
	
	public function createForm(GDT_Form $form)
	{
		$form->addFields(array(
			GDT_AntiCSRF::make(),
			GDT_Submit::make(),
		));
	}
	
	public function formValidated(GDT_Form $form)
	{
		GDO_Category::table()->rebuildFullTree();
		return $this->message('msg_cat_tree_rebuilt');
	}
	
	### Tree
	public function renderTree()
	{
		return $this->templatePHP('rebuild.php');
	}
}
