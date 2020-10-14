<?php /** @var $field \GDO\Category\GDT_Tree **/
use GDO\Category\GDO_Tree;
use GDO\Category\GDO_Category;
use GDO\UI\GDT_Icon;
$gdo = $field->gdo;
$gdo instanceof GDO_Tree;

# Build  Tree JSON
$roots = $gdo->fullRoots();

function __showTree(GDO_Category $leaf, $level=0)
{
	for ($i = 0; $i < $level; $i++)
	{
		echo GDT_Icon::iconS('plus');
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
