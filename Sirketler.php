<?php
try {
    $db = new PDO("mysql:host=localhost;dbname=business_comment;charset=utf8", "root", "");

} catch (PDOException $e) {
    echo $e->getMessage();
    return;
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
//Veritabanına ekleme işlemi yapacak olan kod bloğu
    $sorgu = $db->prepare("INSERT INTO sirketler SET 
Sirket_Adi=:SirketAdi,
SektorId=:SektorId,
SirketId=:SirketId,
SektorTanim=:SektorTanim,
SirketUlke=:SirketUlke,
SirketSehir=:SirketSehir,
SirketIlce=:SirketIlce"
    );

    $kayit = $sorgu->execute((array)$obj);

    if ($kayit) {
        echo "Kayıt başarılı" . "<br>";
    } else {
        echo "Kayıt başarısız" . "<br>";
    }
}

function UpdateQuery($db, $obj)
{
    $sorgu = $db->prepare("UPDATE sirketler SET 
Sirket_Adi=?,
SektorId=?,
SirketId=?,
SektorTanim=?,
SirketUlke=?,
SirketSehir=?,
SirketIlce=? WHERE SirketId=?");
    $guncelle = $sorgu->execute((array)$obj);
    if ($guncelle) {
        echo "Güncelleme başarılı" . "<br>";
    } else {
        echo "Güncelleme başarısız" . "<br>";
    }
}

function DeleteQuery($db)
{
    $sorgu = $db->prepare("DELETE FROM sirketler WHERE SirketId=?");
    $sil = $sorgu->execute(array(3));

    if ($sil) {
        echo "Silme başarılı" . "<br>";
    } else {
        echo "Silme başarısız" . "<br>";
    }
}

function GetAll($db)
{
    $listele = $db->query("SELECT * FROM sirketler");
    echo json_encode($listele->fetchAll(PDO::FETCH_CLASS), JSON_UNESCAPED_UNICODE);
}
?>
