<?php
    $connection = mysqli_connect("localhost", "root", "", "video");
    $r = mysqli_query($connection, "SELECT `name` FROM `genres`");
?>

<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <title>Gatunek</title>
    </head>
    <body>
        <form action="gatunek.php" method = 'post'>
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
                    echo "<th>id</th>";
                    echo "<th>tytuł</th>";
                    echo "<th>opis</th>";
                    echo "<th>gatunek</th>";
                echo "</tr>";

                $r = mysqli_query($connection, "SELECT movies.id, movies.title, movies.description, genres.name AS genre FROM `movies` INNER JOIN genres ON movies.genre_id = genres.id WHERE genres.name = '" . $_POST['genre'] . "';");
                $i = 0;

                while($row = mysqli_fetch_array($r)){
                    echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['title'] . "</td>";
                        echo "<td>" . $row['description'] . "</td>";
                        echo "<td>" . $row['genre'] . "</td>";
                    echo "</tr>";
                    $i++;
                }

                if($i == 1){
                    echo "<h2>Znaleziono " . $i . " zarejestrowany film z gatunku " . $_POST['genre'] . "</h2>";
                }
                else if($i > 1 && $i < 5){
                    echo "<h2>Znaleziono " . $i . " zarejestrowane filmy z gatunku " . $_POST['genre'] . "</h2>";
                }
                else{
                    echo "<h2>Znaleziono " . $i . " zarejestrowanych filmów z gatunku " . $_POST['genre'] . "</h2>";
                }
            }
            else{
                echo "<h2>Wpisz gatunek filmu, aby wyświetlić filmy z tego gatunku</h2>";
            }
            ?>
        </table>

        <button><a href="reżyser.php" style = 'text-decoration: none; color: black;'>Filmy wybranego reżysera</a></button><br/>
        <button><a href="wszystko.php" style = 'text-decoration: none; color: black;'>Osoby które wypożyczyły filmy z wybranym gatunkiem</a></button><br/>
        <button><a href="wypożyczone.php" style = 'text-decoration: none; color: black;'>filmy wypożyczone przez wybranego klienta</a></button><br/>
    </body>
</html>