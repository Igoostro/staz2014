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
        
        //Zbieranie danych z tabeli country
        $query1 = "SELECT continent, name, population, code FROM country ORDER BY continent ASC, name ASC";
        $result1 = pg_query($connect, $query1);
        
        if(!$result1)
            echo "Błąd\n";
        ?>
        <table>
            <tr><td>Continent</td><td>Country</td><td>Language</td><td>Population</td><td>Official Language Use %</td><td>Official Language Population Use</td><td>&nbsp;</td></tr>
        <?php
        while ($row = pg_fetch_row($result1)) {
            echo "<tr><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td></tr>";
            echo "<br />\n";
        }
        
        pg_free_result($result);
        pg_close($connect);

        ?>
        </table>
    </body>
</html>