<?php

include 'connection.php';
$con = new Connection();
$pdo = $con->initConnection();

$words = $con->getDictionary($pdo);

if ($x = $words->getElementsByTagName('term')) {
//    echo $words->saveXML();    
}
//get the q parameter from URL
$query = $_GET["q"];
//   echo $lang;
$result = array();
if (strlen($query) > 2) {
        for ($i = 0; $i < ($x->length); $i++) {
            $id = $x->item($i)->getElementsByTagName('id');
            $eng = $x->item($i)->getElementsByTagName('eng');
            $swe = $x->item($i)->getElementsByTagName('swe');
            if ($eng->item(0)->nodeType == 1) {
                //find a post matching the search text
                if (stristr($eng->item(0)->childNodes->item(0)->nodeValue, $query) || stristr($swe->item(0)->childNodes->item(0)->nodeValue, $query)) {
                    if ($result == null) {
                        $tmp = array("id" => $id->item(0)->childNodes->item(0)->nodeValue,
                            "eng" => $eng->item(0)->childNodes->item(0)->nodeValue,
                            "swe" => $swe->item(0)->childNodes->item(0)->nodeValue);
                        array_push($result, $tmp);
                    } else {
                        $tmp = array("id" => $id->item(0)->childNodes->item(0)->nodeValue,
                            "eng" => $eng->item(0)->childNodes->item(0)->nodeValue,
                            "swe" => $swe->item(0)->childNodes->item(0)->nodeValue);
                        array_push($result, $tmp);
                    }
                }
            }
        }
}


if ($result == null) {
    echo "<tr><td colspan=\"2\">Inga träffar</td></tr>";
    //Preapring for dictionary function.
} elseif(sizeof($result) < 4) {
    foreach ($result as $res) {
        #send query till wiki?
        echo "<tr><td>";
        echo $res['eng'] . "</td><td>";

        if ($res['swe'] == '#') {
            echo "<a href='add.php?id=".$res['id']."'>Föreslå översättning?</a>";
        } else {
            echo $res['swe'];
        }
        echo "</td></tr>";
    }
    
}else {
    
    foreach ($result as $res) {
        echo "<tr><td>";
        echo $res['eng'] . "</td><td>";

        if ($res['swe'] == '#') {
            echo "<a href='add.php?id=".$res['id']."'>Föreslå översättning?</a>";
        } else {
            echo $res['swe'];
        }
        echo "</td></tr>";
        
    }
}
//echo print_r($result);




