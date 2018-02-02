<!DOCTYPE html>
<html>
	<head>
		<style>
ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: #333333;
}

li {
    float: left;
}

li a {
    display: block;
    color: white;
    text-align: center;
    padding: 16px;
    text-decoration: none;
}

li a:hover {
    background-color: #111111;
}
</style>
		<title> Database 1 Project</title>
	</head>
	<body>

<ul>
  <li><a href="db1Proj.php">Home</a></li>
  <li><a href="db1Proj.php?nav=pjQuery">ProjectQuerySolution</a></li>
  <li><a href="db1Proj.php?nav=book">Book</a></li>
  <li><a href="db1Proj.php?nav=employee">Employee</a></li>
  <li><a href="db1Proj.php?nav=customer">Customer</a></li>
  <li><a href="db1Proj.php?nav=order">Order</a></li>
  <li><a href="db1Proj.php?nav=orderD">Order_Details</a></li>
  <li><a href="db1Proj.php?nav=shipper">Shipper</a></li>
   <li><a href="db1Proj.php?nav=subject">Subject</a></li>
    <li><a href="db1Proj.php?nav=supplier">Supplier</a></li>
</ul>



<?php

define("MYSQL_CONN_ERROR", "Wrong Query."); 
// importing config file  that contains local variables.
require_once(dirname(__FILE__) . "/dbConfig.php");
$completed = '';
class bookstore{

function showAllTables($variables, $query){

	$qcheck = isAccecptable($query);
	

	if( $qcheck != "" )
	{
		//echo "checking";
		echo $qcheck;

	}
	else
	{

		// Connecting, selecting database
		$link = mysqli_connect($variables["mysql_host"], $variables["mysql_user"], $variables["mysql_password"], $variables["my_database"])
		    or die("Could not connect:") ;
		//echo "Connected successfully<br>";

		// Performing SQL query


		mysqli_report(MYSQLI_REPORT_STRICT); 

		try {

		  $result = $link->query($query) or die('Query failed: ' . mysqli_error());
		  
		$bookShelf = array();

		while($book=mysqli_fetch_assoc($result)){
			$bookShelf[] = $book;

		}

		}

		//catch exception
		catch(Exception $e) {
		    echo $e->errorMessage(); 
		}

		$completed = 'complete';

		// Closing connection
		mysqli_close($link);
		//echo "Closed the Connection successfully<br>";
		return $bookShelf;
	}

}

}


