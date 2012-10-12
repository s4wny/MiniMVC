<!DOCTYPE HTML>
<html>
<head>
    <title>MiniMVC!</title>
	<!-- Obs, VIEWFOLDER för att få länken till MiniMVC/View folder -->
	<link href="<?=VIEWFOLDER?>/css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <div id="wrapper">
        <h1>MiniMVC!</h1>
    	<p>Testa att skriva in /hello/, /hello/*ditt namn*, /profile/demo! eller klicka på någon av länkarna :)</p><br>
		<a href="<?=MINIMVCFOLDER?>/hello/Sony%3f">/hello/Sony?</a>    <br>
		<a href="<?=MINIMVCFOLDER?>/hello/Sony?">/hello/Foo</a>        <br>
		<a href="<?=MINIMVCFOLDER?>/profile/Sony%3f">/profile/Sony?</a><br>
		<a href="<?=MINIMVCFOLDER?>/profile/demo">/profile/demo</a>    <br>
		
		<br>
		<br>
		<p>Resultat</p>
		<hr />
    	<br>
		
        <? if(isset($info)) : ?>
    	    <p>Info om <?= $name ?> <br><?= $info ?></p>
    	<? elseif(isset($name)) : ?>
    	    <p>Hej <b><?=$name?></b></p>
        <? elseif(isset($error)) : ?>
    	    <p style="color:red;">Error: <?=$error?></p>
    	<? endif; ?>
    </div>
</body>
</html>