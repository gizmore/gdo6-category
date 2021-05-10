<?php
namespace GDO\Category;

use GDO\Core\GDO_Module;
use GDO\UI\GDT_Page;

final class Module_Category extends GDO_Module
{
	public $module_priority = 20;
	
	public function onLoadLanguage() { $this->loadLanguage('lang/category'); }
	public function getClasses() { return ['GDO\Category\GDO_Category']; }
	public function href_administrate_module() { return href('Category', 'Overview'); }
	
	##############
	### Render ###
	##############
	public function renderAdminTabs()
	{
	    GDT_Page::$INSTANCE->topTabs->addField(
	        $this->templatePHP('admin_tabs.php'));
	}
	
}
