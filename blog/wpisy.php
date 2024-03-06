<?php
    error_reporting(0);
    session_start();
?>

<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <title>edycja</title>
    </head>
    <body>
        <?php
            if($_SESSION['zalogowany']){
                $connect = mysqli_connect("localhost", "root", "", "formularz");
                $result = mysqli_query($connect, "SELECT * FROM `uzytkownicy`");

                echo "<form action = 'edycja.php' method = 'post'>";
                    echo "<table>";
                        while($row = mysqli_fetch_array($result)){
                            echo "<tr>";
                                echo "<td>" . $row['nick'] . "<td/>";
                                echo "<td>" . $row['tytuł'] . "<td/>";
                                echo "<td>" . $row['wpis'] . "<td/>";
                            echo "</tr>";
                        }
                    echo "</table>";
                echo "</form>";

                echo "Zalogowano na konto użytkownika " . $_SESSION["login"] . "<br/>";
                echo "<button><a href='nowyWpis.php' style = 'color: black; text-decoration: none'>Wprowadź nowy wpis</a></button>";
                echo "<button><a href='edycja.php' style = 'color: black; text-decoration: none'>Edytuj lub usuń wpis</a></button>";
                echo "<form action = 'login.php' method = 'post'>";
                    echo "<button type = 'submit' name = 'logout'>Wyloguj</button>";
                echo "</form>";
            }
            else{
                echo "Nie jesteś zalogowany. Proszę się zalogować lub zarejestrować. <br/>";
                echo "<button><a href='login.php' style = 'color: black; text-decoration: none'>Zaloguj</a></button>";
                echo "<button><a href='register.php' style = 'color: black; text-decoration: none'>Zarejestruj</a></button>";
            }
        ?>
    </body>
</html>