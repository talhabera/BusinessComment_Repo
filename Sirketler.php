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
