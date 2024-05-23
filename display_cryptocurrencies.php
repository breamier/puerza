<?php
// display_cryptocurrencies.php
include 'db_connect.php';

$sql = "SELECT Cryptocurrency, Price, Supply, Market_Cap, Type FROM crypto";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cryptocurrencies</title>
</head>
<body>
    <h2>All Cryptocurrencies</h2>
    <table border="1">
        <tr>
            <th>Cryptocurrency</th>
            <th>Price</th>
            <th>Supply</th>
            <th>Market Cap</th>
            <th>Type</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['Cryptocurrency']}</td>
                        <td>{$row['Price']}</td>
                        <td>{$row['Supply']}</td>
                        <td>{$row['Market_Cap']}</td>
                        <td>{$row['Type']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No cryptocurrencies found</td></tr>";
        }
        ?>
    </table>
</body>
</html>
