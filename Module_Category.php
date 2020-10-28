<?php
namespace GDO\Category;

use GDO\Core\GDO_Module;

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
		return $this->responsePHP('admin_tabs.php');
	}
	
}
