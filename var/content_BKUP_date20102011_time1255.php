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
	public function __construct ($requestedPage){
		$this->pageContent = new PageContent(self::$dataFileName);
		$this->footerContent = new FooterContent(self::$dataFileName);
		
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
	public function printFooter(){
		$this->footerContent->printFooter();
	}
	public function saveContent(){
		ob_start();
		
		echo $this->pageContent->exportData();
		echo $this->footerContent->exportData();
		
		$str = ob_get_clean();
		file_put_contents(self::$dataFileName, "<?php\n".$str);
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
		foreach( $this->pageDataArray as &$menuItem)
			if ($menuItem['title'] == $title) return $menuItem['content'];
		
		reset( $this->pageDataArray );
		return current( $this->pageDataArray );
	}
	public function exportData(){
		if(!isset( $this->pageDataArray ))
			return false;
		else{
			$ret = var_export($this->pageDataArray, true);
			if ($ret) return "\$pageData = ".$ret.";\n";
			else return false;
		}
	}
	private function loadData(){
		require($this->dataFileName);
		$this->pageDataArray = $pageData;
	}

}

class FooterContent implements Content {
		public  $dataFileName;
		private $footerDataArray;
	public function __construct($flnm){
		$this->dataFileName = $flnm;
		$this->loadData();
	}

	public function printFooter(){
		foreach ($this->footerDataArray as &$footerLink ){
			$link = $footerLink['link'];
			$text = $footerLink['text'];
			echo "<a href='$link' > $text </a>";
		}
	}
	public function exportData(){
		if (!isset( $this->footerDataArray ))
			return false;
		else{
			$ret = var_export( $this->footerDataArray, true);
			if ($ret) return "\$footerData = ".$ret.";\n";
			else return false;
		}
	}
	private function loadData(){
		require($this->dataFileName);
		$this->footerDataArray = $footerData;
	}
}