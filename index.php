<?php

// 328/pdo/index.php

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<h1>PDO Test</h1>";


require ('/home2/tostrand/pdo-config.php');
try {
    //Instantiate a PDO object
    $dbh = new PDO(DB_DRIVER, USERNAME, PASSWORD);
    //echo 'Successful!';
}
catch (PDOException $e) {
    echo $e->getMessage();
}

/* STEPS FOR USING PDO PREPARED STATEMENTS
1. Define the query
2. Prepare the statement
3. Bind the parameters
4. Execute the query
5. Process the result (if there is one)
*/

//INSERT a row into the pet table
//1. Define the query
$sql = "INSERT INTO pets (name, type, color) VALUES (:name, :type, :color)";

//2. Prepare the statement
$statement = $dbh->prepare($sql);

//3. Bind the parameters
$name = "Mathilda";
$type = "elephant";
$color = "polka-dotted";
$statement->bindParam(':name', $name);
$statement->bindParam(':type', $type);
$statement->bindParam(':color', $color);

//4. Execute the query
$statement-> execute();

//5. Process the result (if there is one)
$id = $dbh->lastInsertId();
echo "<p>Pet $id was inserted successfully</p>";

//UPDATE
//1. Define the query
$sql = "UPDATE pets SET name = :newName WHERE name = :oldName";

//2. Prepare the statement
$statement = $dbh->prepare($sql);

//3. Bind the parameters
$newName = "Freddy";
$oldName = "Mathilda";
$statement->bindParam(':oldName', $oldName);
$statement->bindParam(':newName', $newName);

//4. Execute the query
$statement-> execute();

//5. Process the result (if there is one)
echo "<p>Pet was updated successfully</p>";

//DELETE query
//1. Define the query (safest deletions use ID)
$sql = "DELETE FROM pets WHERE id = :id";

//2. Prepare the statement
$statement = $dbh->prepare($sql);

//3. Bind the parameters
$id = 9;
$statement->bindParam(':id', $id);

//4. Execute the query
$statement-> execute();

//5. Process the result (if there is one)
echo "<p>Pet $id was deleted</p>";

//SELECT query - single row
//1. Define the query
$sql = "SELECT * FROM pets WHERE id = :id";

//2. Prepare the statement
$statement = $dbh->prepare($sql);

//3. Bind the parameters
$id = 4;
$statement->bindParam(':id', $id);

//4. Execute the query
$statement-> execute();

//5. Process the result (if there is one)
$row = $statement->fetch(PDO::FETCH_ASSOC);
echo $row['color'] . ", " . $row['name'] . ", " . $row['type'];

//SELECT query - multiple rows
//1. Define the query
$sql = "SELECT * FROM pets";

//2. Prepare the statement
$statement = $dbh->prepare($sql);

//3. Bind the parameters

//4. Execute the query
$statement->execute();

//5. Process the result (if there is one)
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    echo "<p>" . $row['color'] . ", " . $row['name'] . ", " . $row['type'] . "</p>";
    echo "<p>{$row['color']}, {$row['name']}, {$row['type']}</p>";


    $color = $row['color'];
    $name = $row['name'];
    $type = $row['type'];

    echo "<p>$color, $name, $type</p>";
}