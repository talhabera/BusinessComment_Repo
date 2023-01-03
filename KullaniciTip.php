<?php
try {
    $db = new PDO("mysql:host=localhost;dbname=business_comment;charset=utf8", "root", "");
} catch (PDOException $e) {
    echo $e->getMessage();
    return;
}

$obj = json_decode(file_get_contents('php://input'));

switch ($_SERVER["REQUEST_METHOD"]) {
    case 'GET':
        GetAll($db);
        break;
    case 'POST':
        InsertQuery($db, $obj);
        break;
    case 'PUT':
        UpdateQuery($db, $obj);
    case 'DELETE':
        DeleteQuery($db, $obj);
        break;
    default:
        break;
}

function InsertQuery($db, $obj)
{
    $sorgu = $db->prepare("INSERT INTO kullanici_tip SET 
Kullanici_Tip_Tanim=:Kullanici_Tip_Tanim"
    );

    $kayit = $sorgu->execute((array)$obj);

    if ($kayit) {
        echo "Success";
    } else {
        echo "Error";
    }
}

function UpdateQuery($db, $obj)
{
    $sorgu = $db->prepare("UPDATE kullanici_tip SET
Kullanici_Tip_Tanim=:Kullanici_Tip_Tanim WHERE Kullanici_Tip_Id=:Kullanici_Tip_Id"
    );
    $guncelle = $sorgu->execute((array)$obj);
    if ($guncelle) {
        echo "Success";
    } else {
        echo "Error";
    }
}

function DeleteQuery($db, $obj)
{
    $sorgu = $db->prepare("DELETE FROM kullanici_tip WHERE Kullanici_Tip_Id=:Kullanici_Tip_Id");
    $sil = $sorgu->execute(array($obj));

    if ($sil) {
        echo "Silme başarılı" . "<br>";
    } else {
        echo "Silme başarısız" . "<br>";
    }
}

function GetAll($db)
{
    $listele = $db->query("SELECT * FROM kullanici_tip");
    echo json_encode($listele->fetchAll(PDO::FETCH_CLASS), JSON_UNESCAPED_UNICODE);
}
?>
