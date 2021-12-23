<?php
namespace GDO\Category;

use GDO\Core\GDO;
use GDO\DB\GDT_Object;
use GDO\DB\GDT_Int;
use GDO\DB\GDT_String;
use GDO\DB\GDT_Index;

/**
 * Abstract Tree class stolen from sitepoint.
 * To select a partial of the tree look for items that have a LEFT between parent left and right.
 * 
 * @see http://articles.sitepoint.com/article/hierarchical-data-database/3
 * @author gizmore
 * @version 6.10
 * @since 6.02
 */
abstract class GDO_Tree extends GDO
{
    /**
     * @var self[]
     */
    public $children = [];
    
    /**
     * 
     * @return string
     */
    public function gdoTreePrefix() { return 'tree'; }

	###########
	### GDO ###
	###########
	public function gdoAbstract() { return $this->gdoClassName() === 'GDO\Category\GDO_Tree'; }
	public function gdoColumns()
	{
		$pre = $this->gdoTreePrefix();
		return array(
		    GDT_Object::make($pre.'_parent')->table(GDO::tableFor($this->gdoClassName()))->searchable(false),
		    GDT_String::make($pre.'_path')->binary()->max(128)->searchable(false),
			GDT_Int::make($pre.'_depth')->unsigned()->bytes(1)->searchable(false),
		    GDT_Int::make($pre.'_left')->unsigned()->searchable(false),
		    GDT_Int::make($pre.'_right')->unsigned()->searchable(false),
		    GDT_Index::make($pre.'_left_index')->btree()->indexColumns($pre.'_left'),
		    GDT_Index::make($pre.'_parent_index')->btree()->indexColumns($pre.'_parent'),
		);
	}
	
	public function getIDColumn() { return $this->gdoPrimaryKeyColumn()->identifier(); }
	public function getParentColumn() { return $this->gdoTreePrefix().'_parent'; }
	public function getParentID() { return $this->getVar($this->getParentColumn()); }
	public function getParent() { return $this->getValue($this->getParentColumn()); }
	
	public function getDepthColumn() { return $this->gdoTreePrefix().'_depth'; }
	public function getDepth() { return $this->getVar($this->getDepthColumn()); }
	
	public function getPathColumn() { return $this->gdoTreePrefix().'_path'; }
	public function getPath() { return $this->getVar($this->getPathColumn()); }
	
	public function getLeftColumn() { return $this->gdoTreePrefix().'_left'; }
	public function getLeft() { return $this->getVar($this->getLeftColumn()); }

	public function getRightColumn() { return $this->gdoTreePrefix().'_right'; }
	public function getRight() { return $this->getVar($this->getRightColumn()); }

	################
	### Get Tree ###
	################
	public function getTreeIDWhereClause()
	{
	    $left = $this->getLeftColumn();
	    $l = $this->getLeft();
	    $r = $this->getRight();
	    return "$left BETWEEN $l AND $r";
	}
	
	/**
	 * @return self[]
	 */
	public function getChildren()
	{
	    if (!$this->children)
	    {
    	    $p = $this->getParentColumn();
    	    $condition = "{$p}={$this->getID()}";
    	    $this->children = self::table()->select()->
    	       where($condition)->
    	       exec()->fetchAllObjects();
	    }
	    return $this->children;
	}
	
	/**
	 * Get sub tree.
	 * @return self[]
	 */
	public function getTree()
	{
	    $pre = $this->gdoTreePrefix();
	    $left = $pre.'_left';
	    return $this->select('*')->
    	    where($this->getTreeIDWhereClause())->
    	    order($left)->exec()->fetchAllObjects();
	}
	
	###############
	### Connect ###
	###############
	/**
	 * @return self[]
	 */
	public function &all($order=null, $json=false)
	{
		$order = $order ? $order : $this->gdoTableIdentifier().'.'.$this->getLeftColumn();
		return parent::all($order, $json);
	}
	
	/**
	 * Get all items as all and only roots (those with no parent)
	 * @return self[][]
	 */
	public function full()
	{
		$roots = [];
		$tree = $this->table()->all();
		
		foreach ($tree as $leaf)
		{
		    $leaf->children = [];
		}
		
		foreach ($tree as $leaf)
		{
			$leaf instanceof GDO_Tree;
			$pid = $leaf->getParentID();
			if (isset($tree[$pid]))
			{
				$parent = $tree[$pid];
				$parent->children[] = $leaf;
			}
			else
			{
				$roots[] = $leaf;
			}
		}
		$result = [$tree, $roots];
		return $result;
	}
	
	public function fullRoots()
	{
	    return $this->full()[1];
	}
	
	public function toJSON()
	{
		return array(
			'id' => (int)$this->getID(),
			'selected' => false,
			'colapsed' => false,
			'name' => $this->getName(),
			'label' => $this->displayName(),
			'depth' => (int)$this->getDepth(),
			'parent' => (int)$this->getParentID(),
			'children' => $this->getChildrenJSON(),
		);
	}
	
	public function getChildrenJSON()
	{
		$json = [];
		foreach ($this->children as $child)
		{
			$json[] = $child->toJSON();
		}
		return empty($json) ? null : $json;
	}
	
	
	###############
	### Rebuild ###
	###############
	public function gdoAfterCreate()
	{
		$this->rebuildFullTree();
	}
	
	public function rebuildFullTree()
	{
		$this->rebuildTree(null, 1, 0);
		
		$roots = $this->fullRoots();
		foreach ($roots as $leaf)
		{
			$this->rebuildPath($leaf);
		}
	}

	private function rebuildTree($parent, $left, $depth)
	{
		$right = $left + 1;

		$p = $this->getParentColumn();
		$idc = $this->getIDColumn();

		$where = $parent ? "$p=$parent" : "$p IS NULL";
		$result = $this->table()->select($idc, false)->where($where)->exec()->fetchAllValues();
		foreach ($result as $id)
		{
			$right = $this->rebuildTree($id, $right, $depth+1);
		}

		$l = $this->getLeftColumn();
		$r = $this->getRightColumn();
		$d = $this->getDepthColumn();
		if ($parent)
		{
			$this->table()->update()->set("$l=$left, $r=$right, $d=$depth")->where("$idc=$parent")->exec();
		}
		return $right+1;
	}
	
	private function rebuildPath(GDO_Tree $leaf, $path='-')
	{
		$path = $path . $leaf->getID() . '-';
		$leaf->saveVar($this->getPathColumn(), $path);
		if ($leaf->children)
		{
			foreach ($leaf->children as $child)
			{
				$this->rebuildPath($child, $path);
			}
		}
	}
}
