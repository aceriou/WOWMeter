<?php
$login_required = 1;
require 'header.php';
?>
	<style type="text/css">
	.box {
		min-width: 75%
	} 
	</style>
	<div class="box small no-title headline">
		<h2>Which code do I use?</h2>
	</div>
	<div class="box small no-title" style="text-align:left;width: 80%">
    <strong>BBCode</strong><br>
    For messaging boards and other websites that allows BBCodes.<br>
    <strong>HTML</strong><br>
    For your own websites and other websites that allows the &lt;img&gt; and &lt;a&gt; HTML tags.<br>
    <strong>Direct link</strong><br>
    For sharing on websites that only allows basic links.<br>
    <strong>Supporting websites</strong><br>
    Supporting websites are websites who supports a special BBCode made for WOWMeter.<br>
    You can find a list of supporting websites <a href="/supporting.php">here</a>.
    <br>
    <a href="javascript:window.close();window.location='/';void(0)" class="button blue ico-right right">Go back</a>
	</div>
<?php $no_script = 1; require 'main.php'; ?>
