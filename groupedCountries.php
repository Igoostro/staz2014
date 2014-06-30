<html>
<head>
    <meta charset="utf-8" />
    <meta author="Igor Ostrowski" />
    <link rel="Stylesheet" type="text/css" href="style.css" />
    
    <title>Countries and languages</title>
</head>
    <body>
        <div id="top">
            <h1>Global Language use</h1>
        </div>
        <?php
        //Dodanie linków
        include 'links.php';
        //Dodanie danych logowania z baza danych
        include 'sqllogin.php';
        ?>
        
        <table id='thin'>
            <thead>
                <tr><th>Language</th><th>Population Use</th><th>Global Population % Use</th></tr>
            </thead>
            <tbody>
        
                <?php
                $col1 = array();
                $col2 = array();
                $col3 = array();
                $connect = pg_connect("host=$host dbname=$db user=$user password=$pass") or die ("Blad polaczenia z baza\n");
         
                //Zebranie danych o całości populacji z tabeli country
                $totalPop = 0; //Całkowita populacja
                $query0 = "SELECT population FROM country";
                $result0 = pg_query($connect, $query0) or die("Nie mozna wykonac zapytania: $query0\n");
                while ($row0 = pg_fetch_row($result0)){
                    $totalPop += $row0[0];
                }
        
                //Zbieranie danych z tabeli countryLanguage
                $query1 = "SELECT language, countrycode, percentage FROM countryLanguage ORDER BY language ASC";
                $result1 = pg_query($connect, $query1) or die("Nie mozna wykonac zapytania: $query1\n");
        
                //Jezyki sa posortowane, a wiec mozna tylko sprawdzic poprzedni pobrany jezyk, aby pozbyc sie powielania
                $lastLang = '';
                $totalLangPop = 0; //Całkowita populacja osob uzywajacych danego jezyka
                while ($row1 = pg_fetch_row($result1)){
                    //Poczatkowe przypisanie
                    if($lastLang == ''){
                        $lastLang = $row1[0];
                    }
                    //Jesli jezyk juz wystapil:
                    if($row1[0] != $lastLang){
                        $totalLangPopRound = floor($totalLangPop);
                        $GloPopPerUse = round($totalLangPop / $totalPop * 100, 2);
                        //echo "<tr><td>$lastLang</td><td class='numbers'>$totalLangPopRound</td><td class='numbers'>$GloPopPerUse</td></tr>";
                        array_push($col1, $lastLang);
                        array_push($col2, $totalLangPopRound);
                        array_push($col3, $GloPopPerUse);
                 
                        $totalLangPop = 0;
                    }
                    //Zbieranie populacji danego kraju z tabeli country
                    $query2 = "SELECT population FROM country WHERE code='$row1[1]'";
                    $result2 = pg_query($connect, $query2) or die("Nie mozna wykonac zapytania: $query2\n");
                    while ($row2 = pg_fetch_row($result2)){
                        $totalLangPop += ($row2[0] * $row1[2]) / 100;//Populacja kraju * procentowy udzial jezyka / 100
                    }
                        
                    $lastLang = $row1[0];//Nowy -> Stary jezyk
                }
                //Wyswietlenie ostatniego pobranego jezyka:
                $totalLangPopRound = floor($totalLangPop);
                $GloPopPerUse = round($totalLangPop / $totalPop * 100, 2);
                //echo "<tr><td>$lastLang</td><td class='numbers'>$totalLangPopRound</td><td class='numbers'>$GloPopPerUse</td></tr>";
                array_push($col1, $lastLang);
                array_push($col2, $totalLangPopRound);
                array_push($col3, $GloPopPerUse);
                
                pg_free_result($result0);
                pg_free_result($result1);
                pg_free_result($result2);
                pg_close($connect);
                
                //Ostateczne sortowanie i wyswietlenie
                array_multisort($col1, $col2, $col3);
                while(sizeof($col1)!=0){
                    echo '<tr><td>'.array_pop($col1).'</td><td class="numbers">'.array_pop($col2).'</td><td class="numbers">'.array_pop($col3).'</td></tr>';
                }
                //Suma 95,38 przez zaokraglenia
                ?>
        
            </tbody>
        </table>
    </body>
</html>