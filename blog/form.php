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
        <form action = "form.php" method = "post">
            <label for = "imie">Wprowadź imię: </label>
            <input type = "text" name = "imie">
            <br/><br/>

            <label for = "nazwisko">Wprowadź nazwisko: </label>
            <input type = "text" name = "nazwisko">
            <br/><br/>

            <label for = "email">Wprowadź email: </label>
            <input type = "email" name = "email">
            <br/><br/>

            <label for = "telefon">Wprowadź numer telefonu: </label>
            <input type = "number" name = "telefon">
            <br/><br/>

            <button type = "submit">Wyślij</button>
        </form>
        <br/>

        <?php
            if($_SESSION['zalogowany']){
                $a = mysqli_connect("localhost", "root", "", "formularz");

                $imie = $_POST["imie"];
                $nazwisko = $_POST["nazwisko"];
                $email = addslashes($_POST["email"]);
                $nrTelefonu = $_POST["telefon"];

                if($imie != "" && $nazwisko != "" && $email != "" && $nrTelefonu != ""){
                    mysqli_query($a, "INSERT INTO `uzytkownicy` (`imie`, `nazwisko`, `email`, `numer telefonu`) VALUES ('$imie', '$nazwisko', '$email', $nrTelefonu);");
                }
                else{
                    print("Proszę wprowadzić wartości <br/>");
                }

                mysqli_close($a);

                echo "Zalogowano na konto użytkownika " . $_SESSION["login"] . "<br/>";
                echo "<button><a href='wpisy.php' style = 'color: black; text-decoration: none'>Usuwanie wpisów</a></button>";
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