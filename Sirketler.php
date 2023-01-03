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
        echo "Success" . "<br>";
    } else {
        echo "Error" . "<br>";
    }
}

function UpdateQuery($db, $obj)
{
    $sorgu = $db->prepare("UPDATE sirketler SET 
Sirket_Adi=:Sirket_Adi,
SektorId=:SektorId,
SirketId=:SirketId,
SektorTanim=:SektorTanim,
SirketUlke=:SirketUlke,
SirketSehir=:SirketSehir,
SirketIlce=:SirketIlce WHERE SirketId=:SirketId");
    $guncelle = $sorgu->execute((array)$obj);
    if ($guncelle) {
        echo "Success" . "<br>";
    } else {
        echo "Error" . "<br>";
    }
}

function DeleteQuery($db, $obj)
{
    $sorgu = $db->prepare("DELETE FROM sirketler WHERE SirketId=:SirketId");
    $sil = $sorgu->execute(array($obj));

    if ($sil) {
        echo "Success" . "<br>";
    } else {
        echo "Error" . "<br>";
    }
}

function GetAll($db)
{
    $listele = $db->query("SELECT * FROM sirketler");
    echo json_encode($listele->fetchAll(PDO::FETCH_CLASS), JSON_UNESCAPED_UNICODE);
}
?>
