<?php
use GDO\UI\GDT_Bar;
use GDO\UI\GDT_Link;

$bar = GDT_Bar::make('tabs');
$bar->addFields(array(
	GDT_Link::make('add')->href(href('Category', 'Add')),
	GDT_Link::make('tree')->href(href('Category', 'Rebuild')),
));
echo $bar->render();
