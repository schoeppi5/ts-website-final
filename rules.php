<?php
	include("header.php");
	include("include/nav.php");
	
	include("lib/parsedown/Parsedown.php");
?>
<div class="news-con">
	<?php
		$test = file_get_contents("content/rules_".$_SESSION['lang'].".md");
	
		$pd = new Parsedown();
		echo $pd->text($test);
	?>
</div>
<?php
	include("include/footer.php");
?>