<html>
<head>
    <meta charset="utf-8" />
    <meta author="Igor Ostrowski" />
    <link rel="Stylesheet" type="text/css" href="style.css" />
    
    <title>Countries and languages</title>
</head>
    <body>
        <div id="top">
            <h1>Official languages of countries</h1>
        </div>
        <?php
        //Dodanie linkow
        include 'links.php';
        //Dodanie danych logowania z baza danych
        include 'sqllogin.php';
        
        $connect = pg_connect("host=$host dbname=$db user=$user password=$pass") or die ("Blad polaczenia z baza\n"); 
        $query = "SELECT * FROM country";
        $result = pg_query($connect, $query);
        
        if(!$result)
            echo "Błąd\n";
        while ($row = pg_fetch_row($result)) {
            echo "Test1: $row[0]  Test2: $row[1]";
            echo "<br />\n";
        }
        
        pg_free_result($result);
        pg_close($connect);

        ?>
    </body>
</html>