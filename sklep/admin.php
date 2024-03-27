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
                //łączenie się z tabelką użytkownicy, gdzie login = admin
                $r = mysqli_query($connect, "SELECT * FROM `uzytkownicy` WHERE `login` = 'admin'");
                $row = mysqli_fetch_array($r);

                //jeśli przycisk do edycji przedmiotu został wybrany, łączy się z tabelką produkty
                if(isset($_POST['edit_item'])){
                    $_SESSION['item_id'] = $_POST['edit_item'] + 1;
                    $r = mysqli_query($connect, "SELECT * FROM `produkty` WHERE `id` = '" . $_SESSION['item_id'] . "'");
                    $row = mysqli_fetch_array($r);
                    
                    echo "<h1>Edycja:</h1>";

                    //automatycznie aktualne wartości, w celu łatwiejszej edycji
                    echo "<input type = 'text' required name = 'nazwa' value = '" . $row['nazwa'] . "'><br/>";
                    echo "<input type = 'text' required name = 'cena' value = '" . number_format($row['cena'], 2) . "'><br/>";
                    echo "<textarea required name = 'opis' rows = '5' cols = '33'>" . $row['opis'] . "</textarea><br/>";

                    echo "<button type = 'submit' name = 'submit_edit_item'>Zmień</button>";
                }
                //jeśli przycisk do edycji zamówienia został wybrany, łączy się z tabelką historia
                else if(isset($_POST['edit_order'])){
                    $_SESSION['order_id'] = $_POST['edit_order'];
                    $r = mysqli_query($connect, "SELECT * FROM `historia` WHERE `id` = '" . $_SESSION['order_id'] . "'");
                    $row = mysqli_fetch_array($r);
                    
                    echo "<h1>Edycja:</h1>";

                    //automatycznie aktualne wartości, w celu łatwiejszej edycji
                    echo "<input type = 'text' required name = 'platnosc' value = '" . $row['płatność'] . "'><br/>";
                    echo "<input type = 'text' required name = 'wysylka' value = '" . $row['wysyłka'] . "'><br/>";
                    echo "<input type = 'text' required name = 'adres' value = '" . $row['adres'] . "'><br/>";
                    echo "<textarea required name = 'produkty' rows = '5' cols = '33'>" . $row['produkty'] . "</textarea><br/>";

                    echo "<button type = 'submit' name = 'submit_edit_order'>Zmień</button>";
                }
                //jeśli przycisk do edycji użytkownika został wybrany, łączy się z tabelką użytkownicy
                else if(isset($_POST['edit_user'])){
                    $_SESSION['user_id'] = $_POST['edit_user'] + 1;
                    $r = mysqli_query($connect, "SELECT * FROM `uzytkownicy` WHERE `id` = '" . $_SESSION['user_id'] . "'");
                    $row = mysqli_fetch_array($r);
                    
                    echo "<h1>Edycja:</h1>";

                    //automatycznie aktualne wartości, w celu łatwiejszej edycji
                    echo "<input type = 'text' required name = 'login' value = '" . $row['login'] . "'><br/>";
                    echo "<input type = 'text' required name = 'haslo' value = '" . $row['haslo'] . "'><br/>";

                    echo "<button type = 'submit' name = 'submit_edit_user'>Zmień</button>";
                }

                //jeśli jakikolwiek z przycisków do zatwierdzenia edycji został kliknięty, wpisuje te wartości do odpowiednich pól w odpowiednich tabelkach
                if(isset($_POST['submit_edit_item'])){
                    $desc = addslashes($_POST['opis']);

                    mysqli_query($connect, "UPDATE `produkty` SET `nazwa` = '" . $_POST['nazwa'] . "', `cena` = '" . $_POST['cena'] . "', `opis` = '" . $desc . "' WHERE `produkty`.`id` = " . $_SESSION['item_id'] . ";");
                }
                else if(isset($_POST['submit_edit_order'])){
                    mysqli_query($connect, "UPDATE `historia` SET `płatność` = '" . $_POST['platnosc'] . "', `wysyłka` = '" . $_POST['wysylka'] . "', `adres` = '" . $_POST['adres'] . "', `produkty` = '" . $_POST['produkty'] . "' WHERE `historia`.`id` = " . $_SESSION['order_id'] . ";");
                }
                else if(isset($_POST['submit_edit_user'])){
                    mysqli_query($connect, "UPDATE `uzytkownicy` SET `login` = '" . $_POST['login'] . "', `haslo` = '" . $_POST['haslo'] . "' WHERE `uzytkownicy`.`id` = " . $_SESSION['user_id'] . ";");
                }
                
                //jeśli poprawnie zalogowano się na admina, lub jakikolwiek przycisk był kliknięty + łączenie z tabelką produkty
                if(($_POST['login'] == $row['login'] && $_POST['password'] == $row['haslo']) || isset($_POST['edit_item']) || isset($_POST['edit_order']) || isset($_POST['edit_user']) || isset($_POST['submit_edit_item']) || isset($_POST['submit_edit_order']) || isset($_POST['submit_edit_user'])){
                    $r = mysqli_query($connect, "SELECT * FROM `produkty`");

                    echo "<h1>Produkty:</h1>";
                    echo "<table>";
                        echo "<tr>";
                            //wyświetlanie wszystkich dostępnych produktów
                            for($i = 0; $i < $row = mysqli_fetch_array($r); $i++){
                                echo "<td>";
                                    echo "<div class = 'produkt'>";
                                        echo "<img src='" . $row['zdjecie_link'] . "' alt='zdjęcie_przedmiotu_nr." . $i . "'>";
                                        echo "<h3>" . $row['nazwa'] ."</h3>";
                                        echo "<p>" . number_format($row['cena'], 2) . "zł</p>";

                                        echo "<button type = 'submit' name = 'edit_item' value = $i>Edytuj</button>";
                                    echo "</div>";
                                echo "</td>";
                            
                                //co 4 produkt kończy rząd. To jest po to, aby było wyświetlane maksymalnie 4 produkty w rzędzie
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
                            echo "<td>Przycisk edycji</td>";
                        echo "</tr>";

                        //wyświetlanie wszystkich zamówień
                        for($i = 2; $i - 2 < $row = mysqli_fetch_array($r); $i++){     
                            echo "<tr class = 'zamowienie'>";
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td>" . $row['płatność'] . "</td>";
                                echo "<td>" . $row['wysyłka'] . "</td>";
                                echo "<td>" . $row['adres'] . "</td>";
                                echo "<td>" . $row['produkty'] . "</td>";

                                echo "<td><button type = 'submit' name = 'edit_order' value = $i>Edytuj</button></td>";
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
                            echo "<td>Przycisk edycji</td>";
                        echo "</tr>";
                        
                        //wyświetlanie wszystkich użytkowników
                        for($i = 0; $i < $row = mysqli_fetch_array($r); $i++){     
                            echo "<tr>";
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td>" . $row['login'] . "</td>";
                                echo "<td>" . $row['haslo'] . "</td>";

                                echo "<td><button type = 'submit' name = 'edit_user' value = $i>Edytuj</button></td>";
                            echo "</tr>";
                        }
                    echo "</table>";
                }
                //jeśli niepoprawnie zalogowano się na admina, ani żaden z przycisków nie został kliknięty
                else{
                    echo "<p>Wprowadź login: </p>";
                    echo "<input type = 'text' name = 'login'>";

                    echo "<p>Wprowadź hasło: </p>";
                    echo "<input type = 'password' name = 'password'><br/><br/>";

                    echo "<button type = 'submit' name = 'accept'>Zaloguj</button>";
                }
            ?>
        </form>
    </body>
</html>