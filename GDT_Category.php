<?php
namespace GDO\Category;
use GDO\Template\GDT_Template;
use GDO\DB\GDT_ObjectSelect;

/**
 * A selection for a Category object.
 * @author gizmore
 * @see Category
 */
final class GDT_Category extends GDT_ObjectSelect
{
	public function defaultLabel() { return $this->label('category'); }
	
	public function __construct()
	{
	    $this->table(GDO_Category::table());
	}
	
	/**
	 * @return GDO_Category
	 */
	public function getCategory()
	{
		return $this->getValue();
	}
	
	public function withCompletion()
	{
	 	$this->completionHref(href('Category', 'Completion'));
	}
	
	public function renderCell()
	{
		return GDT_Template::php('Category', 'cell/category.php', ['field'=>$this]);
	}
	
	public function renderChoice()
	{
		return GDT_Template::php('Category', 'choice/category.php', ['field'=>$this]);
	}
	
}
