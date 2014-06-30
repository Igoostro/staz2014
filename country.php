<?php
var_dump($_SERVER);
echo '</br></br></br>';
var_dump($_GET);
?>
<html>
<head>
    <meta charset="utf-8" />
    <meta author="Igor Ostrowski" />
    <link rel="Stylesheet" type="text/css" href="style.css" />
    
    <title>Countries and languages</title>
</head>
    <body>
        <div id="top">
            <h1>Language use in <?php echo $_GET['code'];?></h1>
        </div>
        <?php
        $cd = $_GET['code'];
        //Dodanie linków
        include 'links.php';
        //Dodanie danych logowania z baza danych
        include 'sqllogin.php';
        
        $connect = pg_connect("host=$host dbname=$db user=$user password=$pass") or die ("Blad polaczenia z baza\n");
        
        //Zebranie danych o jezykach uzywanych w wtbranym kraju, z tablicy countryLanguage
        $query1 = "SELECT language, percentage FROM countryLanguage WHERE countrycode='$cd'";
        $result1 = pg_query($connect, $query1) or die("Nie mozna wykonac zapytania: $query1\n");
        while ($row1 = pg_fetch_row($result1)){
            echo "$row1[0] $row1[1] </br>";
        }
        
        pg_free_result($result1);
        pg_close($connect);
                
        ?>
        
        
        
    </body>
</html>