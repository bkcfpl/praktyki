<?php
    $connect = mysqli_connect("localhost", "root", "", "sklep");

    session_start();
    error_reporting(0);
?>

<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <title>Sklep ŚPŚD</title>

        <link href="https://fonts.googleapis.com/css2?family=Konkhmer+Sleokchher&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Audiowide|Sofia|Trirong" rel="stylesheet">

        <link rel="stylesheet" href="stylAdmin.css">
    </head>
    <body>
        <nav>
            <h2><a href="index.php" class = "index">Sklep ŚPŚD</a></h2>

            <h3 class = "login">zaloguj</h3>
            <h3 class = "cart"><a href="cart.php">koszyk</a></h3>
        </nav>

        <form action = 'admin.php' method = 'post'>

            <?php
                $r = mysqli_query($connect, "SELECT * FROM `uzytkownicy` WHERE `login` = 'admin'");
                $row = mysqli_fetch_array($r);
                
                if($_POST['login'] == $row['login'] && $_POST['password'] == $row['haslo']){
                    $r = mysqli_query($connect, "SELECT * FROM `produkty`");

                    echo "<h1>Produkty:</h1>";
                    echo "<table>";
                        echo "<tr>";
                            for($i = 0; $i < $row = mysqli_fetch_array($r); $i++){
                                echo "<td>";
                                    echo "<div class = 'produkt'>";
                                        echo "<img src='" . $row['zdjecie_link'] . "' alt='zdjęcie_przedmiotu_nr." . $i . "'>";
                                        echo "<h3>" . $row['nazwa'] ."</h3>";
                                        echo "<p>" . number_format($row['cena'], 2) . "zł</p>";
                                    echo "</div>";
                                echo "</td>";
                            
                                if(($i + 1) % 4 == 0){
                                    echo "</tr>";
                                    echo "<tr>";
                                }
                            }
                        echo "</tr>";
                    echo "</table>";

                    echo "<h1>Zamówienia:</h1>";
                    $r = mysqli_query($connect, "SELECT * FROM `historia`");
                    echo "<table class = 'zamowienia'>";
                        echo "<tr>";
                            echo "<td>id</td>";
                            echo "<td>płatność</td>";
                            echo "<td>wysyłka</td>";
                            echo "<td>adres/email</td>";
                            echo "<td>produkty</td>";
                        echo "</tr>";
                        for($i = 0; $i < $row = mysqli_fetch_array($r); $i++){     
                            echo "<tr class = 'zamowienie'>";
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td>" . $row['płatność'] . "</td>";
                                echo "<td>" . $row['wysyłka'] . "</td>";
                                echo "<td>" . $row['adres'] . "</td>";
                                echo "<td>" . $row['produkty'] . "</td>";
                            echo "</tr>";
                        }
                    echo "</table>";

                    echo "<h1>Użytkownicy:</h1>";
                    $r = mysqli_query($connect, "SELECT * FROM `uzytkownicy`");
                    echo "<table class = 'users'>";
                        echo "<tr>";
                            echo "<td>id</td>";
                            echo "<td>login</td>";
                            echo "<td>hasło</td>";
                        echo "</tr>";
                        for($i = 0; $i < $row = mysqli_fetch_array($r); $i++){     
                            echo "<tr>";
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td>" . $row['login'] . "</td>";
                                echo "<td>" . $row['haslo'] . "</td>";
                                echo "</td>";
                            echo "</tr>";
                        }
                    echo "</table>";
                }
                else{
                    echo "<p>Wprowadź login: </p>";
                    echo "<input type = 'text' name = 'login'>";

                    echo "<p>Wprowadź hasło: </p>";
                    echo "<input type = 'password' name = 'password'><br/><br/>";

                    echo "<button type = 'submit' name = 'accept'>Zaloguj</button>";
                    echo "<button><a href='register.php'>Rejestracja</a></button><br/>";
                }

                if(isset($_POST['logout'])){
                    session_destroy();
                    header("Refresh: 0");
                }
            ?>
        </form>
    </body>
</html>