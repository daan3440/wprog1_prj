<?php

class Connection {
    
    public function initConnection() {
        define('DB_HOST', 'localhost');
        define('DB_PORT', 3306);
        define('DB_NAME', 'lxnsnxie__wprj');
        define('CHARSET', 'utf8');
        define('DB_USERNAME', 'root');
        define('DB_PASSWORD', '');
//        $search = 'absolute';
        try {
            $dsn = 'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';charset=' . CHARSET;
            $pdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $pdo->exec('set session sql_mode = traditional');
            $pdo->exec('set session innodb_strict_mode = on');
            

//    $words = $dom->saveXML(); // put string in test1
//    $dom->save('xml/words.xml'); // save as file
        } catch (PDOException $e) {
            die(htmlspecialchars($e->getMessage()));
        }
        return $pdo;
    }
    public function getByID($pdo, $id){
        $stmt = $pdo->prepare('select id, eng, swe from eng_swe_final where id =' . $id);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function insertByID($pdo, $word){
        $swe = $word[0]['swe'];
        $id = $word[0]['id'];
//        $word[0]['id'], $word[0]['swe']
//        echo print_r($word);
        $stmt= $pdo->prepare('UPDATE eng_swe_final SET swe=? WHERE id=?');
        $stmt->execute([$swe, $id]);
//        echo $word[0]['id']." ".$word[0]['swe'];
        
            
    }
    
    public function getDictionary($pdo) {
        $stmt = $pdo->prepare('select * from eng_swe_final');
        $stmt->execute();
        $result = $stmt->fetchAll();
        
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = true;
        $root = $dom->createElement('root');
        $root = $dom->appendChild($root);
        foreach ($result as $word) {
            $term = $dom->createElement('term');
            $root->appendChild($term);

            $id = $dom->createElement('id');
            $id->appendChild($dom->createTextNode($word['id']));
            $term->appendChild($id);

            $eng = $dom->createElement('eng');
            $eng->appendChild($dom->createTextNode($word['eng']));
            $term->appendChild($eng);
//                $attr = $dom->createAttribute('eng');
//                $attr = $dom->createAttribute('swe');
            $swe = $dom->createElement('swe');
            $swe->appendChild($dom->createTextNode($word['swe']));
            $term->appendChild($swe);
        }

        return $dom;
    }

}
