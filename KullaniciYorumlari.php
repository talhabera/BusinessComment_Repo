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
    default:
        break;
}

function InsertQuery($db, $obj)
{
    $sorgu = $db->prepare("INSERT INTO kullanici_yorumlari
SET KId=:id,
YorumIcerik=:yorumicerik,
YorumDurum=:yorumdurum,
YorumTarih=:yorumtarih,
YorumId=:yorumid");

    $kayit = $sorgu->execute((array)$obj);

    if ($kayit) {
        echo "Kayıt başarılı" . "<br>";
    } else {
        echo "Kayıt başarısız" . "<br>";
    }
}


function UpdateQuery($db, $obj)
{
    $sorgu = $db->prepare("UPDATE kullanici_yorumlari SET
YorumIcerik=?,YorumDurum=?,YorumTarih=? WHERE YorumId=?"
    );
    $guncelle = $sorgu->execute((array)$obj);
    if ($guncelle) {
        echo "Güncelleme başarılı" . "<br>";
    } else {
        echo "Güncelleme başarısız" . "<br>";
    }
}

function DeleteQuery($db)
{
    $sorgu = $db->prepare("DELETE FROM kullanici_yorumlari WHERE YorumId=?");
    $sil = $sorgu->execute(array(3));

    if ($sil) {
        echo "Silme başarılı" . "<br>";
    } else {
        echo "Silme başarısız" . "<br>";
    }
}

function GetAll($db)
{
    $listele = $db->query("SELECT * FROM kullanici_yorumlari");
    echo json_encode($listele->fetchAll(PDO::FETCH_CLASS), JSON_UNESCAPED_UNICODE);
}
?>
