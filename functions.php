<?php

class Functions {
    public function noSuggestions() {
         $str = file_get_contents("inspect.html");
            //Table header
             $headstr = "<th colspan=\"1\">Inga föreslagna översättningar.</th>";
            $buildstr = "";
            $tmpstr = str_replace('---19872789483619826197359175667sdfgheaderheheheghf---', $headstr, $str);
            //Table data
            $html = str_replace('---19872789483619826197359175667sdfgfdfgfhghf---', $buildstr, $tmpstr);

            echo $html;
    }
    public function listSuggestions($words) {
        $result = array();
        if ($x = $words->getElementsByTagName('term')) {
//    echo $words->saveXML();
            for ($i = 0; $i < ($x->length); $i++) { //all words
                $id = $x->item($i)->getElementsByTagName('id');
                $eng = $x->item($i)->getElementsByTagName('eng');
                $swe = $x->item($i)->getElementsByTagName('swe');
                $sugg_date = $x->item($i)->getElementsByTagName('sugg_date');

                $tmp = array("id" => $id->item(0)->childNodes->item(0)->nodeValue,
                    "eng" => $eng->item(0)->childNodes->item(0)->nodeValue,
                    "swe" => $swe->item(0)->childNodes->item(0)->nodeValue,
                    "sugg_date" => $sugg_date->item(0)->childNodes->item(0)->nodeValue);
                array_push($result, $tmp);
            }

            ///Save this and putput to HTML file inspect.php/html
            //Save this in a string
            $headstr = "<th colspan=\"1\">Engelska</th><th colspan=\"1\">Svenska</th>"
                    . "<th colspan=\"1\">Datum</th>"
                    . "<th colspan=\"1\">Godkänn</th>"
                    . "<th colspan=\"1\">Avslå</th>";
            $buildstr = "";
            foreach ($result as $res) {
                $buildstr .= "<tr><td>";
                $buildstr .= $res['eng'] . "</td><td>";
                $buildstr .= $res['swe'] . "</td><td>";
                $buildstr .= $res['sugg_date']."</td>";
                if ($res['sugg_date'] != "0000-00-00 00:00:00" AND $res['sugg_date'] != "1970-01-01 01:00:00"){
                    $buildstr .= "<td><a href='confirm.php?confirm=yes&id=" . $res['id'] . "'>Godkänn</a></td>" .
                        "<td><a href='confirm.php?confirm=no&id=" . $res['id'] . "'>Avslå</a>";
                }else{
                    $buildstr .= "<td></td><td>";
                }
                $buildstr .= "</td></tr>";
            }
//        echo " HEADSTRING" . $headstr . "\n";
//        echo $buildstr . " BUILDSTRING\n";


            $str = file_get_contents("inspect.html");
            //Table header
            $tmpstr = str_replace('---19872789483619826197359175667sdfgheaderheheheghf---', $headstr, $str);
            //Table data
            $html = str_replace('---19872789483619826197359175667sdfgfdfgfhghf---', $buildstr, $tmpstr);

            echo $html;
        }
    }
    
public function listDictionary($words) {
//    $words = $dom->saveXML(); // put string
//    $dom->save('xml/words.xml'); // save as file
    
        $result = array();
        if ($x = $words->getElementsByTagName('term')) {
//    echo $words->saveXML();
            for ($i = 0; $i < ($x->length); $i++) { //all words
                $id = $x->item($i)->getElementsByTagName('id');
                $eng = $x->item($i)->getElementsByTagName('eng');
                $swe = $x->item($i)->getElementsByTagName('swe');
                $sugg_date = $x->item($i)->getElementsByTagName('sugg_date');

                $tmp = array("id" => $id->item(0)->childNodes->item(0)->nodeValue,
                    "eng" => $eng->item(0)->childNodes->item(0)->nodeValue,
                    "swe" => $swe->item(0)->childNodes->item(0)->nodeValue,
                    "sugg_date" => $sugg_date->item(0)->childNodes->item(0)->nodeValue);
                array_push($result, $tmp);
            }

            ///Save this and putput to HTML file inspect.php/html
            //Save this in a string
            $headstr = "<th colspan=\"1\">Engelska</th><th colspan=\"1\">Svenska</th>";
            $buildstr = "";
            foreach ($result as $res) {
                $buildstr .= "<tr><td>";
                $buildstr .= $res['eng'] . "</td><td>";
                
                
                if ($res['swe'] == '#') {
//            $buildstr .= "<a href='add.php?id=".$res['id']."&loc=\"dict\"'>Föreslå översättning?</a></td>";
            $buildstr .= "<a href='add.php?id=".$res['id']."'>Föreslå översättning?</a></td>";
        } else {
            $buildstr .= $res['swe'] . "</td>";
        }
//                $buildstr .= $res['swe'] . "</td><td>";
//                $buildstr .= $res['sugg_date']."</td>";
//                if ($res['sugg_date'] != "0000-00-00 00:00:00" AND $res['sugg_date'] != "1970-01-01 01:00:00"){
//                    $buildstr .= "<td><a href='confirm.php?confirm=yes&id=" . $res['id'] . "'>Godkänn</a></td>" .
//                        "<td><a href='confirm.php?confirm=no&id=" . $res['id'] . "'>Avslå</a>";
//                }else{
//                    $buildstr .= "<td></td><td>";
//                }
//                $buildstr .= "</td></tr>";
                $buildstr .= "</tr>";
            }
//        echo " HEADSTRING" . $headstr . "\n";
//        echo $buildstr . " BUILDSTRING\n";


            $str = file_get_contents("inspect.html");
            //Table header
            $tmpstr = str_replace('---19872789483619826197359175667sdfgheaderheheheghf---', $headstr, $str);
            //Table data
            $html = str_replace('---19872789483619826197359175667sdfgfdfgfhghf---', $buildstr, $tmpstr);

            echo $html;
        }
    }
    public function countHit() {
        $total = fopen("counter/count.txt", "r+");
        if (flock($total, LOCK_EX)) {
            $count = file_get_contents("counter/count.txt");
            ftruncate($total, 0);
            fwrite($total, ++$count);
            fflush($total);
            flock($total, LOCK_UN);
            return ($count);
        } else {
            if ($count = file_get_contents("counter/count.txt")) {
                return ($count);
            }
        }
        fclose($total);
    }

//    public function getDate() {
//        $time = $_SERVER['REQUEST_TIME'];
//        $str = date('Y:m:d, H:i:s', $time);
//        return $str;
//    }
//
//    public function logger() {
//        $time = $_SERVER['REQUEST_TIME'];
//        $logObj = new stdClass();
//        $logObj->date = date('Y:m:d H:i:s', $time);
//        $logObj->browser = getenv('HTTP_USER_AGENT');
//        $logObj->ip = getenv('REMOTE_ADDR');
//        $logJObj = json_encode($logObj);
//        $log = fopen("log.log", "a");
//        if (flock($log, LOCK_EX)) {
//            fwrite($log, $logJObj . "\n");
//            fflush($log);
//            flock($log, LOCK_UN);
//        } else {
//            echo "File busy. Please report to admin.";
//        }
//        fclose($log);
//    }
//
//    function generateFooter() {
//        return ("Copyright 2019 Monster Inc.");
//    }
}
