<?php

/**
 * Reprenez le code de l'exercice précédent et transformez vos requêtes pour utiliser les requêtes préparées
 * la méthode de bind du paramètre et du choix du marqueur de données est à votre convenance.
 */

$server = 'localhost';
$db = 'exo_190';
$user = 'root';
$pass = '';

try {
    /**
     * Créez ici votre objet de connection PDO, et utilisez à chaque fois le même objet $pdo ici.
     */

    $pdo = new PDO("mysql:host=$server;dbname=$db;charset=utf8", $user,$pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Nous sommes connectés à la base de donnés.";

$requestU = "
     INSERT INTO utilisateur (nom ,prenom ,email ,password ,adresse ,code_postal ,pays )
        VALUES('Sam','Coquelet','sam.coquelet@gmail.com','Naruto1990','21 rue paris',59610,'france')
  ";
    $pdo->exec($requestU);


    $nom = 'Samuel';
    $prenom = 'coquelet';
    $mail = 'test@gmail.com';
    $password = 'SamSam';
    $adresse = 'rue jean jaures';
    $code_postal = 59610;
    $pays = 'france';

    $stm = $pdo->prepare("
            INSERT INTO utilisateur (nom ,prenom ,email ,password ,adresse ,code_postal ,pays )
        VALUES(:nom,:prenom,:mail,:password,:adresse,:code_postal,:pays)
  
    ");
    $stm->execute([
        ':nom' =>$nom,
        ':prenom'=> $prenom,
        ':mail'=> $mail,
        ':password'=> $password,
        ':adresse'=> $adresse,
        ':code_postal'=> $code_postal,
        ':pays'=> $pays,
    ]);
    echo 'utilisateur ajouté';

    function sanitize($data) {
        $data = trim($data);
        $data = stripcslashes($data);
        $data = htmlspecialchars($data);
        $data= addslashes($data);
        return $data;
    }
}

catch(PDOException $exception){
    echo $exception->getMessage();
    $pdo->rollBack();
}