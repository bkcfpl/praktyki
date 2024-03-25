<?php
    $connection = mysqli_connect("localhost", "root", "", "video");
    $r = mysqli_query($connection, "SELECT CONCAT(customers.first_name, ' ', customers.last_name) as customers_name, email_address, title AS movie_title, rent_date FROM `customers` INNER JOIN rents ON customers.id = rents.customer_id INNER JOIN movies ON rents.movie_id = movies.id WHERE customers.id = 2 ORDER BY `rents`.`rent_date`;");
?>

<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <title>Wypożyczone</title>
    </head>
    <body>
        <!-- potencjalnie, może żeby można było wpisać imię osoby -->

        <!-- CONCAT(c.first_name, ' ', c_last_name) as customers_name -->

        <table>
            <tr>
                <th>imię i nazwisko klienta</th>
                <th>nazwa filmu</th>
                <th>data wypożyczenia</th>
            </tr>
            <?php
                while($row = mysqli_fetch_array($r)){
                    echo "<tr>";
                        echo "<td>" . $row['customers_name'] . "</td>";
                        echo "<td>" . $row['movie_title'] . "</td>";
                        echo "<td>" . $row['rent_date'] . "</td>";
                    echo "</tr>";
                }
            ?>
        </table>
    </body>
</html>