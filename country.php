<?php
$cd = htmlentities($_GET['code']);
?>
<html>
<head>
    <meta charset="utf-8" />
    <meta author="Igor Ostrowski" />
    <base href="<?='http://'.$_SERVER['HTTP_HOST']?>"/>
    <link rel="Stylesheet" type="text/css" href="style.css"/>
    <script type="text/javascript" src="http://mbostock.github.com/d3/d3.js?2.1.3"></script>
    <script type="text/javascript" src="http://mbostock.github.com/d3/d3.geom.js?2.1.3"></script>
    <script type="text/javascript" src="http://mbostock.github.com/d3/d3.layout.js?2.1.3"></script>
    
    <title>Countries and languages</title>
</head>
    <body>
        <div id="top">
            <h1>Language use in <?php echo $cd;?></h1>
        </div>
        <?php
        //Dodanie linków
        include 'links.php';
        //Dodanie danych logowania z baza danych
        include 'sqllogin.php';
        
        $language = array();
        $percentage = array();
        
        $connect = pg_connect("host=$host dbname=$db user=$user password=$pass") or die ("Blad polaczenia z baza\n");
        
        //Zebranie danych o jezykach uzywanych w wtbranym kraju, z tablicy countryLanguage
        $query1 = "SELECT language, percentage FROM countryLanguage WHERE countrycode='$cd'";
        $result1 = pg_query($connect, $query1) or die("Nie mozna wykonac zapytania: $query1\n");
        while ($row1 = pg_fetch_row($result1)){
            array_push($language, $row1[0]);
            array_push($percentage, $row1[1]);
        }
        pg_free_result($result1);
        pg_close($connect);
                
        ?>
        <br/><br/><br/><br/>
        <script type="text/javascript">
            
        var w = 300, h = 300, r = 180, color = d3.scale.category20c();
        
            data = [
            <?php
            $i=0;
            while(sizeof($language)!=0){
                echo '{"label":"'.array_pop($language).'", "value":'.array_pop($percentage).'},';
            }
            ?>
            ];
            
        var vis = d3.select("body")
        .append("svg:svg")
        .data([data])
        .attr("width", w)
        .attr("height", h)
        .append("svg:g")
        .attr("transform", "translate(" + r + "," + r + ")")
 
        var arc = d3.svg.arc()
            .outerRadius(r);
 
        var pie = d3.layout.pie()
            .value(function(d) { return d.value; });
 
        var arcs = vis.selectAll("g.slice")
            .data(pie)
            .enter()
            .append("svg:g")
            .attr("class", "slice");
 
        arcs.append("svg:path")
            .attr("fill", function(d, i) { return color(i); } )
            .attr("d", arc);
 
        arcs.append("svg:text")
            .attr("transform", function(d) {
                d.innerRadius = 0;
                d.outerRadius = r;
                return "translate(" + arc.centroid(d) + ")";
            })
            .attr("text-anchor", "middle")
            .text(function(d, i) { return data[i].label; });
        
</script>
        
        
    </body>
</html>