<?phpuse GDO\Category\GDT_Category;
/** @var $field GDT_Category **/
if ($category = $field->getCategory())
{
	echo $category->displayName();
}
else
{
	echo t('no_category');
}
