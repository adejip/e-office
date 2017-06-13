<?php
$db = new PDO("mysql:host=localhost;dbname=laporan_improved","root","");

for($i=1;$i<=86;$i++) {
    $n = rand(3,7);
    for($j=1;$j<=$n;$j++) {
        $idkelurahan = $i;
        $nama_kelurahan = "Lingkungan ".$j;
        $stmt = $db->prepare("INSERT INTO `lingkungan` (`idkelurahan`,`nama_lingkungan`) VALUES (:idkelurahan,:nama_lingkungan)");
        $stmt->bindParam(":idkelurahan",$idkelurahan);
        $stmt->bindParam(":nama_lingkungan",$nama_kelurahan);
        $stmt->execute();
    }
}