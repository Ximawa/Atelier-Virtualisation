<?php
    session_start();
    include 'connect.php';
    include 'fonctions.php';
    secu();

    if (!isset($_GET['id']) or $_GET['id'] == '') {
        header('Location: home.php');
    } else {
        $pro_id = pg_escape_string($link,$_GET['id']);
        $sql = "SELECT * FROM produits WHERE pro_id = $pro_id";
        $res = pg_query($link, $sql);
        if (pg_num_rows($res)  == 0) {
            header('Location: home.php');
        } else {
            $produit = pg_fetch_assoc($res);
            $prix = number_format($produit['pro_prix'],2,',',' ');
        }
    }

?><!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gestion des produits</title>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="fonctions.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">

        <h1>
            <?php echo $produit['pro_lib']; ?>
        </h1>

        <div class="prix">
            <span class="badge badge-pill badge-danger prix">
                <?php echo $prix; ?>&nbsp;€
            </span>
        </div>

        <div class="description">
            <?php echo nl2br($produit['pro_description']); ?>
        </div>
        

        <?php
            $sql = "SELECT * FROM ressources WHERE pro_id = $pro_id";
            $res = pg_query($link, $sql);
            if (pg_num_rows($res) > 0) {
                $ressources = array();
                while ($row = pg_fetch_assoc($res)) {
                    $ressources[] = $row;
                }
        ?>


        <div class="ressources">
            <header>Ressources</header>

            <?php
                foreach($ressources as $ressource) {
                    if ($ressource['re_type'] == 'img') {
                        echo '<img src="'.$ressource['re_url'].'" class="img-thumbnail thumb" data-id="'.$ressource['re_id'].'">';
                    }
                }
            ?>

        </div>


        <?php
            }
        ?>

        <div class="form-group" style="margin-top: 20px;">
                <button type="button" class="btn btn-warning" onClick="goto('form_produit.php?id=<?php echo $pro_id ?>')">Modifier</button>
                <button type="button" class="btn btn-primary" onClick="goto('home.php')">Retour</button>
        </div>

    </div>
</body>
</html>