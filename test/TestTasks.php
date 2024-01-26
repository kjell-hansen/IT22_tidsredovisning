<?php

declare (strict_types=1);
require_once __DIR__ . '/../src/tasks.php';

/**
 * Funktion för att testa alla aktiviteter
 * @return string html-sträng med resultatet av alla tester
 */
function allaTaskTester(): string {
// Kom ihåg att lägga till alla testfunktioner
    $retur = "<h1>Testar alla uppgiftsfunktioner</h1>";
    $retur .= test_HamtaEnUppgift();
    $retur .= test_HamtaUppgifterSida();
    $retur .= test_RaderaUppgift();
    $retur .= test_SparaUppgift();
    $retur .= test_UppdateraUppgifter();
    return $retur;
}

/**
 * Tester för funktionen hämta uppgifter för ett angivet sidnummer
 * @return string html-sträng med alla resultat för testerna 
 */
function test_HamtaUppgifterSida(): string {
    $retur = "<h2>test_HamtaUppgifterSida</h2>";
    try {
        // Misslyckas med hämta sida -1
        $svar = hamtaSida("-1");
        if ($svar->getStatus() === 400) {
            $retur .= "<p class='ok'>Misslyckades med att hämta sida -1 som förväntat</p>";
        } else {
            $retur .= "<p class='error'>Misslyckat test att hämta sida -1<br>"
                    . $svar->getStatus() . " returnerades istället för förväntat 400</p>";
        }

        // Misslyckas med att hämta sida 0
        $svar = hamtaSida("0");
        if ($svar->getStatus() === 400) {
            $retur .= "<p class='ok'>Misslyckades med att hämta sida 0 som förväntat</p>";
        } else {
            $retur .= "<p class='error'>Misslyckat test att hämta sida 0<br>"
                    . $svar->getStatus() . " returnerades istället för förväntat 400</p>";
        }

        // Misslyckas med att hämta sida sju
        $svar = hamtaSida("sju");
        if ($svar->getStatus() === 400) {
            $retur .= "<p class='ok'>Misslyckades med att hämta sida <i>sju</i> som förväntat</p>";
        } else {
            $retur .= "<p class='error'>Misslyckat test att hämta sida <i>sju</i><br>"
                    . $svar->getStatus() . " returnerades istället för förväntat 400</p>";
        }

        // Lyckas med att hämta sida 1
        $svar = hamtaSida("1", 2);
        if ($svar->getStatus() === 200) {
            $retur .= "<p class='ok'>Lyckades med att hämta sida 1</p>";
            $sista = $svar->getContent()->pages;
        } else {
            $retur .= "<p class='error'>Misslyckat test att hämta sida 1<br>"
                    . $svar->getStatus() . " returnerades istället för förväntat 200</p>";
        }

        // Misslyckas med att hämta sida > antal sidor
        if (isset($sista)) {
            $sista++;
            $svar = hamtaSida("$sista", 2);
            if ($svar->getStatus() === 400) {
                $retur .= "<p class='ok'>Misslyckades med att hämta sida > antal sidor, som förväntat</p>";
            } else {
                $retur .= "<p class='error'>Misslyckat test att hämta sida > antal sidor<br>"
                        . $svar->getStatus() . " returnerades istället för förväntat 400</p>";
            }
        }
    } catch (Exception $ex) {
        $retur .= "<p class='error'>Något gick fel, meddelandet säger:<br> {$ex->getMessage()}</p>";
    }

    return $retur;
}

/**
 * Test för funktionen hämta uppgifter mellan angivna datum
 * @return string html-sträng med alla resultat för testerna
 */
