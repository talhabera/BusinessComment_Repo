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
    $sorgu = $db->prepare("INSERT INTO kullanici_yorumlari
SET 
YorumIcerik=:yorumicerik,
YorumDurum=:yorumdurum,
YorumTarih=:yorumtarih,
YorumId=:yorumid");

    $kayit = $sorgu->execute((array)$obj);

    if ($kayit) {
        echo "Success" . "<br>";
    } else {
        echo "Error" . "<br>";
    }
}


function UpdateQuery($db, $obj)
{
    $sorgu = $db->prepare("UPDATE kullanici_yorumlari SET
YorumIcerik=:YorumIcerik,YorumDurum=:YorumDurum,YorumTarih=:YorumTarih WHERE YorumId=:YorumId"
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
    $sorgu = $db->prepare("DELETE FROM kullanici_yorumlari WHERE YorumId=:YorumId");
    $sil = $sorgu->execute(array($obj));

    if ($sil) {
        echo "Success" . "<br>";
    } else {
        echo "Error" . "<br>";
    }
}

function GetAll($db)
{
    $listele = $db->query("SELECT * FROM kullanici_yorumlari");
    echo json_encode($listele->fetchAll(PDO::FETCH_CLASS), JSON_UNESCAPED_UNICODE);
}
?>
