<?php
try {
    $db = new PDO("mysql:host=localhost;dbname=business_comment;charset=utf8", "root", "");
} catch (PDOException $e) {
    echo $e->getMessage();
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    GetAll($db);
    return;
};

$obj = json_decode(file_get_contents('php://input'));

switch ($obj->queryType) {
    case 'insert':
        InsertQuery($db, $obj->value);
        break;
    case 'update':
        UpdateQuery($db, $obj->value);
    case 'delete':
        DeleteQuery($db, $obj->value);
        break;
    case 'select':
        GetAll($db);
        break;
    default:
        break;
}

function InsertQuery($db, $obj)
{
    $sorgu = $db->prepare("INSERT INTO kullanici_tip SET 
Kullanici_Tip_Tanim=:tanim"
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
Kullanici_Tip_Tanim=? WHERE Kullanici_Tip_Id=?"
    );
    $guncelle = $sorgu->execute((array)$obj);
    if ($guncelle) {
        echo "Success";
    } else {
        echo "Error";
    }
}

function DeleteQuery($db)
{
    $sorgu = $db->prepare("DELETE FROM kullanici_tip WHERE Kullanici_Tip_Id=? ");
    $sil = $sorgu->execute(array(3));

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
