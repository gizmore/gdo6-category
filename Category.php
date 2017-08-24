<?php
namespace GDO\Category;

use GDO\DB\Cache;
use GDO\DB\GDO_AutoInc;
use GDO\Type\GDO_Name;
/**
 * Category table inherits Tree.
 * 
 * @author gizmore
 * @since 2.0
 * @version 5.0
 */
final class Category extends Tree
{
	###########
	### GDO ###
	###########
	public function memCached() { return false; }
	public function gdoTreePrefix() { return 'cat'; }
	public function gdoColumns()
	{
		return array_merge(array(
			GDO_AutoInc::make('cat_id'),
			GDO_Name::make('cat_name'),
		), parent::gdoColumns());
	}

	##############
	### Getter ###
	##############
	public function getName() { return $this->getVar('cat_name'); }
	public function displayName() { return html($this->getName()); }
	public function href_edit() { return href('Category', 'Edit', '&id='.$this->getID()); }

	#############
	### Cache ###
	#############
	public function rebuildFullTree()
	{
		Cache::unset('gwf_category');
		parent::rebuildFullTree();
	}
	public function all()
	{
		if (!($cache = Cache::get('gwf_category')))
		{
			$cache = self::table()->select('*')->order('cat_left')->exec()->fetchAllArray2dObject();
			Cache::set('gwf_category', $cache);
		}
		return $cache;
	}
	
	##############
	### Render ###
	##############
	public function renderCell()
	{
		return GDO_Category::make('cat')->gdo($this)->renderCell();
	}
	public function renderChoice()
	{
		return GDO_Category::make('cat')->gdo($this)->renderChoice();
		
	}
}
