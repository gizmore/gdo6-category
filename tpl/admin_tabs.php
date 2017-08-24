<?php
use GDO\Template\GDO_Bar;
use GDO\UI\GDO_Link;

$bar = GDO_Bar::make('tabs');
$bar->addFields(array(
	GDO_Link::make('add')->href(href('Category', 'Add')),
	GDO_Link::make('tree')->href(href('Category', 'Rebuild')),
));
echo $bar->render();
