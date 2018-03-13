<?php
namespace GDO\Category\Method;

use GDO\Category\GDO_Category;
use GDO\Form\GDT_Form;
use GDO\Form\MethodForm;

final class Edit extends MethodForm
{
	public function hrefList()
	{
		return href('Category', 'Overview');
	}

	public function createForm(GDT_Form $form)
	{
		$form->addFields(array());
	}


	
}
