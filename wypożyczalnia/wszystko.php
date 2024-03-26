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
    <form action="wszystko.php" method = 'post'>
        <input type="text" list = 'genres' autocomplete = "off" name = 'genre'>
        <datalist id = "genres">
            <?php
                while($row = mysqli_fetch_array($r)){
                    echo "<option value='" . $row['name'] . "'>";
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
                    echo "<th>adress email</th>";
                    echo "<th>nazwa filmu</th>";
                    echo "<th>data wypożyczenia</th>";
                echo "</tr>";

                $r = mysqli_query($connection, "SELECT CONCAT(customers.first_name, ' ', customers.last_name) as customers_name, customers.email_address, movies.title AS movie_title, rents.rent_date FROM customers INNER JOIN rents ON customers.id = rents.customer_id INNER JOIN movies ON rents.movie_id = movies.id INNER JOIN genres ON movies.genre_id = genres.id WHERE genres.name = '" . $_POST['genre'] . "';");
                $i = 0;

                while($row = mysqli_fetch_array($r)){
                    echo "<tr>";
                        echo "<td>" . $row["customers_name"] . "</td>";
                        echo "<td>" . $row['email_address'] . "</td>";
                        echo "<td>" . $row['movie_title'] . "</td>";
                        echo "<td>" . $row['rent_date'] . "</td>";
                    echo "</tr>";
                    $i++;
                }

                if($i == 1){
                    echo "<h2>Znaleziono " . $i . " zarejestrowane wypożyczenie filmów z gatunku " . $_POST['genre'] . "</h2>";
                }
                else if($i > 1 && $i < 5){
                    echo "<h2>Znaleziono " . $i . " zarejestrowane wypożyczenia filmów z gatunku " . $_POST['genre'] . "</h2>";
                }
                else{
                    echo "<h2>Znaleziono " . $i . " zarejestrowanych wypożyczeń filmów z gatunku " . $_POST['genre'] . "</h2>";
                }
            }
            else{
                echo "<h2>Wpisz gatunek filmu, aby wyświetlić kto wynajął film z takiego gatunku</h2>";
            }
        ?>
    </table>

    <button><a href="wypożyczone.php" style = 'text-decoration: none; color: black;'>filmy wypożyczone przez wybranego klienta</a></button><br/>
    <button><a href="gatunek.php" style = 'text-decoration: none; color: black;'>filmy z wybranego gatunku</a></button><br/>
    <button><a href="reżyser.php" style = 'text-decoration: none; color: black;'>Filmy wybranego reżysera</a></button><br/>
</body>
</html>