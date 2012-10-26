<?php
include ("light-site.php");

$mSiteAdmin = new SiteAdmin();
$mSiteAdmin->createForm();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="default.css" />
<title> Admin - mode </title>
<link rel="icon" type="image/ico" href="favicon.ico" />

<script src="jquery.js"> </script>
<script>
function myClickHandler() { 
	$("[id*='content']").height(30);
	$(this).parent().find('textarea').height(250);
}

$(document).ready(function(){
	// Initialize height through CSS 
	//$("[id*='content']").height(30);
	//$("[id *= 'title' ]").click(myClickHandler);
	$("[id *= 'content' ]").click(myClickHandler);
	
	$(".deleteCheckbox").mouseenter(function(){
		$(this).append("<div style='width: 400px;margin-left: 20px; color: #ff3030; ' > Επιλογή για διαγραφή αυτής της σελίδας </div>");
	});
	
	$(".deleteCheckbox").mouseleave(function(){
		$(this).find('div').remove();
	});
});
</script>

<style type="text/css">

fieldset .row 
{
	background-color: #DDCCCC;
	padding: 10px;
	margin-bottom: 10px;	
}

input
{
	//display: block;
	margin-bottom:5px;
	background-color: #DDDDDD;
	font-weight: bold;
}

.deleteCheckbox
{
	float: right;
}

textarea
{
	width: 95%;
	height:30px;
	margin-right: 20px;
	margin-bottom:20px;
	background-color: #EEEEEE;
}

.submitButton {
	
}
</style>
</head>

<body>
<!-- PAGE START -------------------------------------------------------------->
	<a href="./index.php" style="float: left; color: #ffff00; "> Index </a> <br /> <!-- link for development -->
	<a href="./admin.php" style="float: left; color: #ffff00; "> Admin </a> <br /> <!-- link for development -->
	<a href="./admin2.php" style="float: left; color: #ffff00; "> Admin2 </a> <br /> <!-- link for development -->
	
	<!-- Page title and Subtitle -->
	<div id="headerTitle"> Admin - mode </div>
	<div id="headerSubtext"> </div>
	
	<!-- CONTENT -->
	<div class="contentBox">
		<div class="innerBox">
			<div class="contentTitle"> 
				<?php echo "Admin - Mode"; ?> 
			</div>
			<div class="contentText">
				<?php
					$mSiteAdmin->handleForm();
					$mSiteAdmin->printForm();
				?>
			</div>
		</div>
	</div>
	
<!-- PAGE END -------------------------------------------------------------->
</body>
</html>
