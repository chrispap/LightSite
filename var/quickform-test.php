<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title> ΤΕΣΤ </title>
</head>

<body>
<?php
require_once 'HTML/QuickForm2.php';

$form = new HTML_Quickform2('pageEditForm');

$fieldset = $form->addElement('fieldset')->setLabel('Επεξεργασία σελίδας');
$name = $fieldset->addElement('text', 'name', array('size' => 50, 'maxlength' => 30))->setLabel('ΤΙΤΛΟΣ ΣΕΛΙΔΑΣ:');
$name = $fieldset->addElement('textarea', 'name', array('size' => 50, 'maxlength' => 30))->setLabel('ΤΙΤΛΟΣ ΣΕΛΙΔΑΣ:');
$fieldset->addElement('submit', null, array('value' => 'εφαρμογή αλλαγής'));

echo $form;
?> 

</body>
</html>

