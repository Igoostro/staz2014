<html>
<head>
    <meta charset="utf-8" />
    <meta author="Igor Ostrowski" />
    <link rel="Stylesheet" type="text/css" href="style.css" />
    
    <title>Countries and languages</title>
</head>
    <body>
        <div id="top">
            <h1>Language use in :countryName</h1>
        </div>
        <?php
        //Dodanie linków
        include 'links.php';
        //Dodanie danych logowania z baza danych
        include 'sqllogin.php';
        

        echo $_GET['code'];
        ?>
        
        
        
    </body>
</html>