$queries = array(
	"SELECT BookID,Author,Title FROM book",
	"SELECT Title FROM book WHERE Quantity > 10",
	"SELECT Title FROM book, supplier WHERE book.SupplierId = supplier.SupplierId AND CompanyName = 'supplier2'",
	"SELECT CategoryName FROM subject,supplier,book WHERE subject.SubjectID = book.SubjectID AND book.SupplierId = supplier.SupplierId AND CompanyName = 'supplier2'",
	"SELECT Title, UnitPrice FROM book WHERE UnitPrice = (SELECT MAX(UnitPrice) as MostExpensiveBook FROM book, supplier WHERE book.SupplierId = supplier.SupplierId AND CompanyName = 'supplier3')",
	"SELECT DISTINCT b.Title FROM book b, order_details o, orders o2, customer c  WHERE b.BookID = o.BookID AND o.OrderID = o2.OrderID AND o2.CustomerID = c.CustomerID AND c.LastName='lastname1' AND c.FirstName = 'firstname1' ",
	"SELECT SUM(b.UnitPrice * o.Quantity) FROM book b, order_details o, orders o2, customer c  WHERE b.BookID = o.BookID AND o.OrderID = o2.OrderID AND o2.CustomerID = c.CustomerID AND c.LastName='lastname1' AND c.FirstName = 'firstname1' ",
	"SELECT c.FirstName, c.LastName , SUM(b.UnitPrice) FROM book b, order_details o, orders o2, customer c  WHERE b.BookID = o.BookID AND o.OrderID = o2.OrderID AND o2.CustomerID = c.CustomerID  GROUP BY c.CustomerID HAVING SUM(b.UnitPrice) < '80'",
	"SELECT c.FirstName, c.LastName , SUM(b.UnitPrice * o.Quantity) FROM book b, order_details o, orders o2, customer c  WHERE b.BookID = o.BookID AND o.OrderID = o2.OrderID AND o2.CustomerID = c.CustomerID  GROUP BY c.CustomerID  ORDER BY SUM(b.UnitPrice) DESC ",
	"SELECT b.Title, s.ShipperName FROM book b, order_details o, orders o2, shipper s WHERE b.BookID = o.BookID AND o.OrderID = o2.OrderID AND o2.ShipperID = s.ShipperID AND o2.ShippedDate = '2014-08-04'",
	"SELECT b.Title FROM book b, employee e, order_details o, orders o2 WHERE b.BookID = o.BookID AND o.OrderID = o2.OrderID AND o2.EmployeeID = e.EmployeeID AND e.FirstName = 'firstname6' AND e.LastName = 'lastname6'",
	"SELECT DISTINCT b.Title FROM book b, order_details o, orders o2, customer c  WHERE b.BookID = o.BookID AND o.OrderID = o2.OrderID AND o2.CustomerID = c.CustomerID AND c.LastName='lastname1' AND c.FirstName = 'firstname1'UNION SELECT DISTINCT b1.Title FROM book b1, order_details o1, orders o21, customer c1  WHERE b1.BookID = o1.BookID AND o1.OrderID = o21.OrderID AND o21.CustomerID = c1.CustomerID AND c1.LastName='lastname4' AND c1.FirstName = 'firstname4'",
	"SELECT b.Title, SUM(o.Quantity) FROM book b, order_details o WHERE b.BookID = o.BookID GROUP By b.BookID ORDER BY SUM(o.Quantity) ASC ",
	" SELECT c.FirstName, c.LastName FROM customer c, orders o2, order_details o WHERE o2.OrderID = o.OrderID AND o2.CustomerID = c.CustomerID GROUP BY o2.CustomerID HAVING COUNT( DISTINCT o.BookID) > 3 ",
	"SELECT DISTINCT c.FirstName, c.LastName, o2.CustomerID FROM book b, order_details o, orders o2, customer c  WHERE b.BookID = o.BookID AND o.OrderID = o2.OrderID AND o2.CustomerID = c.CustomerID AND b.Author = 'author1' ",
	"SELECT DISTINCT c.FirstName, c.LastName, o2.CustomerID, b.Title FROM book b, order_details o, orders o2, customer c, subject s WHERE b.BookID = o.BookID AND o.OrderID = o2.OrderID AND o2.CustomerID = c.CustomerID AND s.SubjectID = b.SubjectID AND s.CategoryName = 'category4' UNION SELECT DISTINCT c.FirstName, c.LastName, o2.CustomerID, b.Title FROM book b, order_details o, orders o2, customer c, subject s WHERE b.BookID = o.BookID AND o.OrderID = o2.OrderID AND o2.CustomerID = c.CustomerID AND s.SubjectID = b.SubjectID AND s.CategoryName = 'category3'",
	"SELECT MIN(b.UnitPrice), s.CategoryName FROM book b, subject s WHERE b.SubjectID = s.SubjectID GROUP BY s.CategoryName",
	"SELECT o2.EmployeeID, SUM(b.UnitPrice * o.Quantity) FROM book b, employee e, order_details o, orders o2 WHERE b.BookID = o.BookID AND o.OrderID = o2.OrderID AND o2.EmployeeID = e.EmployeeID GROUP BY o2.EmployeeID",
	"SELECT b.Title, o.Quantity FROM book b, order_details o, orders o2 WHERE b.BookID = o.BookID AND o.OrderID = o2.OrderID AND o2.ShippedDate > '2014-08-04' ",
	"SELECT DISTINCT c.CustomerID, sum(o.Quantity) FROM book b, order_details o, orders o2, customer c  WHERE b.BookID = o.BookID AND o.OrderID = o2.OrderID AND o2.CustomerID = c.CustomerID GROUP BY o.OrderID HAVING COUNT(DISTINCT o.BookID) > 1 ORDER BY o.Quantity DESC ",
	"SELECT DISTINCT c.CustomerID, c.Phone FROM book b, order_details o, orders o2, customer c  WHERE b.BookID = o.BookID AND o.OrderID = o2.OrderID AND o2.CustomerID = c.CustomerID GROUP BY c.CustomerID HAVING COUNT(DISTINCT o.BookID) > 3",
	
	);

