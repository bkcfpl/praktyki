<?php
    $connect = mysqli_connect("localhost", "root", "", "sklep");
    $r = mysqli_query($connect, "SELECT * FROM `produkty`");

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

        <link rel="stylesheet" href="stylCart.css">
    </head>
    <body>
        <nav>
            <h2><a href="index.php">Sklep ŚPŚD</a></h2>

            <h3 class = "cart"><a href="cart.php">koszyk</a></h3>
        </nav>

        <form action='cart.php' method = 'post'>
            <?php
                echo "<table>";

                    echo "<tr class = 'headers'>";
                        echo "<th>nazwa</th>";
                        echo "<th>ilość</th>";
                        echo "<th>cena</th>";
                    echo "</tr>";

                    $loop = true;
                    $i = 0;
                    $summary = 0;
                    while($loop){
                        if($_SESSION['koszyk'][$i][0] != null){
                            if($i % 2 == 0){
                                echo "<tr>";
                                    echo "<td>" . $_SESSION['koszyk'][$i][0] . "</td>";
                                    echo "<td>" . $_SESSION['koszyk'][$i][1] . "</td>";
                                    echo "<td>" . $_SESSION['koszyk'][$i][2] . "</td>";
                                echo "</tr>";
                            }
                            else{
                                echo "<tr class = 'second'>";
                                    echo "<td>" . $_SESSION['koszyk'][$i][0] . "</td>";
                                    echo "<td>" . $_SESSION['koszyk'][$i][1] . "</td>";
                                    echo "<td>" . $_SESSION['koszyk'][$i][2] . "</td>";
                                echo "</tr>";
                            }

                            $summary += $_SESSION['koszyk'][$i][2];
                            $i++;
                        }
                        else{
                            $loop = false;
                        }
                    }
                echo "</table>";

                $loop = true;
                $i = 0;
                $summary = 0;

                // echo "W sumie " . $summary;
            ?>
        </form>
    </body>
</html>