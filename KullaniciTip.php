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
    public $Kullanici_Tip_Id;
    public $Kullanici_Tip_Tanim = "";
}


$obj = json_decode(file_get_contents('php://input'));

switch ($obj->queryType) {
    case 'insert':
        InsertQuery($db, $obj->kullaniciTip);
        break;
        
    case 'delete':
        DeleteQuery($db,$obj->kullaniciTip);
        break;
        
        case 'select':
        GetAll($db);
        break;
    
    default:
        # code...
        break;
}

//Veritabanına ekleme işlemi yapacak olan kod bloğu
function InsertQuery($db, $kullaniciTip){
$sorgu=$db->prepare("INSERT INTO kullanici_tip SET 
Kullanici_Tip_Tanim=:tanim"
);

$kayit=$sorgu->execute((array)$kullaniciTip);

if($kayit)
{
    echo "Kayıt başarılı"."<br>";
}

else
{
    echo "Kayıt başarısız"."<br>";
}

}

function UpdateQuery($db){
$sorgu=$db->prepare("UPDATE kullanici_tip SET
Kullanici_Tip_Tanim=? WHERE Kullanici_Tip_Id=?"
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
$sorgu=$db->prepare("DELETE FROM kullanici_tip WHERE Kullanici_Tip_Id=?");
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
$listele=$db->query("SELECT * FROM kullanici_tip");
   echo json_encode($listele->fetch());
    
}
?>
