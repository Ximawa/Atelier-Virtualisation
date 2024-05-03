<?php

    include 'connect.php';

    $action = (isset($_POST['action'])) ? $_POST['action'] : $_GET['action'];

    switch ($action) {
        
        
        case 'ajout_produit':

            $pro_lib = ($_POST['pro_lib'] != '') ? "'".pg_escape_string($link, $_POST['pro_lib'])."'" : 'null';
            $pro_description = ($_POST['pro_description'] != '') ? "'".pg_escape_string($link, $_POST['pro_description'])."'" : 'null';
            $pro_prix = ($_POST['pro_prix'] != '') ? "'".pg_escape_string($link, str_replace(',','.',$_POST['pro_prix']))."'" : 'null';

            $sql = "INSERT INTO produits (pro_lib, pro_description, pro_prix) VALUES ($pro_lib,$pro_description,$pro_prix) RETURNING pro_id";
            $response = pg_query($link,$sql);
            if ($response) {

                $pro_id = pg_fetch_assoc($response)['pro_id'];

                foreach ($_FILES["pro_ressources"]["error"] as $key => $error) {
                    if ($error == UPLOAD_ERR_OK) {
                        $tmp_name = $_FILES["pro_ressources"]["tmp_name"][$key];
                        $extension = pathinfo($_FILES["pro_ressources"]["name"][$key],PATHINFO_EXTENSION);
                        $md5 = md5_file($tmp_name);
                        $name = $pro_id."-".$md5.".".$extension;
                        $url = "uploads/$name";
                        move_uploaded_file($tmp_name, $url);

                        $sql = "INSERT INTO ressources (RE_type,RE_url,pro_id) VALUES ('img','$url','$pro_id')";
                        pg_query($link,$sql);

                    }
                }

                header('Location: home.php');

            } else {
                die("Erreur SQL");
            }
            break;


        case 'modification_produit':

            $pro_id = ($_POST['pro_id'] != '') ? "'".pg_escape_string($link, $_POST['pro_id'])."'" : 'null';
            $pro_lib = ($_POST['pro_lib'] != '') ? "'".pg_escape_string($link, $_POST['pro_lib'])."'" : 'null';
            $pro_description = ($_POST['pro_description'] != '') ? "'".pg_escape_string($link, $_POST['pro_description'])."'" : 'null';
            $pro_prix = ($_POST['pro_prix'] != '') ? "'".pg_escape_string($link, str_replace(',','.',$_POST['pro_prix']))."'" : 'null';

            $sql = "UPDATE produits SET pro_lib = $pro_lib, pro_description = $pro_description, pro_prix = $pro_prix WHERE pro_id = $pro_id";
            if (pg_query($link,$sql)) {

                foreach ($_FILES["pro_ressources"]["error"] as $key => $error) {
                    if ($error == UPLOAD_ERR_OK) {
                        $tmp_name = $_FILES["pro_ressources"]["tmp_name"][$key];
                        $extension = pathinfo($_FILES["pro_ressources"]["name"][$key],PATHINFO_EXTENSION);
                        $md5 = md5_file($tmp_name);
                        $name = $_POST['pro_id']."-".$md5.".".$extension;
                        $url = "uploads/$name";
                        move_uploaded_file($tmp_name, $url);

                        $sql = "INSERT INTO ressources (RE_type,RE_url,pro_id) VALUES ('img','$url',$pro_id)";
                        pg_query($link,$sql);

                    }
                }

                header('Location: produit.php?id='.$_POST['pro_id']);

            } else {
                die("Erreur SQL");
            }
            break;
        
        
        case 'supprimer_ressource':
            if(isset($_POST['RE_id'])) {
                $RE_id = pg_escape_string($link, $_POST['RE_id']);

                $sql = "SELECT * FROM ressources WHERE RE_id = $RE_id";
                $res = pg_query($link, $sql);
                if(pg_num_rows($res) > 0) {
                    $ressource = pg_fetch_assoc($res);
                    
                    $sql = "DELETE FROM ressources WHERE RE_id = '$RE_id'";
                    if (pg_query($link, $sql)) {
                        if (file_exists($ressource['RE_url'])) {
                            unlink($ressource['RE_url']);
                        }
                        echo 'OK';
                    } else {
                        echo 'NOK';
                    }
                } else {
                    echo 'NOK';
                }
            }
            break;

        
        case 'supprimer_produit':
            if(isset($_POST['pro_id'])) {
                $pro_id = pg_escape_string($link, $_POST['pro_id']);

                $sql = "SELECT * FROM produits WHERE pro_id = $pro_id";
                $res = pg_query($link, $sql);
                if(pg_num_rows($res) > 0) {
                    $produit = pg_fetch_assoc($res);
                    
                    $sql = "SELECT * FROM ressources WHERE pro_id = $pro_id";
                    $res = pg_query($link,$sql);
                    if (pg_num_rows($res) > 0) {
                        while($ressource = pg_fetch_assoc($res)) {
                            $RE_id = $ressource['RE_id'];
                            $sql = "DELETE FROM ressources WHERE RE_id = $RE_id";
                            if (pg_query($link, $sql)) {
                                if (file_exists($ressource['RE_url'])) {
                                    unlink($ressource['RE_url']);
                                }
                            }
                        }
                    }

                    $sql = "DELETE FROM produits WHERE pro_id = $pro_id";
                    if (pg_query($link, $sql)) {
                        echo 'OK';
                    } else {
                        echo 'NOK';
                    }

                } else {
                    echo 'NOK';
                }
            }
            break;
        
        
        
        default:
            # code...
            break;
    }


?>