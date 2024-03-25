<?php
    $connection = mysqli_connect("localhost", "root", "", "video");
    $r = mysqli_query($connection, "SELECT `name` FROM `genres`");
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>film po gatunku</title>
</head>
<body>

    <input type="text" list = 'a' autocomplete = "off">
    <table>
        <tr>
            <th>imię i nazwisko klienta</th>
            <th>adress email</th>
            <th>nazwa filmu</th>
            <th>data wypożyczenia</th>
        </tr>
        <?php
            $r = mysqli_query($connection, "SELECT CONCAT(customers.first_name, ' ', customers.last_name) as customers_name, customers.email_address, movies.title AS movie_title, rents.rent_date FROM customers INNER JOIN rents ON customers.id = rents.customer_id INNER JOIN movies ON rents.movie_id = movies.id INNER JOIN genres ON movies.genre_id = genres.id WHERE genres.id = 1;");

            while($row = mysqli_fetch_array($r)){
                echo "<tr>";
                    echo "<td>" . $row["customers_name"] . "</td>";
                    echo "<td>" . $row['email_address'] . "</td>";
                    echo "<td>" . $row['movie_title'] . "</td>";
                    echo "<td>" . $row['rent_date'] . "</td>";
                echo "</tr>";
            }
        ?>
    </table>
</body>
</html>