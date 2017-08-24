<?php
use GDO\Category\Category;
use GDO\Category\GDO_Tree;

$gdo = Category::table();

echo GDO_Tree::make('tree')->gdo($gdo)->renderCell();
