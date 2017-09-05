<?php
namespace GDO\Category;

use GDO\DB\Cache;
use GDO\DB\GDT_AutoInc;
use GDO\Type\GDT_Name;
/**
 * GDO_Category table inherits Tree.
 * 
 * @author gizmore
 * @since 2.0
 * @version 5.0
 */
final class GDO_Category extends GDO_Tree
{
	###########
	### GDO ###
	###########
	public function memCached() { return false; }
	public function gdoTreePrefix() { return 'cat'; }
	public function gdoColumns()
	{
		return array_merge(array(
			GDT_AutoInc::make('cat_id'),
			GDT_Name::make('cat_name'),
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
		Cache::unset('gdo_category');
		parent::rebuildFullTree();
	}
	public function all()
	{
		if (false === ($cache = Cache::get('gdo_category')))
		{
			$cache = self::table()->select('*')->order('cat_left')->exec()->fetchAllArray2dObject();
			Cache::set('gdo_category', $cache);
		}
		return $cache;
	}
	
	##############
	### Render ###
	##############
	public function renderCell()
	{
		return GDT_Category::make('cat')->gdo($this)->renderCell();
	}
	public function renderChoice()
	{
		return GDT_Category::make('cat')->gdo($this)->renderChoice();
		
	}
}
