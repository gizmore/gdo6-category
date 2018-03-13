<?php /** @var $field \GDO\Category\GDT_Tree **/
use GDO\Category\GDO_Tree;
use GDO\Category\GDO_Category;
$id = 'gwftreecbx_'.$field->name;
$gdo = $field->gdo;
$gdo instanceof GDO_Tree;

# Build  Tree JSON
$json = [];
list($tree, $roots) = $gdo->full();

function __showTree(GDO_Category $leaf, $level=0)
{
	for ($i = 0; $i < $level; $i++)
	{
		echo "&dash;";
	}
	echo $leaf->displayName();
	echo "<br/>";
	foreach ($leaf->children as $child)
	{
		__showTree($child, $level+1);
	}
}

foreach ($roots as $root)
{
	__showTree($root);
}
