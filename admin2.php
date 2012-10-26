<?php
include ("light-site.php");
$mSite = new SiteAdmin();

if (isset($_POST['formSubmitted'])){
	$mSite->pages->setTitle($_POST['oldPageTitle'], $_POST['newPageTitle']);
	$mSite->pages->setContent($_POST['oldPageTitle'], $_POST['newPageContent']);
	$mSite->saveData();
	header("location: {$_SERVER['REQUEST_URI']}");
}

$pageTitle = isset($_GET['p'])? $_GET['p'] : "" ;

if ( ($pageContent = $mSite->pages->getContentByTitle( $pageTitle )) === false ) {
	$pageTitle = $mSite->pages->getDefaultTitle();
	$pageContent = $mSite->pages->getDefaultContent();
}

$menuItems = $mSite->pages->getPageTitles();



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="default.css" />
<title> <?php echo $pageTitle; ?> </title>
<link rel="icon" type="image/ico" href="favicon.ico" />
</head>

<body>
<!-- PAGE START -------------------------------------------------------------->
	<a href="./index.php" style="float: left; color: #ffff00; "> Index </a> <br /> <!-- link for development -->
	<a href="./admin.php" style="float: left; color: #ffff00; "> Admin </a> <br /> <!-- link for development -->
	<a href="./admin2.php" style="float: left; color: #ffff00; "> Admin2 </a> <br /> <!-- link for development -->

	<!-- Top Picture -->
    <div id="mainPicture">
        <div class="picture"> </div>
    </div>
	
	<!-- Page title and Subtitle -->
	<div id="headerTitle"> <?php echo $pageTitle; ?> </div>
	<div id="headerSubtext"> <?php echo $pageTitle; ?> </div>
	
	<!-- MENU -->
	<div id="menu">
        <?php 
		foreach ($menuItems as &$menuItem ) {
			if ($pageTitle == $menuItem )
				echo "<div class='topNavigationLink'><a style='font-weight: bold; text-decoration:underline;' href='admin2.php?p=$menuItem'> $menuItem </a></div>\n";
			else
				echo "<div class='topNavigationLink'><a href='admin2.php?p=$menuItem'> $menuItem </a></div>\n";
		}
		?>
    </div>
	
	<!-- CONTENT -->
	<form method="post" action="<?=$_SERVER['REQUEST_URI']?>" >
	<input type='hidden' name='formSubmitted' value='1' >
	<input type='hidden' name='oldPageTitle' value='<?=$pageTitle?>' >
	<div class="contentBox">
		<div class="innerBox">
			<div class="contentTitle">
				<input type='text' name ='newPageTitle' value='<?=$pageTitle?>' /> 
			</div>
			<div class="contentText">
				<textarea name='newPageContent' style="width: 100%; height: 150px;"><?php echo $pageContent; ?></textarea>
			</div>
		</div>
		<input type='submit' value='Submit' name='submit' />
	</div>
	
	</form>
	<!-- FOOTER -->
	<div id="footer"> 
		<a> footer links . . . </a>
	</div>
	
<!-- PAGE END -------------------------------------------------------------->
</body>
</html>