function test_HamtaAllaUppgifterDatum(): string {
    $retur = "<h2>test_HamtaAllaUppgifterDatum</h2>";
    try {
        // Misslyckas med från=igår till=2024-01-01
        $svar = hamtaDatum('igår', '2024-01-01');
        if ($svar->getStatus() === 400) {
            $retur .= "<p class='ok'>Misslyckades med att hämta poster mellan <i>igår</i> och 2024-01-01 som förväntat</p>";
        } else {
            $retur .= "<p class='error'>Misslyckat test med att hämta poster mellan <i>igår</i> och 2024-01-01<br>"
                    . $svar->getStatus() . " returnerades istället för förväntat 400</p>";
        }

        // Misslyckas med från=2024-01-01 till=imorgon
        $svar = hamtaDatum('2024-01-01', 'imorgon');
        if ($svar->getStatus() === 400) {
            $retur .= "<p class='ok'>Misslyckades med att hämta poster mellan 2024-01-01 och <i>imorgon</i> som förväntat</p>";
        } else {
            $retur .= "<p class='error'>Misslyckades med att hämta poster mellan 2024-01-01 och <i>imorgon</i><br>"
                    . $svar->getStatus() . " returnerades istället för förväntat 400";
        }

        // Misslyckas med från=2024-12-37 till=2024-01-01
        $svar = hamtaDatum('2024-12-37', '2024-01-01');
        if ($svar->getStatus() === 400) {
            $retur .= "<p class='ok'>Misslyckades med att hämta poster mellan 2024-12-37 och 2024-01-01 som förväntat</p>";
        } else {
            $retur .= "<p class='error'>Misslyckades med att hämta poster mellan 2024-12-37 och 2024-01-01<br>"
                    . $svar->getStatus() . " returnerades istället för förväntat 400";
        }

        // Misslyckas med från=2024-01-01 till=2024-01-37
        $svar = hamtaDatum('2024-01-01', '2024-01-37');
        if ($svar->getStatus() === 400) {
            $retur .= "<p class='ok'>Misslyckades med att hämta poster mellan 2024-01-01 och 2024-01-37 som förväntat</p>";
        } else {
            $retur .= "<p class='error'>Misslyckades med att hämta poster mellan 2024-01-01 och 2024-01-37<br>"
                    . $svar->getStatus() . " returnerades istället för förväntat 400";
        }

        // Misslyckas med från=2024-01-01 till=2023-01-01
        $svar = hamtaDatum('2024-01-01', '2023-01-01');
        if ($svar->getStatus() === 400) {
            $retur .= "<p class='ok'>Misslyckades med att hämta poster mellan 2024-01-01 och 2023-01-01 som förväntat</p>";
        } else {
            $retur .= "<p class='error'>Misslyckades med att hämta poster mellan 2024-01-01 och 2023-01-01<br>"
                    . $svar->getStatus() . " returnerades istället för förväntat 400";
        }

        // Lyckas med korrekta datum
        // Leta upp en månad med poster
        $db = connectDb();
        $stmt = $db->query("SELECT YEAR(datum), MONTH(datum), COUNT(*) AS antal "
                . "FROM uppgifter "
                . "GROUP BY YEAR(datum),MONTH(datum) "
                . "ORDER BY antal DESC "
                . "LIMIT 0,1");
        $row=$stmt->fetch();
        $ar = $row[0];
        $manad =substr("0$row[1]",-2);
        $antal = $row[2];

        // Hämta alla poster från den funna månaden
        $svar = hamtaDatum("$ar-$manad-01", date('Y-m-d', strtotime("Last day of $ar-$manad")));
        if ($svar->getStatus() === 200 && count($svar->getContent()->tasks) === $antal) {
            $retur .= "<p class='ok'>Lyckades hämta $antal poster för månad $ar-$manad<p>";
        } else {
            $retur .= "<p class='error'>Misslyckades med att hämta poster för $ar-$manad<br>"
                    . $svar->getStatus() . " returnerades istället för förväntat 200<br>"
                    . print_r($svar->getContent(), true) . "</p>";
        }
    } catch (Exception $ex) {
        $retur .= "<p class='error'>Något gick fel, meddelandet säger:<br> {$ex->getMessage()}</p>";
    }

    return $retur;
}

/**
 * Test av funktionen hämta enskild uppgift
 * @return string html-sträng med alla resultat för testerna
 */
function test_HamtaEnUppgift(): string {
    $retur = "<h2>test_HamtaEnUppgift</h2>";

    try {
        $retur .= "<p class='error'>Inga tester implementerade</p>";
    } catch (Exception $ex) {
        $retur .= "<p class='error'>Något gick fel, meddelandet säger:<br> {$ex->getMessage()}</p>";
    }

    return $retur;
}

