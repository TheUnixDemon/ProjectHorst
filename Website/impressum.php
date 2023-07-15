<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Impressum</title>

    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/nav.css">
    <link rel="stylesheet" type="text/css" href="css/footer.css">
</head>
<body>
    <?php
    session_start();

    include_once("classes/DBconnection.php");
    include_once("classes/htmlHandler.php");
    include_once("classes/profile.php");
    ?>

    <?php
    $htmlHandler = new htmlHandler;
    $htmlHandler->nav();
    ?>

    <!--wird hier geladen, da diese Konvertierte Variante Probleme aufweist beim Laden über "include_once"-->
    <div style="position:absolute;top:1.33in;left:1.29in;width:1.84in;line-height:0.43in;"><span style="font-style:normal;font-weight:bold;font-size:20pt;font-family:Liberation Sans;color:#000000">Impressum</span><span style="font-style:normal;font-weight:bold;font-size:20pt;font-family:Liberation Sans;color:#000000"></span><br/></SPAN></div>
    <img style="position:absolute;top:1.34in;left:1.28in;width:1.63in;height:0.02in" src="ci_1.png" />
    <div style="position:absolute;top:1.65in;left:1.29in;width:2.29in;line-height:0.22in;"><span style="font-style:normal;font-weight:normal;font-size:12pt;font-family:Liberation Serif;color:#000000">BBS-ME Otto-Brenner-Schule</span><span style="font-style:normal;font-weight:normal;font-size:12pt;font-family:Liberation Serif;color:#000000"> </span><br/><span style="font-style:normal;font-weight:normal;font-size:12pt;font-family:Liberation Serif;color:#000000">Lavesalle 14 30169 Hannover</span><span style="font-style:normal;font-weight:normal;font-size:12pt;font-family:Liberation Serif;color:#000000"> </span><br/></SPAN></div>
    <div style="position:absolute;top:2.25in;left:1.29in;width:1.87in;line-height:0.30in;"><span style="font-style:normal;font-weight:bold;font-size:14pt;font-family:Liberation Sans;color:#000000">Ansprechpartner</span><span style="font-style:normal;font-weight:bold;font-size:14pt;font-family:Liberation Sans;color:#000000"></span><br/></SPAN></div>
    <div style="position:absolute;top:2.55in;left:1.29in;width:2.60in;line-height:0.22in;"><span style="font-style:normal;font-weight:normal;font-size:12pt;font-family:Liberation Serif;color:#000000">Max Leon Haller</span><span style="font-style:normal;font-weight:normal;font-size:12pt;font-family:Liberation Serif;color:#000000"> </span><br/></SPAN><span style="font-style:normal;font-weight:normal;font-size:12pt;font-family:Liberation Serif;color:#000000">Email: </span><a href="mailto:maxleonhaller@bbs-me.org"><span style="font-style:normal;font-weight:normal;font-size:12pt;font-family:Liberation Serif;color:#000080">maxleonhaller@bbs-me.org</span></a>
    <span style="font-style:normal;font-weight:normal;font-size:12pt;font-family:Liberation Serif;color:#000080"> </span><br/></SPAN></div>
    <a href="mailto:maxleonhaller@bbs-me.org"><img style="position:absolute;top:2.78in;left:1.82in;width:2.04in;height:0.01in" src="ci_2.png" />
    </a><div style="position:absolute;top:2.97in;left:1.29in;width:1.83in;line-height:0.23in;"><span style="font-style:normal;font-weight:normal;font-size:12pt;font-family:Liberation Serif;color:#000000">Telefon: 01522 6658137</span><span style="font-style:normal;font-weight:normal;font-size:12pt;font-family:Liberation Serif;color:#000000"> </span><br/></SPAN></div>
    <div style="position:absolute;top:1.04in;left:1.29in;"><a name="Impressum"><span style="font-style:normal;font-weight:normal;font-size:5pt;font-family:Times New Roman;color:#000000">&nbsp</span></a></div>
    <div style="position:absolute;top:2.05in;left:1.29in;"><a name="Ansprechpartner"><span style="font-style:normal;font-weight:normal;font-size:5pt;font-family:Times New Roman;color:#000000">&nbsp</span></a></div>
    
    <?php
    //$htmlHandler->footer(); HTML wird nicht von footer erkannt
    ?>
</body>
</html>