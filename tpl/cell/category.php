<?php
use GDO\Category\GDO_Category;
$field instanceof GDO_Category;
?>
<?php
if ($category = $field->getCategory())
{
	echo $category->displayName();
}
else
{
	echo t('no_category');
}
