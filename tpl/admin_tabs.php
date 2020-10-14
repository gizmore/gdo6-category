<?php
use GDO\UI\GDT_Bar;
use GDO\UI\GDT_Link;

$bar = GDT_Bar::make('tabs')->horizontal();
$bar->addFields(array(
    GDT_Link::make('btn_overview')->href(href('Category', 'Overview'))->icon('view'),
    GDT_Link::make('btn_create')->href(href('Category', 'Crud'))->icon('add'),
    GDT_Link::make('tree')->href(href('Category', 'Rebuild'))->icon('settings'),
));
echo $bar->render();
