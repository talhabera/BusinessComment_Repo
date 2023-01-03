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

class Kullanici {
    public $SektorId;
    public $SektorTanim = "";
    
}

$obj = json_decode(file_get_contents('php://input'));

switch ($obj->queryType) {
    case 'insert':
        InsertQuery($db, $obj->sektor);
        break;
        
           case 'delete':
        DeleteQuery($db,$obj->sektor);
        break;
        
        case 'select':
        GetAll($db);
        break;
    
    
    default:
        # code...
        break;
}

function InsertQuery ($db, $kullanici){
//Veritabanına ekleme işlemi yapacak olan kod bloğu
$sorgu=$db->prepare("INSERT INTO sektor SET 
SektorId=:id,
SektorTanim=:tanim"
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
$sorgu=$db->prepare("UPDATE sektor SET
SektorId=?, SektorTanim=? WHERE SektorId=?"
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
$sorgu=$db->prepare("DELETE FROM sektor WHERE SektorId=?");
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
$listele=$db->query("SELECT * FROM sektor");
   echo json_encode($listele->fetch());
    
}
?>
