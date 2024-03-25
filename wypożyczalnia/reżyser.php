<?php
    $connection = mysqli_connect("localhost", "root", "", "video");
    $r = mysqli_query($connection, "SELECT movies.id, movies.title, movies.description, directors.name AS director FROM `movies` INNER JOIN directors ON movies.director_id = directors.id WHERE directors.id = 7;");
?>

<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <title>Reżyser</title>
    </head>
    <body>
        <table>
            <tr>
                <th>id</th>
                <th>tytuł</th>
                <th>opis</th>
                <th>reżyser</th>
            </tr>
            <?php
                while($row = mysqli_fetch_array($r)){
                    echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['title'] . "</td>";
                        echo "<td>" . $row['description'] . "</td>";
                        echo "<td>" . $row['director'] . "</td>";
                    echo "</tr>";
                }
            ?>
        </table>
    </body>
</html>