<?php
    $connection = mysqli_connect("localhost", "root", "", "video");
    $r = mysqli_query($connection, "SELECT movies.id, movies.title, movies.description, genres.name AS genre FROM `movies` INNER JOIN genres ON movies.genre_id = genres.id WHERE genres.id = 1;");
?>

<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <title>Gatunek</title>
    </head>
    <body>
        <table>
            <tr>
                <th>id</th>
                <th>tytuł</th>
                <th>opis</th>
                <th>gatunek</th>
            </tr>

            <?php
                while($row = mysqli_fetch_array($r)){
                    echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['title'] . "</td>";
                        echo "<td>" . $row['description'] . "</td>";
                        echo "<td>" . $row['genre'] . "</td>";
                    echo "</tr>";
                }
            ?>
        </table>
    </body>
</html>