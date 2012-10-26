<?php

interface Content {
	public function exportData();
}

class SiteContent {
		private static $dataFileName = "__data.php";
		private $currentPage;
		private $currentContent;
		private $pageContent;
		private $footerContent;	
		
	public function __construct ($requestedPage=""){
		$this->pageContent = new PageContent(self::$dataFileName);
		
		$pageTitles = $this->getPageTitles();
		
		if (isset($requestedPage))
			$this->currentPage = $requestedPage; // Not safe to return here because the requested page was a GET parameter which has to be validated.
		else {
			$this->currentPage = $pageTitles[0];
			return; // Safe to return here.
		}
		
		if (array_search($requestedPage, $pageTitles) === false)
			$this->currentPage = $pageTitles[0];
	}
	
	public function getCurrentPageTitle(){
		return $this->currentPage;
	}
	public function getCurrentPageContent(){
		return $this->pageContent->getContentByTitle($this->currentPage);
	}
	public function getPageTitles(){
		return $this->pageContent->getPageTitles();
	}
	public function getPageContentArray(){
		return $this->pageContent->getArray();	
	}
	public function printFooter(){
		$this->footerContent->printFooter();
	}
	public function setData($newData){
		$this->pageContent->setData($newData);
	}
	public function saveData(){
		ob_start();
		
		echo $this->pageContent->exportData();
		
		$str = ob_get_clean();
		return file_put_contents(self::$dataFileName, "<?php\n\n".$str);
	}
}

class PageContent implements Content {
		private $dataFileName;
		private $pageDataArray;
		
	public function __construct($flnm){
		$this->dataFileName = $flnm;
		$this->loadData();
	}
	public function getPageTitles(){
		$i = 0;
		foreach ( $this->pageDataArray as &$page )
			$pageDataArray[$i++] = $page['title'];

		return $pageDataArray;
	}
	public function getContentByTitle($title){
		foreach( $this->pageDataArray as &$page)
			if ($page['title'] == $title) return $page['content'];
		
		reset( $this->pageDataArray );
		return current( $this->pageDataArray );
	}
	public function editTitle($oldTitle, $newTitle) {
		foreach( $this->pageDataArray as &$page){
			if ($page['title'] == $oldTitle) {
				$page['title'] = $newTitle;
				return;
			}
		}
		return false;
	}
	public function editContent($title, $newContent) {
		foreach( $this->pageDataArray as &$page){
			if ($page['title'] == $title) {
				$page['content'] = $newContent;
				return;
			}
		}
		return false;
	}
	public function getArray(){
		return $this->pageDataArray;
	}
	public function setData($newData){
		$this->pageDataArray = $newData;
	}
	public function exportData(){
		if(!isset( $this->pageDataArray ))
			return false;
		else{
			$ret = var_export($this->pageDataArray, true);
			if ($ret) return "\$pageData = ".$ret.";\n\n";
			else return false;
		}
	}
	private function loadData(){
		require($this->dataFileName);
		$this->pageDataArray = $pageData;
	}
	
}


/*  gpap@ime.gr */
//
// function setData($data=array())	
// function update()
//