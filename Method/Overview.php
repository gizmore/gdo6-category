<?php
namespace GDO\Category\Method;

use GDO\Core\Method;

final class Overview extends Method
{
	public function getPermission() { return 'staff'; }
	
	public function execute()
	{
		return $this->templatePHP('overview.php');
	}
}
