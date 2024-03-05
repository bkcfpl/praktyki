<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <title>wpisy</title>
    </head>
    <body>
        <?php
            $connect = mysqli_connect("localhost", "root", "", "formularz");
            $result = mysqli_query($connect, "SELECT * FROM `uzytkownicy`");

            echo "<form action = 'wpisy.php' method = 'post'>";
                echo "<table>";
                    while($row = mysqli_fetch_array($result)){
                        echo "<tr>";
                            echo "<td>" . $row['imie'] . "<td/>";
                            echo "<td>" . $row['nazwisko'] . "<td/>";
                            echo "<td>" . $row['email'] . "<td/>";
                            echo "<td>" . $row['numer telefonu'] . "<td/>";

                            $rowID = $row['id'];
                            echo "<button type = 'submit' name = 'delete$rowID'>usuń</button>";
                        echo "</tr>";

                        if(isset($_POST['delete' . $rowID])){
                            mysqli_query($connect, "DELETE FROM `uzytkownicy` WHERE `uzytkownicy`.`id` = $rowID;");
                            header("Refresh:0");
                        }
                    }
                echo "</table>";
            echo "</form>";
        ?>

        <a href="form.php">Wprowadź wpis</a>
        <a href="edytowanie.php">Edytuj wpisy</a>
    </body>
</html>