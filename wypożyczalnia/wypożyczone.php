<?php
    $connection = mysqli_connect("localhost", "root", "", "video");
    $r = mysqli_query($connection, "SELECT CONCAT(customers.first_name, ' ', customers.last_name) as customers_name FROM `customers`");
?>

<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <title>Wypożyczone</title>
    </head>
    <body>
        <form action="wypożyczone.php" method = 'post'>
            <input type="text" list = 'customers' autocomplete = "off" name = 'customer'>
            <datalist id = "customers">
                <?php
                    while($row = mysqli_fetch_array($r)){
                        echo "<option value='" . $row['customers_name'] . "'>";
                    }
                ?>
            </datalist>
            <button type = "submit" name = 'confirm'>Potwierdź</button>
        </form>

        <table>
            <?php
                if(isset($_POST['confirm'])){
                    echo "<tr>";
                        echo "<th>imię i nazwisko klienta</th>";
                        echo "<th>nazwa filmu</th>";
                        echo "<th>data wypożyczenia</th>";
                    echo "</tr>";

                    $r = mysqli_query($connection, "SELECT CONCAT(customers.first_name, ' ', customers.last_name) as customers_name, email_address, title AS movie_title, rent_date FROM `customers` INNER JOIN rents ON customers.id = rents.customer_id INNER JOIN movies ON rents.movie_id = movies.id WHERE CONCAT(customers.first_name, ' ', customers.last_name) = '" . $_POST['customer'] . "' ORDER BY `rents`.`rent_date`;");
                    $i = 0;

                    while($row = mysqli_fetch_array($r)){
                        echo "<tr>";
                            echo "<td>" . $row['customers_name'] . "</td>";
                            echo "<td>" . $row['movie_title'] . "</td>";
                            echo "<td>" . $row['rent_date'] . "</td>";
                        echo "</tr>";
                        $i++;
                    }

                    if($i == 1){
                        echo "<h2>Znaleziono " . $i . " zarejestrowane wypożyczenie przez " . $_POST['customer'] . "</h2>";
                    }
                    else if($i > 1 && $i < 5){
                        echo "<h2>Znaleziono " . $i . " zarejestrowane wypożyczenia przez " . $_POST['customer'] . "</h2>";
                    }
                    else{
                        echo "<h2>Znaleziono " . $i . " zarejestrowanych wypożyczeń przez " . $_POST['customer'] . "</h2>";
                    }
                }
                else{
                    echo "<h2>Wpisz imię i nazwisko klienta, aby wyświetlić filmy przez niego wypożyczone</h2>";
                }
            ?>
        </table>

        <button><a href="gatunek.php" style = 'text-decoration: none; color: black;'>filmy z wybranego gatunku</a></button><br/>
        <button><a href="reżyser.php" style = 'text-decoration: none; color: black;'>Filmy wybranego reżysera</a></button><br/>
        <button><a href="wszystko.php" style = 'text-decoration: none; color: black;'>Osoby które wypożyczyły filmy z wybranym gatunkiem</a></button><br/>
    </body>
</html>