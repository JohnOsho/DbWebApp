<?php
// db connection array variables 
$variables = array(
	"mysql_host" => "localhost",
	"mysql_user" => "root",
	"mysql_password" => "",
	"my_database" => "online_bookstore"
	);

function dump($data) {
    if(is_array($data)) {
        print "<pre>__________________________\n";
        print_r($data);
        print "__________________________</pre>";
    } elseif (is_object($data)) {
        print "<pre>__________________________\n";
        var_dump($data);
        print "__________________________</pre>";
    } else {
        print "_________&gt; ";
       var_dump($data);
        print " &lt;_________";
    }
}

function isAccecptable($cheking){

	$issues = 0;
	$result = "";
	if(stripos($cheking, 'drop') !== false)
	{
		$result .= "You may not use the drop statement in this application.";
		$issues++;
	}
		
	if(stripos($cheking, 'update') !== false)
	{
		if($issues > 0)
			$result .= " ";
		$result .= "You may not use the update statement in this application.";
		$issues++;

	}
	if(empty(trim($cheking)))
	{
		
		$result .= "You may not Enter an Empty statement in this application.";

	}

	return $result;
}

fUNCTION printstuffs($result){
echo "<table style = width:auto; border-collapse: collapse;  table-layout: fixed; font: normal medium/1.4 sans-serif;>";
$headerPrinted = 0;

foreach ($result as $Item) {
	if(! $headerPrinted){
		echo "<tr>";
		$header = array_keys($Item);
		foreach ($header as $head) {
			echo "<th>$head</th>";


		}
		echo "</tr>";
		$headerPrinted = 1;

	}		
	echo "<tr>";
	foreach ($Item as $name => $value) {

	echo "<td style = padding: 0.25rem; text-align: left; border: 1px solid #ccc;>$value</td>";
		}
			echo "</tr>";
	}
	echo "</table>";
}

?>