/**
 * Test för funktionen spara uppgift
 * @return string html-sträng med alla resultat för testerna
 */
function test_SparaUppgift(): string {
    $retur = "<h2>test_SparaUppgift</h2>";

    try {
        $db= connectDb();
        // Skapa en transaktion så att vi slipper skräp i databasen
        $db->beginTransaction();
        
        // Misslyckas med att spara pga saknad aktivitetid
        $postdata=['time'=>'01:00',
            'date'=>'2023-12-31', 
            'description'=>'Detta är en testpost'];
        
        $svar= sparaNyUppgift($postdata);
        if($svar->getStatus()===400) {
            $retur .="<p class='ok'>Misslyckades med att spara uppgift utan aktivitetid, som förväntat</p>";
        } else {
            $retur .="<p class='error'>Misslyckades med att spara uppgift utan aktivitetid<br>"
            . $svar->getStatus(). " returnerades istället för förväntat 400<br>"
                    . print_r($svar->getContent(), true) . "</p>";
        }
        
        /* 
         * Lyckas med att spara post utan beskrivning
         */
        // Förbered data
        $content= hamtaAllaAktiviteter()->getContent();
        $aktiviteter=$content['activities'];
        $aktivitetId=$aktiviteter[0]->id;
        $postdata=['time'=>'01:00',
            'date'=>'2023-12-31', 
            'activityId'=>"$aktivitetId"];
        
        // Testa
        $svar= sparaNyUppgift($postdata);
        if($svar->getStatus()===200) {
            $retur .="<p class='ok'>Lyckades med att spara uppgift utan beskrivning</p>";
        } else {
            $retur .="<p class='error'>Misslyckades med att spara uppgift utan beskrivning<br>"
                    . $svar->getStatus() . " returnerades istället för förväntat 200<br>"
                    . print_r($svar->getContent(), true) . "</p>";
        }
        
        /*
         *  Lyckas spara post med alla uppgifter
         */
        $postdata['description']="Detta är en testpost";
        $svar= sparaNyUppgift($postdata);
        if($svar->getStatus()===200) {
            $retur .="<p class='ok'>Lyckades med att spara uppgift med alla uppgifter</p>";
        } else {
            $retur .="<p class='error'>Misslyckades med att spara uppgift med alla uppgifter<br>"
                    . $svar->getStatus() . " returnerades istället för förväntat 200<br>"
                    . print_r($svar->getContent(), true) . "</p>";
        }
    } catch (Exception $ex) {
        $retur .= "<p class='error'>Något gick fel, meddelandet säger:<br> {$ex->getMessage()}</p>";
    } finally {
        if($db) {
            $db->rollBack();
        }
    }

    return $retur;
}

/**
 * Test för funktionen uppdatera befintlig uppgift
 * @return string html-sträng med alla resultat för testerna
 */
function test_UppdateraUppgifter(): string {
    $retur = "<h2>test_UppdateraUppgifter</h2>";

    try {
        $retur .= "<p class='error'>Inga tester implementerade</p>";
    } catch (Exception $ex) {
        $retur .= "<p class='error'>Något gick fel, meddelandet säger:<br> {$ex->getMessage()}</p>";
    }

    return $retur;
}

function test_KontrolleraIndata(): string {
    $retur = "<h2>test_KontrolleraIndata</h2>";

    try {
        $retur .= "<p class='error'>Inga tester implementerade</p>";
    } catch (Exception $ex) {
        $retur .= "<p class='error'>Något gick fel, meddelandet säger:<br> {$ex->getMessage()}</p>";
    }

    return $retur;
}

/**
 * Test för funktionen radera uppgift
 * @return string html-sträng med alla resultat för testerna
 */
function test_RaderaUppgift(): string {
    $retur = "<h2>test_RaderaUppgift</h2>";

    try {
        $retur .= "<p class='error'>Inga tester implementerade</p>";
    } catch (Exception $ex) {
        $retur .= "<p class='error'>Något gick fel, meddelandet säger:<br> {$ex->getMessage()}</p>";
    }

    return $retur;
}
