
<?php
//03.01.23 çağatay editledi çalışıyo.
if ($_SERVER["REQUEST_METHOD"] != "POST") return;


try{
    $db=new PDO("mysql:host=localhost;dbname=business_comment;charset=utf8","root","");
}
catch(PDOException $e)
{
    echo $e->getMessage();
}
class Kullanici{
    public $id;
    public $Kadi = "";
    public $Ksoyadi = "";
    public $DTarihi = "2000-01-01";
    public $TelNo = "";
    public $Email = "";
    public $KullaniciUnvan = "";
    public $KullaniciUlke = "";
    public $KullaniciSehir = "";
    public $KullaniciIlce = "";
    public $KayitTarihi = "2000-01-01";
    public $Kullanici_Tip_Id = 1;
    public $SirketId = 1;
    public $YorumYapilsinMi = 0;
}

$obj = json_decode(file_get_contents('php://input'));

switch ($obj->queryType) {
    case 'insert':
        InsertQuery($db, $obj->kullanicilar);
        break;
        
           case 'delete':
        DeleteQuery($db,$obj->kullanicilar);
        break;
        
        case 'select':
        GetAll($db);
        break;
    
    
    default:
        # code...
        break;
}

//Veritabanına ekleme işlemi yapacak olan kod bloğu
function InsertQuery($db, $kullanici){
    $sorgu=$db->prepare("INSERT INTO kullanicilar SET 
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

    $kayit=$sorgu->execute((array)$kullanici);
    
    if($kayit)
    {
        echo "Kayıt başarılı"."<br>";
    }
    
    else
    {
        echo "Kayıt başarısız"."<br>";
    }
}

function UpdateQuery($db, $kullanici){
    $sorgu=$db->prepare("UPDATE kullanicilar SET    KId=?,Kadi=?,Ksoyadi=?,DTarihi=?,TelNo=?,Email=?,KullaniciUnvan=?,KullaniciUlke=?,KullaniciSehir=?,KullaniciIlce=?,KayitTarihi=?, Kullanici_Tip_Id=?,SirketId=?,YorumYapilsinMi=? WHERE KId=?"
    );
    $guncelle=$sorgu->execute((array)$kullanici);
    if($guncelle)
    {
        echo "Güncelleme başarılı"."<br>";
    }
    
    else 
    {
        echo "Güncelleme başarısız"."<br>";
    }
}


function DeleteQuery($db){
    $sorgu=$db->prepare("DELETE FROM kullanicilar WHERE KId=?");
    $sil=$sorgu->execute(array(3));
    
    if($sil)
    {
        echo "Silme başarılı"."<br>";
    }
    
    else
    {
        echo "Silme başarısız"."<br>";
    }
}

function GetAll($db){
$listele=$db->query("SELECT * FROM kullanicilar");
   echo json_encode($listele->fetch());
    
}

?>