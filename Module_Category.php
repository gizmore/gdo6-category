<?php
namespace GDO\Category;

use GDO\Core\Module;

final class Module_Category extends Module
{
	public $module_priority = 30;
	
	public function onLoadLanguage() { $this->loadLanguage('lang/category'); }
	public function getClasses() { return ['GDO\Category\Category']; }
	public function href_administrate_module() { return href('Category', 'Overview'); }
	
	##############
	### Render ###
	##############
	public function renderAdminTabs()
	{
		return $this->templatePHP('admin_tabs.php');
	}
	
}
