<?php
namespace GDO\Category;
use GDO\Template\GDO_Template;
use GDO\DB\GDO_ObjectSelect;

/**
 * A selection for a Category object.
 * @author gizmore
 * @see Category
 */
final class GDO_Category extends GDO_ObjectSelect
{
	public function defaultLabel() { return $this->label('category'); }
	
	public function __construct()
	{
		$this->table(Category::table());
	}
	
	/**
	 * @return Category
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
		return GDO_Template::php('Category', 'cell/category.php', ['field'=>$this]);
	}
	
	public function renderChoice()
	{
		return GDO_Template::php('Category', 'choice/category.php', ['field'=>$this]);
	}
	
}
