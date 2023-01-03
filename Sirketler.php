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
    public $Sirket_Adi;
    public $SektorId;
    public $SirketId;
    public $SektorTanim="";
    public $SirketUlke="";
    public $SirketSehir="";
    public $SirketIlce="";
}

$obj = json_decode(file_get_contents('php://input'));

switch ($obj->queryType) {
    case 'insert':
        InsertQuery($db, $obj->sirketler);
        break;
        
           case 'delete':
        DeleteQuery($db,$obj->sirketler);
        break;
        
        case 'select':
        GetAll($db);
        break;
    
    
    default:
        # code...
        break;
}


function InsertQuery($db, $kullanici){
//Veritabanına ekleme işlemi yapacak olan kod bloğu
$sorgu=$db->prepare("INSERT INTO sirketler SET 
Sirket_Adi=:SirketAdi,
SektorId=:SektorId,
SirketId=:SirketId,
SektorTanim=:SektorTanim,
SirketUlke=:SirketUlke,
SirketSehir=:SirketSehir,
SirketIlce=:SirketIlce"
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

function UpdateQuery($db,$kullanici){
$sorgu=$db->prepare("UPDATE sirketler SET 
Sirket_Adi=?,
SektorId=?,
SirketId=?,
SektorTanim=?,
SirketUlke=?,
SirketSehir=?,
SirketIlce=? WHERE SirketId=?");
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
$sorgu=$db->prepare("DELETE FROM sirketler WHERE SirketId=?");
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
$listele=$db->query("SELECT * FROM sirketler");
   echo json_encode($listele->fetch());
    
}
?>
