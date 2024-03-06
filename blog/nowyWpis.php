<?php
    error_reporting(0);
    session_start();
?>

<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <title>Formularz</title>
    </head>
    <body>
        <?php
            if($_SESSION['zalogowany']){
                $a = mysqli_connect("localhost", "root", "", "formularz");

                echo "<form action = 'nowyWpis.php' method = 'post'>";
                    echo "<label for = 'tytul'>Wprowadź tytuł wpisu: </label>";
                    echo "<input type = 'text' name = 'tytul'>";
                    echo "<br/><br/>";

                    echo "<label for = 'wpis'>Wprowadź wpis: </label>";
                    echo "<input type = 'text' name = 'wpis'>";
                    echo "<br/><br/>";

                    echo "<button type = 'submit'>Wyślij</button>";
                echo "</form>";
                echo "<br/>";

                $tytul = $_POST["tytul"];
                $wpis = $_POST["wpis"];

                if($tytul != "" && $wpis != ""){
                    mysqli_query($a, "INSERT INTO `uzytkownicy` (`nick`, `tytuł`, `wpis`) VALUES ('" . $_SESSION['login'] . "', '" . $_POST['tytul'] . "', '" . $_POST['wpis'] . "');");
                    echo "Wysłano nowy wpis @" . $_SESSION['login'] . "<br/><br/>";
                }
                else{
                    echo "Proszę wprowadzić wartości <br/>";
                }

                mysqli_close($a);

                echo "Zalogowano na konto użytkownika " . $_SESSION["login"] . "<br/>";
                echo "<button><a href='edycja.php' style = 'color: black; text-decoration: none'>Edytuj lub usuń wpis</a></button>";
                echo "<button><a href='wpisy.php' style = 'color: black; text-decoration: none'>Zobacz wszystkie wpisy</a></button>";
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