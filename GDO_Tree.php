<?php
namespace GDO\Category;
use GDO\DB\WithObject;
use GDO\Form\GDO_Select;
use GDO\Template\GDO_Template;

/**
 * Tree view.
 * The gdo handled should inherit from Tree.
 * 
 * @author gizmore
 * @since 5.0
 */
class GDO_Tree extends GDO_Select
{
    use WithObject;

	public function renderCell()
	{
		return GDO_Template::php('Category', 'cell/tree.php', ['field' => $this]);
	}
	
	public function render()
	{
	    return GDO_Template::php('Category', 'form/tree.php', ['field' => $this]);
	}
	
}
