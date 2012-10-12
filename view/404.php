<?php
    /*
        Default 404 filen.
        Du kan ändra allt här för din egen 404 sida.
        I settings.php kan du ändra namn på 404 filen.
    */
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>404</title>
    <style type="text/css">
        * {
            margin: 0px;
            padding: 0px;
        }
        
        body {
            width: 800px;
            margin: auto;
        }
        
        h1 {
            font-size: 48px;
            font-family: Verdana;
            color: #1ca8ff;
            font-weight: normal;
        }
        
        p {
            font-family: Verdana;
        }
    </style>
</head>
<body>
    <h1>404</h1>
    <p style="font-size: 24px;">Hittade inte filen, vill du ha en yoghurt istället?</p><br>
    <?php if(isset($didntFindDisfile)) : ?>
        <p>Hittade inte filen + classen <?=$didntFindDisfile?>! </p>
    <?php elseif(isset($function) AND isset($controller)) : ?>
        <p>Funktionen <?=$function?> finns inte i klassen <?=$controller?></p>
    <?php endif; ?>
</body>
</html>