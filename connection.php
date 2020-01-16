<?php

class Connection {
    
    public function initConnection() {
        define('DB_HOST', 'localhost');
        define('DB_PORT', 3306);
        define('DB_NAME', 'lxnsnxie__wprj');
        define('CHARSET', 'utf8');
        define('DB_USERNAME', 'root');
        define('DB_PASSWORD', '');

        try {
            $dsn = 'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';charset=' . CHARSET;
            $pdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $pdo->exec('set session sql_mode = traditional');
            $pdo->exec('set session innodb_strict_mode = on');
            
        } catch (PDOException $e) {
            die(htmlspecialchars($e->getMessage()));
        }
        return $pdo;
    }

    function consoleLog($output, $with_script_tags = true) {
        $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . ');';
        if ($with_script_tags) {
            $js_code = '<script>' . $js_code . '</script>';
        }
        echo $js_code;
    }

    public function getByID($pdo, $id) {
        $stmt = $pdo->prepare('select id, eng, swe, sugg_date from eng_swe_final where id =' . $id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function addSuggestionByID($pdo, $word) {
        $swe = $word[0]['swe'];
        $id = $word[0]['id'];
        $stmt = $pdo->prepare('UPDATE eng_swe_final SET swe=?, sugg_date=? WHERE id=?');
        $stmt->execute([$swe, date('Y-m-d H:i:s'), $id]);
    }

    public function rollBackByID($pdo, $word) {
        $id = $word[0]['id'];
        $swe = '#';
        $str = '0000000000';
        $stmt = $pdo->prepare('UPDATE eng_swe_final SET swe=?, sugg_date=? WHERE id=?');
        $stmt->execute([$swe, date('Y-m-d H:i:s', $str), $id]);
    }

    public function confirmByID($pdo, $word) {
        $id = $word[0]['id'];
        $str = '0000000000';
        $stmt = $pdo->prepare('UPDATE eng_swe_final SET sugg_date=? WHERE id=?');
        $stmt->execute([date('Y-m-d H:i:s', $str), $id]);
    }

    public function getSuggestions($pdo) {
        $stmt = $pdo->prepare('SELECT * from eng_swe_final WHERE sugg_date != "0000-00-00 00:00:00" AND sugg_date != "1970-01-01 01:00:00"');
        $stmt->execute();
        $result = $stmt->fetchAll();

        $suggword = new DOMDocument('1.0', 'UTF-8');
        $suggword->formatOutput = true;
        $root = $suggword->createElement('root');
        $root = $suggword->appendChild($root);
        foreach ($result as $word) {
            $term = $suggword->createElement('term');
            $root->appendChild($term);

            $id = $suggword->createElement('id');
            $id->appendChild($suggword->createTextNode($word['id']));
            $term->appendChild($id);
            $eng = $suggword->createElement('eng');
            $eng->appendChild($suggword->createTextNode($word['eng']));
            $term->appendChild($eng);
            $swe = $suggword->createElement('swe');
            $swe->appendChild($suggword->createTextNode($word['swe']));
            $term->appendChild($swe);
            $sugg_date = $suggword->createElement('sugg_date');
            $sugg_date->appendChild($suggword->createTextNode($word['sugg_date']));
            $term->appendChild($sugg_date);
        }

        return $suggword;
    }

    public function getDictionary($pdo) {
        $stmt = $pdo->prepare('select * from eng_swe_final');
        $stmt->execute();
        $result = $stmt->fetchAll();

        $words = new DOMDocument('1.0', 'UTF-8');
        $words->formatOutput = true;
        $root = $words->createElement('root');
        $root = $words->appendChild($root);
        foreach ($result as $word) {
            $term = $words->createElement('term');
            $root->appendChild($term);

            $id = $words->createElement('id');
            $id->appendChild($words->createTextNode($word['id']));
            $term->appendChild($id);

            $eng = $words->createElement('eng');
            $eng->appendChild($words->createTextNode($word['eng']));
            $term->appendChild($eng);
            $swe = $words->createElement('swe');
            $swe->appendChild($words->createTextNode($word['swe']));
            $term->appendChild($swe);
            $sugg_date = $words->createElement('sugg_date');
            $sugg_date->appendChild($words->createTextNode($word['sugg_date']));
            $term->appendChild($sugg_date);
        }

        return $words;
    }

}
