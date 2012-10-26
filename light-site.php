<?php

class Site {

	protected static $dataFileName = "data.php";
	public $pages;
	
	public function __construct (){
		$this->pages = new Pages(self::$dataFileName);
	}
	
}

class SiteAdmin extends Site {

	protected $form, $newPageTitle, $pagesFieldset;
	
	public function __construct(){
		parent::__construct();
		$this->pages->setEditable(true);
		require_once 'HTML/QuickForm2.php';
	}
	public function saveData(){
		ob_start();
		echo $this->pages->saveData();
		$str = ob_get_clean();
		return file_put_contents(self::$dataFileName, "<?php\n\n".$str);
	}
	private function addPageToForm(&$title, $content, $key){
		$group = $this->pagesFieldset->addElement('group', 'page-'.$key);
		$group->appendChild(HTML_QuickForm2_Factory::createElement('text', 'title', array('size' => 30, 'maxlength' => 30))->setValue($title));
		$group->appendChild(HTML_QuickForm2_Factory::createElement('checkbox', 'delete', array('class' => 'deleteCheckbox') ));		
		$group->appendChild(HTML_QuickForm2_Factory::createElement('textarea', 'content', array('size' => 50, 'maxlength' => 5000 ))->setValue($content));
	}

	public function createForm(){
		$this->form = new HTML_Quickform2('pagesEditForm');
		
		$fieldset = $this->form->addElement('fieldset')->setLabel('Νέα σελίδα');
		$this->newPageTitle = $fieldset->addElement('text', 'newPage')->setLabel('Τίτλος Νέας Σελίδας');
		
		$this->pagesFieldset = $this->form->addElement('fieldset')->setLabel('Επεξεργασία σελίδων');
		foreach($this->pages->getDataArray() as $key=>$page) {
			$this->addPageToForm($page['title'], $page['content'], $key);
		}
		$this->form->addElement('submit', null, array('value' => 'Καταχώρηση Αλλαγών', 'class' => 'submitButton' ));
	
	}
	public function handleForm(){
		if ( !$this->form->isSubmitted() ) return;
		if ( !isset($this->form) ) $this->createForm();
		
		// Read new page data
		$newPageDataArray = array();
		foreach($this->pagesFieldset->getElements() as $e) {
			if($e->getType()!='group') continue; // Skip any non-group elements
			$group = $e->getElements();
			if ($group[1]->getValue()) continue; // if user checked delete checkbox we discard this page by not adding it to the new dataArray
			
			$title = $group[0]->getValue();
			$content = $group[2]->getValue();
			
			array_push( $newPageDataArray, array('title' => $title, 'content' => $content));
		}
		
		// Add the new page if there is one
		if ( ($nt = $this->newPageTitle->getValue()) != ""){
			array_push( $newPageDataArray, array('title' => $nt, 'content' => ""));
			$this->addPageToForm($nt, "", NULL); // After proccessing tha new data the page is redirected so that new Page appears in the form
		}
		
		
		$this->pages->setDataArray($newPageDataArray);
		
		if ( $this->saveData() ){
			header('location: admin.php');
			echo "<h3> Οι αλλαγές κατοχυρώθηκαν ! </h3> <hr /> <br />";
			}
		else
			echo "<h3> Παρουσιάστηκε πρόβλημα κατα την ενημέρωση του περιεχομένου. </h3> <hr /> <br /> ";
		
	}
	public function printForm(){
		echo $this->form;
	}
	
}

class Pages {

	protected $dataFileName, $pageDataArray, $read_only;
		
	public function __construct($flnm){
		$this->read_only = true;
		$this->dataFileName = $flnm;
		$this->loadData();
	}
	private function loadData(){
		require($this->dataFileName);
		$this->pageDataArray = $pageData;
	}
	
	public function setEditable($val){
		if ( !is_bool($val) ) return false;
		$this->read_only = $val;
		return true;
	}
	public function getDataArray(){
		return $this->pageDataArray;
	}
	public function getPageTitles(){
		$pageDataArray = array();
		foreach ( $this->pageDataArray as &$page )
			$pageDataArray[] = $page['title'];

		return $pageDataArray;
	}
	public function getContentByTitle($title){
		foreach( $this->pageDataArray as &$page)
			if ($page['title'] == $title) return $page['content'];
		
		return false;
	}
	public function getDefaultTitle(){
		if(count($this->pageDataArray) != 0)
			return $this->pageDataArray[0]['title'];
		return false;
	}
	public function getDefaultContent(){	
		if(count($this->pageDataArray) != 0)
			return $this->pageDataArray[0]['content'];
		return false;
	}
	
	public function addPage($title, $content){
		//array_push($this->pageDataArray, array('title' => $title, 'content' => $content));
		$this->pageDataArray[] =  array('title' => $title, 'content' => $content);
	}
	public function setTitle($oldTitle, $newTitle) {
		foreach( $this->pageDataArray as &$page){
			if ($page['title'] == $oldTitle) {
				$page['title'] = $newTitle;
				return;
			}
		}
		return false;
	}
	public function setContent($title, $newContent) {
		foreach( $this->pageDataArray as &$page){
			if ($page['title'] == $title) {
				$page['content'] = $newContent;
				return;
			}
		}
		return false;
	}	
	public function setDataArray($newData){
		$this->pageDataArray = $newData;
	}
	public function saveData(){
		if(!isset( $this->pageDataArray ))
			return false;
		else{
			$ret = var_export($this->pageDataArray, true);
			if ($ret) return "\$pageData = ".$ret.";\n\n";
			else return false;
		}
	}
	
}
