<?php
include ("light-site.php");

$mSite = new Site();
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
    <div id="siteTitle">
        <a href='./index.php' > <h1> LightSite </h1> </a>
    </div>

    <!-- Page title and Subtitle -->
    <div id="headerTitle"> <?php echo $pageTitle; ?> </div>
    <div id="headerSubtext"> <?php echo $pageTitle; ?> </div>

    <!-- MENU -->
    <div id="menu">
        <?php
        foreach ($menuItems as &$menuItem ) {
            if ($pageTitle == $menuItem )
                echo "<div class='topNavigationLink'><a style='font-weight: bold; text-decoration:underline;' href='index.php?p=$menuItem'> $menuItem </a></div>\n";
            else
                echo "<div class='topNavigationLink'><a href='index.php?p=$menuItem'> $menuItem </a></div>\n";
        }
        ?>
    </div>

    <!-- CONTENT -->
    <div class="contentBox">
        <div class="innerBox">
            <div class="contentTitle">
                <?php echo $pageTitle; ?>
            </div>
            <div class="contentText">
                <?php echo nl2br($pageContent); ?>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <div id="footer">
        <a> footer links . . . </a>
    </div>

<!-- PAGE END -------------------------------------------------------------->
</body>
</html>
