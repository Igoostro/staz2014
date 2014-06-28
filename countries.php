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
        $result1 = pg_query($connect, $query1) or die("Nie mozna wykonac zapytania: $query1\n");
        ?>
        
        <table>
            <tr><td>Continent</td><td>Country</td><td>Language</td><td>Population</td><td>Official Language Use %</td><td>Official Language Population Use</td><td>&nbsp;</td></tr>
            
        <?php
        while ($row1 = pg_fetch_row($result1)){
            //Zbieranie danych z tabeli countryLanguage
            $query2 = "SELECT language, percentage FROM countryLanguage WHERE isofficial=true AND countrycode='$row1[3]' ORDER BY population DESC";
            $result2 = pg_query($connect, $query2) or die("Nie mozna wykonac zapytania: $query2\n");
            
            while ($row2 = pg_fetch_row($result2)){
                echo "<tr><td>$row1[0]</td><td>$row1[1]</td><td>$row2[0]</td><td>$row1[2]</td><td>$row2[1]</td><td>($row1[2]*$row2[1]/100)</td><td>Details</td></tr>";
                //TO DO zaokraglenia!! 
            }
        }
        
        pg_free_result($result1);
        pg_free_result($result2);
        pg_close($connect);

        ?>
        </table>
    </body>
</html>