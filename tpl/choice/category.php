<?php
use GDO\Category\GDT_Category;
$field instanceof GDT_Category;
?>
<?php
$category = $field->gdo; //getCategory();
echo str_repeat('+', $category->getDepth()) . $category->displayName();

