<?php
namespace GDO\Category\Method;

use GDO\Core\Method;
use GDO\Core\MethodAdmin;
use GDO\Category\Module_Category;

final class Overview extends Method
{
    use MethodAdmin;
    
    public function getPermission() { return 'staff'; }
	
    public function beforeExecute()
    {
        $this->renderNavBar();
        Module_Category::instance()->renderAdminTabs();
    }
    
	public function execute()
	{
		return $this->templatePHP('overview.php');
	}

}
