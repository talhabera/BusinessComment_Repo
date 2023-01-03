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
//Veritabanına ekleme işlemi yapacak olan kod bloğu
    $sorgu = $db->prepare("INSERT INTO sektor SET 
SektorTanim=:SektorTanim"
    );

    $kayit = $sorgu->execute((array)$obj);

    if ($kayit) {
        echo "Success" . "<br>";
    } else {
        echo "Error" . "<br>";
    }
}

function UpdateQuery($db, $obj)
{
    $sorgu = $db->prepare("UPDATE sektor SET
SektorId=:SektorId, SektorTanim=:SektorTanim WHERE SektorId=:SektorId"
    );
    $guncelle = $sorgu->execute((array)$obj);
    if ($guncelle) {
        echo "Success" . "<br>";
    } else {
        echo "Error" . "<br>";
    }

}

function DeleteQuery($db)
{
    $sorgu = $db->prepare("DELETE FROM sektor WHERE SektorId=:SektorId");
    $sil = $sorgu->execute(array($obj));

    if ($sil) {
        echo "Success" . "<br>";
    } else {
        echo "Error" . "<br>";
    }
}

function GetAll($db)
{
    $listele = $db->query("SELECT * FROM sektor");
    echo json_encode($listele->fetchAll(PDO::FETCH_CLASS), JSON_UNESCAPED_UNICODE);
}
?>
