<?php
namespace GDO\Category\Method;

use GDO\Core\Method;
use GDO\Core\MethodAdmin;

final class Overview extends Method
{
    use MethodAdmin;
    
    public function getPermission() { return 'staff'; }
	
	public function execute()
	{
		return $this->renderNavBar()->add($this->templatePHP('overview.php'));
	}
}
