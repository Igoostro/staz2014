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
            <thead>
                <tr><th>Continent</th><th>Country</th><th>Language</th><th>Population</th><th>Official Language Use %</th><th>Official Language Population Use</th><th style="border: none">&nbsp;</th></tr>
            </thead>
            <tbody>
            
                <?php
                while ($row1 = pg_fetch_row($result1)){
                    //Zbieranie danych z tabeli countryLanguage
                    $query2 = "SELECT language, percentage FROM countryLanguage WHERE countrycode='$row1[3]' AND isofficial=true ORDER BY percentage DESC";
                    $result2 = pg_query($connect, $query2) or die("Nie mozna wykonac zapytania: $query2\n");
            
                    while ($row2 = pg_fetch_row($result2)){
                        $offLanUsePer = round($row2[1], 2);
                        $offLanPopUse = floor($row1[2]*$row2[1]/100);
                        echo "<tr><td>$row1[0]</td><td>$row1[1]</td><td>$row2[0]</td><td class='numbers'>$row1[2]</td><td class='numbers'>$offLanUsePer</td><td class='numbers'>$offLanPopUse</td><td id='details'>Details</td></tr>";
                    }
                }
        
                pg_free_result($result1);
                pg_free_result($result2);
                pg_close($connect);
                ?>
            </tbody>
        </table>
    </body>
</html>