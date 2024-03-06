<?php
    error_reporting(0);
    session_start();
?>

<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <title>wpisy</title>
    </head>
    <body>
        <?php
            if($_SESSION['zalogowany']){
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

                echo "Zalogowano na konto użytkownika " . $_SESSION["login"] . "<br/>";
                echo "<button><a href='form.php' style = 'color: black; text-decoration: none'>Wprowadź nowy wpis</a></button>";
                echo "<button><a href='edytowanie.php' style = 'color: black; text-decoration: none'>Wszystkie wpisy i edycja</a></button>";
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