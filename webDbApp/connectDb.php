<?php
// Connecting, selecting database
$mysql_host = "localhost";
$mysql_user = "root";
$mysql_password = "";
$my_database="online_bookstore";

$link = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $my_database)
    or die("Could not connect:") ;
//echo 'Connected successfully';
//mysql_select_db($my_database) or die('Could not select database');

// Performing SQL query
$query = 'SELECT * FROM book';
$result = $link->query($query) or die('Query failed: ' . mysql_error());

// Printing results in HTML
echo "<table>\n";
while ($line = $result->fetch_array(MYSQLI_ASSOC)) {
    echo "\t<tr>\n";
    foreach ($line as $col_value) {
        echo "\t\t<td>$col_value</td>\n";
    }
    echo "\t</tr>\n";
}
echo "</table>\n";

// Free resultset
mysqli_free_result($result);

// Closing connection
mysqli_close($link);
?>