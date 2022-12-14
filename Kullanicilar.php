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

//Veritabanına ekleme işlemi yapacak olan kod bloğu
function InsertQuery($db, $kullanici)
{
    $sorgu = $db->prepare("INSERT INTO kullanicilar SET 
    Kadi=:Kadi,
    Ksoyadi=:Ksoyadi,
    KullaniciAdi=:KullaniciAdi,
    Sifre=:Sifre,
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
    $sorgu = $db->prepare("UPDATE kullanicilar 
SET Kadi=:Kadi,
    Ksoyadi=:Ksoyadi,
    KullaniciAdi=:KullaniciAdi,
    Sifre=:Sifre,
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
    YorumYapilsinMi=:YorumYapilsinMi WHERE KId=:KId"
    );
    $guncelle = $sorgu->execute((array)$kullanici);
    if ($guncelle) {
        echo "Success";
    } else {
        echo "Error";
    }
}


function DeleteQuery($db, $obj)
{
    $sorgu = $db->prepare("DELETE FROM kullanicilar WHERE KId=:KId");
    $sil = $sorgu->execute((array)$obj);

    if ($sil) {
        echo "Success";
    } else {
        echo "Error";
    }
}

function GetAll($db)
{
    $listele = $db->query("SELECT * FROM kullanicilar");
    echo json_encode($listele->fetchAll(PDO::FETCH_CLASS), JSON_UNESCAPED_UNICODE);
}
?>