$queries02= array('SELECT * FROM book',
	'SELECT * FROM employee',
	'SELECT * FROM customer',
	'SELECT * FROM orders',
	'SELECT * FROM order_details',
	'SELECT * FROM shipper',
	'SELECT * FROM subject',
	'SELECT * FROM supplier',

	);
/*$queryField = $_POST["queryInput"];

$connn = new bookstore();

 if(isset($queryField))
    {       
        
		$result = $connn->showAllTables($variables, $queryField);
		printStuffs($result);
    }*/


/*foreach ($queries02 as $query) {
	$result = $connn->showAllTables($variables, $query);
	//dump($result);
	printStuffs($result);
	//array_walk_recursive($result, 'test_print');
	
}
*/	//$result = $connn->showAllTables($variables, $query);
//	array_walk_recursive($result, 'test_print');


if(isset($_GET["nav"]))
{
	if($_GET["nav"] === "book")
	{
		$bookq = $queries02[0];
		$connn = new bookstore();
		$result = $connn->showAllTables($variables, $bookq);
		printStuffs($result);
	}
	elseif($_GET["nav"] === "employee")
	{
		$bookq = $queries02[1];
		$connn = new bookstore();
		$result = $connn->showAllTables($variables, $bookq);
		printStuffs($result);
	}
	elseif($_GET["nav"] === "customer")
	{
		$bookq = $queries02[2];
		$connn = new bookstore();
		$result = $connn->showAllTables($variables, $bookq);
		printStuffs($result);
	}
	elseif($_GET["nav"] === "order")
	{
		$bookq = $queries02[3];
		$connn = new bookstore();
		$result = $connn->showAllTables($variables, $bookq);
		printStuffs($result);
	}
	elseif($_GET["nav"] === "orderD")
	{
		$bookq = $queries02[4];
		$connn = new bookstore();
		$result = $connn->showAllTables($variables, $bookq);
		printStuffs($result);
	}
	elseif($_GET["nav"] === "shipper")
	{
		$bookq = $queries02[5];
		$connn = new bookstore();
		$result = $connn->showAllTables($variables, $bookq);
		printStuffs($result);
	}
	elseif($_GET["nav"] === "subject")
	{
		$bookq = $queries02[6];
		$connn = new bookstore();
		$result = $connn->showAllTables($variables, $bookq);
		printStuffs($result);
	}
	elseif($_GET["nav"] === "supplier")
	{
		$bookq = $queries02[7];
		$connn = new bookstore();
		$result = $connn->showAllTables($variables, $bookq);
		printStuffs($result);
	}
	elseif($_GET["nav"] === "pjQuery")
	{
		$connn = new bookstore();
		foreach ($queries as $query) {
	$result = $connn->showAllTables($variables, $query);
	printStuffs($result);
	echo"<br>";
	
	}
		
	}
}
else
{
?>  
<table>
<tr>
	<td>
<form  method="post" name="queryForm" action = "">
  <p style = ""><em>Enter SQL Query:</em></p>
  <p><textarea name="queryInput" rows="10" cols="30"></textarea>

 
     </p>
  <input type="submit" value="Submit">
</form>
</td>
<td>
	<?php





 if(isset( $_POST["queryInput"]))
    {   $queryField =  $_POST["queryInput"];
		$qcheck = isAccecptable($queryField);
	

		if( $qcheck != "" )
		{
			//echo "checking";
			echo "<br>$qcheck";

		}
		else
		{
			$connn = new bookstore();
			$result = $connn->showAllTables($variables, $queryField);
			printStuffs($result);
		}        
    }

    ?>
</td>
</tr>
</table>
<?php
}
?>
</body>
</html>
