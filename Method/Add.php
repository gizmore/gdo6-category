<?php
namespace GDO\Category\Method;

use GDO\Category\Category;
use GDO\Category\GDO_Category;
use GDO\Core\Website;
use GDO\DB\Cache;
use GDO\Form\GDO_AntiCSRF;
use GDO\Form\GDO_Form;
use GDO\Form\GDO_Submit;
use GDO\Form\MethodForm;

final class Add extends MethodForm
{
	public function createForm(GDO_Form $form)
	{
		$table = Category::table();
		$form->addField($table->gdoColumn('cat_name'));
		$form->addField(GDO_Category::make('cat_parent')->emptyLabel('select_parent_category'));
		$form->addField(GDO_AntiCSRF::make());
		$form->addField(GDO_Submit::make());
	}
	
	public function formValidated(GDO_Form $form)
	{
		Category::blank($form->getFormData())->insert();
		Category::table()->rebuildFullTree();
		Cache::unset('gwf_category');
		return $this->message('msg_category_added')->add(Website::redirectMessage(href('Category', 'Overview')));
	}
}
