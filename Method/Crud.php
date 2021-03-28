<?php
namespace GDO\Category\Method;

use GDO\Form\MethodCrud;
use GDO\Category\GDO_Category;
use GDO\Form\GDT_Form;
use GDO\Core\GDO;
use GDO\DB\Cache;
use GDO\Category\GDT_Category;
use GDO\Core\MethodAdmin;
use GDO\Category\Module_Category;

/**
 * Add and edit categories.
 * @author gizmore
 * @since 6.02
 * @version 6.07
 */
final class Crud extends MethodCrud
{
    use MethodAdmin;
    
	public function getPermission() { return 'staff'; }
	
	public function beforeExecute()
	{
	    $this->renderNavBar();
	    Module_Category::instance()->renderAdminTabs();
	}
	
	public function gdoTable()
	{
		return GDO_Category::table();
	}

	public function hrefList()
	{
		return href('Category', 'Overview');
	}
	
	public function createForm(GDT_Form $form)
	{
		$table = $this->gdoTable();
		$form->addFields(array(
			$table->gdoColumn('cat_name'),
			GDT_Category::make('cat_parent')->emptyLabel('select_parent_category'),
		));
		$this->createFormButtons($form);
	}
	
	public function afterCreate(GDT_Form $form, GDO $gdo) { $this->afterChange($gdo); }
	public function afterUpdate(GDT_Form $form, GDO $gdo) { $this->afterChange($gdo); }
	public function afterChange(GDO_Category $category)
	{
		GDO_Category::table()->rebuildFullTree();
		Cache::remove('gdo_category');
	}
	
}
