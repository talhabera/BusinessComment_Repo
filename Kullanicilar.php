<?php

try {
    $db = new PDO("mysql:host=localhost;dbname=business_comment;charset=utf8", "root", "");
} catch (PDOException $e) {
    echo $e->getMessage();
}

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

//Veritabanına ekleme işlemi yapacak olan kod bloğu
function InsertQuery($db, $kullanici)
{
    $sorgu = $db->prepare("INSERT INTO kullanicilar SET 
    KId=:KId,
    Kadi=:Kadi,
    Ksoyadi=:Ksoyadi,
    DTarihi=:DTarihi,
    TelNo=:TelNo,
    Email=:Email,
    KullaniciUnvan=:KullaniciUnvan,
    KullaniciUlke=:KullaniciUlke,
    KullaniciSehir=:KullaniciSehir,
    KullaniciIlce=:KullaniciIlce,
    KayitTarihi=:KayitTarihi,
    Kullanici_Tip_Id=:Kullanici_Tip_Id,
    SirketId=:SirketId,
    YorumYapilsinMi=:YorumYapilsinMi"
    );

    $kayit = $sorgu->execute((array)$kullanici);

    if ($kayit) {
        echo "Success";
    } else {
        echo "Error";
    }
}

function UpdateQuery($db, $kullanici)
{
    $sorgu = $db->prepare("UPDATE kullanicilar SET    KId=?,Kadi=?,Ksoyadi=?,DTarihi=?,TelNo=?,Email=?,KullaniciUnvan=?,KullaniciUlke=?,KullaniciSehir=?,KullaniciIlce=?,KayitTarihi=?, Kullanici_Tip_Id=?,SirketId=?,YorumYapilsinMi=? WHERE KId=?"
    );
    $guncelle = $sorgu->execute((array)$kullanici);
    if ($guncelle) {
        echo "Success";
    } else {
        echo "Error";
    }
}


function DeleteQuery($db)
{
    $sorgu = $db->prepare("DELETE FROM kullanicilar WHERE KId=?");
    $sil = $sorgu->execute(array(3));

    if ($sil) {
        echo "Success";
    } else {
        echo "Error";
    }
}

function GetAll($db)
{
    $listele = $db->query("SELECT * FROM kullanicilar");
    echo json_encode($listele->fetch());
}

?>