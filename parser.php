<?php

include 'connection.php';
$con = new Connection();
//$stmt = initConnection();
$pdo = $con->initConnection();
$words = $con->getDictionary($pdo);

if ($x = $words->getElementsByTagName('term')) {
//    echo $words->saveXML();    
}
//get the q parameter from URL
$query = $_GET["q"];
//   echo $lang;
//$query = 'abn';
//lookup all links from the xml file if length of q>0
$result = array();
//  $hint= "";
if (strlen($query) > 1) {
        for ($i = 0; $i < ($x->length); $i++) { //all words
            $id = $x->item($i)->getElementsByTagName('id');
            $eng = $x->item($i)->getElementsByTagName('eng');
            $swe = $x->item($i)->getElementsByTagName('swe');
            if ($eng->item(0)->nodeType == 1) {
                //find a link matching the search text
                if (stristr($eng->item(0)->childNodes->item(0)->nodeValue, $query)) {
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
    echo "Inga träffar    ";
} elseif(sizeof($result) < 4) {
    #create search and return of values
    foreach ($result as $res) {
        echo "<pre>";
        #make fancy output
        #skicka query till wiki?
        echo $res['eng'] . "(eng) --> ";

        if ($res['swe'] == '#') {
            echo "Det saknas svensk översättning. <a href='add.php?id=".$res['id']."'>Föreslå översättning?</a>";
        } else {
            echo $res['swe'] . "(sve)";
        }
        echo "</pre>";
    }
    
}else {
    
    foreach ($result as $res) {
        echo "<tr><td>";
        echo $res['eng'] . "(eng)</td><td>";

        if ($res['swe'] == '#') {
            echo "Det saknas svensk översättning. <a href='add.php?id=".$res['id']."'>Föreslå översättning?</a>";
        } else {
            echo $res['swe'] . "(sve)";
        }
        echo "</td></tr>";
        
    }
}


// Skicka skiten nånstans}
//echo print_r($result);




