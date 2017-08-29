<?php
use GDO\Category\Category;
use GDO\Category\GDT_Tree;

$gdo = Category::table();

echo GDT_Tree::make('tree')->gdo($gdo)->renderCell();
