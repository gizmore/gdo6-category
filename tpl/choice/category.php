<?php
use GDO\Category\GDT_Category;
/** @var $field GDT_Category **/
$category = $field->gdo;
echo str_repeat('+', $category->getDepth()) . $category->displayName();
