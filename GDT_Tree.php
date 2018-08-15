<?php
namespace GDO\Category;
use GDO\DB\WithObject;
use GDO\Form\GDT_Select;
use GDO\Core\GDT_Template;

/**
 * Tree view.
 * The gdo handled should inherit from Tree.
 * 
 * @author gizmore
 * @since 5.0
 */
class GDT_Tree extends GDT_Select
{
	use WithObject;

	public function renderCell()
	{
		return GDT_Template::php('Category', 'cell/tree.php', ['field' => $this]);
	}
	
	public function render()
	{
		return GDT_Template::php('Category', 'form/tree.php', ['field' => $this]);
	}
	
}
