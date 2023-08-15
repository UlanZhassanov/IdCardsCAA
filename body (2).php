<?php
include_once 'ean13.php';
include_once "database.php";
include_once "card.php";

$database=new Database;
$db = $database->getConnectionMysql();
$card = new Card($db);
//$id = $_GET['id'];
$id=1;
$student = array();
$stmt = $card->getforid($id);
while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    extract($row);
    $barcode = new Barcode($barcodes, 3);
    $barcode->save();
    ?>
    <table>
        <tr>
            <td>
                <img src="data:image/jpeg;base64,<?= base64_encode($photo)?>" />

            </td>
            <td>
                ATY/NAME<br>
                <?=$name?> <br>
                TEGI/SURNAME<br>
                <?=$surname?><br>
                MARTEBESI/STATUS<br>
                Студент<br>
                TOBY/GROUP<br>
                <?=$groups?><br>
                OQY KEZENI/STUDY PERIOD<br>
                <?=$studyperiod?>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <img src="barcode.png"/>
            </td>
        </tr>
    </table>


   <?php
}
