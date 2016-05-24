<?php require 'header.php'; ?>
<script type="text/javascript">
	setInterval(function() {
		$(".tut_pointer").fadeIn(400, function() {
			$(".tut_pointer").animate({
				"bottom": "-20px"
			}, 1000, function() {
				$(".tut_pointer").css("transform", "scale(0.9)");
				$(".tut_pointer").css("transform", "scale(1)");
				$(".tut_ex_sig span").html(parseFloat($(".tut_ex_sig span").html()) + 1);
				$(".tut_pointer").fadeOut(400, function() {
					$(".tut_pointer").remove();
					$(".tut_ex_sig").append("<div class=\"tut_pointer\"></div>");
					var pointer_pos = Math.floor(Math.random() * 210) + 1;
					pointer_pos *= Math.floor(Math.random() * 2) == 1 ? 1 : -1;
					$(".tut_pointer").css({
						"background-position": "-" + Math.floor(Math.random() * (3 - 0 + 1) + 0) * 18 + "px 0",
						"left": pointer_pos
					});
				});
			});
		});
	}, 500);
</script>
<style type="text/css">
	.tut_ex_sig {
		position: relative;
		width: 240px;
		height: 66px;
		text-align: center;
		margin: 0 auto;
		font-family: "Hand of Sean", sans-serif;
		background: url(https://wowmeter.us/$acerio?blank=1) no-repeat;
		font-size: 14px;
		color: #fff;
		text-shadow: 0 1px 0 rgba(0, 0, 0, 0.6);
		cursor: pointer;
		-webkit-user-select: none;
		-moz-user-select: none;
		user-select: none;
	}

	.tut_pointer {
		position: absolute;
		width: 18px;
		height: 24px;
		background: url(/images/tut_cursors.png);
		left: 0;
		right: 0;
		bottom: -45px;
		margin: 0 auto;
		display: none;
	}

	.tut_ex_forumpost {
		padding: 10px 0;
		box-shadow: 0px 2px 5px #aaa;
		border-radius: 5px;
	}

	.topic_profile_pic {
		float: left;
		margin-left: 15px;
		margin-right: 15px;
		width: 100px;
		text-align: center;
	}

	.topic_profile_pic img {
		width: 52px;
		height: 52px;
		-webkit-border-radius: 100%;
		-moz-border-radius: 100%;
		border-radius: 100%;
	}

	.post_signature {
		border-top: 1px dashed #dedede;
		padding: 1px;
		padding-top: 5px;
		display: inline-block;
	}

	.tut_editor {
		display: inline-block;
		float: right;
		position: relative;
		width: 258px;
		height: 240px;
		margin: 0 auto;
		padding: 71px 8px;
		background: url(/images/tut_editor.png) no-repeat bottom;
		-webkit-user-select: none;
		-moz-user-select: none;
		user-select: none;
	}

	.tut_editor h4 {
		position: absolute;
		top: 0;
		left: 0;
		color: gray;
		font-family: sans-serif;
	}
</style>
<div class="box small no-title headline">
	<h1>"What is WOWMeter?"</h1>
	<h4 class="text-right"><small>And how do I use it?</small></h4>
</div>
<div class="box small no-title" style="text-align:left;min-width:60%">
	<p>WOWMeter is a little meter that allows you to collect "WOWs" given by other people by clicking your WOWMeter in other websites. It was made by Preston Cammarata and Erman Sayin.</p><br>
	<h5>Example of a WOWMeter:</h5>
	<div class="tut_ex_forumpost">
		<div class="topic_profile_pic">
			<img src="/images/tut_ava.png">
			<small><a href="#">KandyKane</a></small>
		</div>
		<div class="topic-text">
			<h3><small>RE: Forum post</small></h3> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur placerat.
			<div class="post_signature">
				<i><strong>Give me a wow for being awesome!!</strong></i>
				<div class="tut_ex_sig" onclick='$(".tut_ex_sig span").html(parseFloat($(".tut_ex_sig span").html())+1)'>
					KandyKane<br> has collected <span>0</span> wows.<br> Click here to give a wow!
					<div class="tut_pointer"></div>
				</div>
			</div>
		</div>
	</div>
	<br>
	<br>
	<h5>What is a "WOW"?</h5>
	<blockquote style="color:#000"><strong>wow</strong><br>
		<span style="color:gray">/waʊ/</span><br> noun
		<br>
		<i>excitement, interest, great pleasure, or the like.</i>
	</blockquote>
	<br>
	A WOW is a token of appreciation, and/or showing interest, in which you can receive from other people by them clicking your WOWMeter signature on message boards, chatrooms, websites, and more.<br><br>
	<h5>How do I put my own WOWMeter on other sites?</h5>
	You can use these codes in your signature on forums, or other sites, as well as just send them a direct link, but that doesn't provide an image.
	<table style="width:100%">
		<tbody>
			<tr>
				<td>BBCode </td>
				<td><textarea id="bbcode-code" readonly="">[url=http://wowmeter.us/@KandyKane][img]http://wowmeter.us/$KandyKane[/img][/url]</textarea></td>
			</tr>
			<tr>
				<td>HTML </td>
				<td><textarea id="html-code" readonly="">&lt;a href="http://wowmeter.us/@KandyKane"&gt;&lt;img src="http://wowmeter.us/$KandyKane" alt="Give KandyKane a wow"/&gt;&lt;/a&gt;</textarea></td>
			</tr>
			<tr>
				<td>Supporting &nbsp;<br>websites <a href="javascript:window.open('/supporting.php','windowNew','width=320, height=400');void(0)">(?)</a></td>
				<td><input type="text" value="[wow=KandyKane]" id="sn-code" readonly=""></td>
			</tr>
			<tr>
				<td>Direct link</td>
				<td style="padding-bottom:4px"><input type="text" value="http://wowmeter.us/@KandyKane" id="direct-code" readonly=""></td>
			</tr>
		</tbody>
	</table><br>
	<h5>How do I customize my WOWMeter signature?</h5>
	<br>
	Goto the settings in the "Your WOWMeter" panel. You can customize your WOWMeter signature with a variety of preset backgrounds such as Snoop Dogge, normal Doge, etc, as well as request a custom image. You can also use custom colors and make a totally cool signature such as these:
	<br><br>
	<div style="text-align:center;">
		<sup>These signatures are not clickable!</sup>
		<br>
		<img src="https://wowmeter.us/$acerio"></img><img src="https://wowmeter.us/$marioermando"></img><img src="https://wowmeter.us/$justin"></img>
	</div>
</div>
<?php $no_script = 1; require 'main.php'; ?>
