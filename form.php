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
            $a = mysqli_connect("localhost", "root", "", "formularz");

            $imie = $_POST["imie"];
            $nazwisko = $_POST["nazwisko"];
            $email = addslashes($_POST["email"]);
            $nrTelefonu = $_POST["telefon"];

            if($imie != "" && $nazwisko != "" && $email != "" && $nrTelefonu != ""){
                mysqli_query($a, "INSERT INTO `uzytkownicy` (`imie`, `nazwisko`, `email`, `numer telefonu`) VALUES ('$imie', '$nazwisko', '$email', $nrTelefonu);");
            }
            else{
                print("Błąd: Wprowadzone wartości są puste. Proszę wprowadzić wartości <br/>");
            }

            mysqli_close($a);
        ?>

        <a href="wpisy.php">Usuń wpisy</a>
        <a href="edytowanie.php">Edytuj wpisy</a>
    </body>
</html>