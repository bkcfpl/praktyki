<?php
    $connection = mysqli_connect("localhost", "root", "", "video");
    $r = mysqli_query($connection, "SELECT `name` FROM `directors`");
?>

<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <title>Reżyser</title>
    </head>
    <body>
        <form action="reżyser.php" method = 'post'>
            <input type="text" list = 'directors' autocomplete = "off" name = 'director'>
            <datalist id = "directors">
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
                    echo "<th>reżyser</th>";
                echo "</tr>";

                $r = mysqli_query($connection, "SELECT movies.id, movies.title, movies.description, directors.name AS director FROM `movies` INNER JOIN directors ON movies.director_id = directors.id WHERE directors.name = '" . $_POST['director'] . "';");
                $i = 0;
                
                while($row = mysqli_fetch_array($r)){
                    echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['title'] . "</td>";
                        echo "<td>" . $row['description'] . "</td>";
                        echo "<td>" . $row['director'] . "</td>";
                    echo "</tr>";
                    $i++;
                }

                if($i == 1){
                    echo "<h2>Znaleziono " . $i . " zarejestrowany film stworzony przez " . $_POST['director'] . "</h2>";
                }
                else if($i > 1 && $i < 5){
                    echo "<h2>Znaleziono " . $i . " zarejestrowane filmy stworzony przez " . $_POST['director'] . "</h2>";
                }
                else{
                    echo "<h2>Znaleziono " . $i . " zarejestrowanych filmów stworzony przez " . $_POST['director'] . "</h2>";
                }
            }
            else{
                echo "<h2>Wpisz imię i nazwisko reżysera, aby wyświetlić filmy przez niego stworzone</h2>";
            }
            ?>
        </table>

        <button><a href="wszystko.php" style = 'text-decoration: none; color: black;'>Osoby które wypożyczyły filmy z wybranym gatunkiem</a></button><br/>
        <button><a href="wypożyczone.php" style = 'text-decoration: none; color: black;'>filmy wypożyczone przez wybranego klienta</a></button><br/>
        <button><a href="gatunek.php" style = 'text-decoration: none; color: black;'>filmy z wybranego gatunku</a></button><br/>
    </body>
</html>