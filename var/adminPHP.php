require_once ("LIGHTSITE.php");
require_once 'HTML/QuickForm2.php';
$c = new SiteContent();

$form = new HTML_Quickform2('pageEditForm');

/* Create the form */
$fieldset = $form->addElement('fieldset')->setLabel('Νέα σελίδα');
$newPageTitle = $fieldset->addElement('text', 'newPage')->setLabel('Τίτλος σελίδας');
$fieldset = $form->addElement('fieldset')->setLabel('Επεξεργασία σελίδων');

foreach($c->getPageContentArray() as $key=>$page) {
	$group = $fieldset->addElement('group', 'page-'.$key);
	
	$group->appendChild(HTML_QuickForm2_Factory::createElement('text', 'title', array('size' => 30, 'maxlength' => 30))->setValue($page['title']));
	
	$group->appendChild(HTML_QuickForm2_Factory::createElement('checkbox', 'delete'))->SetLabel('Διαγραφή σελίδας');
	
	$group->appendChild(HTML_QuickForm2_Factory::createElement('textarea', 'content', array('size' => 50, 'maxlength' => 5000 ))->setValue($page['content']));
}
$form->addElement('submit', null, array('value' => 'Καταχώρηση Αλλαγών'));

/* Handle submitted values */
if ($form->isSubmitted()){
	$newPageDataArray = array();
	foreach($fieldset->getElements() as $e) { // $fieldset has refferrence to the fieldset of page groups 
		// Skip any non-group elements
		if($e->getType()!='group') continue; 
		// Get submitted title and content
		$group = $e->getElements();
		
		$title = $group[0]->getValue();
		$content = $group[1]->getValue();
		
		array_push( $newPageDataArray, array('title' => $title, 'content' => $content));
	}
	
	if ( ($nt = $newPageTitle->getValue()) != ""){
		array_push( $newPageDataArray, array('title' => $nt, 'content' => ""));
		
		$group = $fieldset->addElement('group', 'page-');
	
		$group->appendChild(HTML_QuickForm2_Factory::createElement('text', 'title', array('size' => 30, 'maxlength' => 30))->setValue($nt));
		
		$group->appendChild(HTML_QuickForm2_Factory::createElement('checkbox', 'delete'))->SetLabel('Διαγραφή σελίδας');
		
		$group->appendChild(HTML_QuickForm2_Factory::createElement('textarea', 'content', array('size' => 50, 'maxlength' => 5000 ))->setValue(""));
	}
	
	$c->setData($newPageDataArray);
	
	
	if ( $c->saveData() ){
		header('location: admin.php');
		echo "<h3> Οι αλλαγές κατοχυρώθηκαν ! </h3> <hr /> <br />";
		}
	else
		echo "<h3> Παρουσιάστηκε πρόβλημα κατα την ενημέρωση του περιεχομένου. </h3> <hr /> <br /> ";
	
}