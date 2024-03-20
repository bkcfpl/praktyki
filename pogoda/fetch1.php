<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <title>Document</title>
    </head>
    <body>
        <form action="fetch1.php" method = "post">
            <p>Wprowadź rasę psa (po angielsku) aby wybrać rasę, lub kliknij przycisk aby wylosować rasę, i zobaczyć zdjęcie. (Lista ras znajduje się w konsoli)</p>
            <input type="text" name = "rase">

            <button type="submit">Potwierdź</button>
        </form>

        <img id="a" src="" alt="">

        <script>
            let rase = '<?php echo $_POST['rase'];?>';

            if(rase == ""){
                fetch("https://dog.ceo/api/breeds/image/random")
                    .then(res => res.json())
                    .then(res => {
                        document.getElementById("a").src = res.message;
                    })
            }
            else{
                fetch("https://dog.ceo/api/breed/" + rase + "/images/random")
                    .then(res => res.json())
                    .then(res => {
                        document.getElementById("a").src = res.message;
                    })
            }

            fetch("https://dog.ceo/api/breeds/list/all")
                .then(res => res.json())
                .then(res => {
                    console.log(res.message);
                })
        </script>
    </body>
</html>

