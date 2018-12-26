<?php
	// Eine neue session wird gestartet
	session_start();
	// Klasse Validation wird includiert
	require_once('Validierung.php');
// Session-Variable aus den zweiten Formular werden iniziert
  if (isset($_POST['name'])) {
      $_SESSION['name'] = $_POST['name'];
  }
  
  if (isset($_POST['strasse'])) {
      $_SESSION['strasse'] = $_POST['strasse'];
  }

  if (isset($_POST['nr'])) {
      $_SESSION['nr'] = $_POST['nr'];
      
  }

  if (isset($_POST['plz'])) {
      $_SESSION['plz'] = $_POST['plz'];  
  }

  if (isset($_POST['stadt'])) {
      $_SESSION['stadt'] = $_POST['stadt'];  
  }

if (isset($firstform)) {
  $firstform = array($_POST['w1'], $_SESSION['w2'], $_SESSION['w3'], $_POST['name']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ESA3_ISP</title>
</head>
<body>

<?php 
	// Eine neue Instanz der Klasse Validation wirde erzeugt und in eine Variable gespeichert
  $wert = new Validierung; 
 
  // Daten aus den ersten Formular werden in einem Array zusammengepackt.
  $firstform = array($_SESSION['wunsch_eins'],   $_SESSION['wunsch_zwei'],   $_SESSION['wunsch_drei']);
  $fifo = array($_POST['wunsch_eins'],   $_POST['wunsch_zwei'],   $_POST['wunsch_drei']);

  // Kontrollstrukturen für die Vergabe des page_ids
  if(isset($_POST["absenden_btn_1"])) {

  	if (checkSonderZeichen($fifo)) {
  		$page_id=2;
  	}

    

  } elseif (isset($_POST["absenden_btn_2"])) {

      if(!empty($_POST)){
      /*
      * Überprufung der Felder
      */
	      $wert->name('name')->value($_POST['name'])->pattern('text');
	      $wert->name('strasse')->value($_POST['strasse'])->pattern('text');
	      $wert->name('nr')->value($_POST['nr'])->pattern('int');
	      $wert->name('plz')->value($_POST['plz'])->pattern('plz');
	      $wert->name('stadt')->value($_POST['stadt'])->pattern('text');

	      if($wert->isSuccess()){ // Wenn alles in Ordnung weite auf seite 3
	          $page_id = 3;       
	      }else{
	         echo $wert->displayErrors();
	         $page_id = 2;
	      }
  	} 

  } else {

    $page_id=1;
    
  }

  //Funktion layout() wird aufgerufen: Parameter page_id
  layout($page_id);
  
  /**
   * Die Funktion page_id() entscheidet welche Seitenlayout vergeben wird
   * 
   * @param mixed $page_id
   * @return this
   */
  function layout($page_id) {
      switch($page_id) {
          default: 
              echo '<p>Seite nicht gefunden</p>';
          case '':
          // Wenn page_id = 1 wird die Funktion erste Seite() aufgerufen
          case '1':
            erste_Seite();     
              break;
          case '2':
            zweite_Seite();
              break;
          case '3':
            ausgabe_Seite();
      }
  }
/**
 * Funktion checkSonderZeichen() prüft auf Sonder Zeichen.
 * 
 * @return boolean $isTrue
 */
function checkSonderZeichen($strings) {
	$counter=0;
	$isTrue = false;
	
	foreach ($strings as $testcase) {
	    if (!preg_match("#^[a-zA-Z0-9]+$#", $testcase)) {
   			
   			$isTrue=false;
		} else {
			$counter++;	
		}

		if ($counter >= 1) {
			$isTrue=true;
			//return true;
		} else {
			$isTrue=false;
			//return false;
			}
	}
	return $isTrue;
}
/*
* Die Funktion erste_Seite erzeugt den ersten Formular
*/

function erste_Seite() {

    echo '
    <h1>Seite 1</h1>
    <form name="form1" method="post" accept-charset="ISO-8859-1">
    Wunsch Nummer 1:<br>
    <label><input type="text" name="wunsch_eins" id="textfield"></label><br><br>
    Wunsch Nummer 2:<br>
    <label><input type="text" name="wunsch_zwei" id="textfield"></label><br><br>
    Wunsch Nummer 3:<br>
    <label><input type="text" name="wunsch_drei" id="textfield"></label><br><br>
    <p><label><input type="submit" name="absenden_btn_1" id="btn1" value="Senden"></label></p>
    </form>
  ';
}
/*
* Die Funktion zweite_Seite erzeugt den zweiten Formular
*/
function zweite_Seite() {
// Session-Variable werden übergeben
  if (isset($_POST['wunsch_eins'])) {
	  $var = $_POST['wunsch_eins'];
	  $_SESSION['wunsch_eins'] = $var;
	 
  }

    if (isset($_POST['wunsch_zwei'])) {
	  $var = $_POST['wunsch_zwei'];
	  $_SESSION['wunsch_zwei'] = $var;
	 
  }

    if (isset($_POST['wunsch_drei'])) {
	  $var = $_POST['wunsch_drei'];
	  $_SESSION['wunsch_drei'] = $var;
	 
  }
    echo '
    <h1>Seite 2</h1>
    <form name="form2" method="post" accept-charset="ISO-8859-1">
    Name:<br><input type="text" name="name" id="textfield" required><br><br>
    Strasse:<br><label><input type="text" name="strasse" id="textfield" value="irgendeine"></label><br><br>  
    Nummer:<br><label><input type="text" name="nr" id="textfield" value="10"></label><br><br>  
    Postleitzahl:<br><label><input type="text" name="plz" id="textfield" value="1234"></label><br><br>
    Stadt:<br><label><input type="text" name="stadt" id="textfield" value="irgendeine"></label><br><br>
    <p><label><input type="submit" name="absenden_btn_2" id="btn2" value="Senden"></label></p>
    </form>
  ';
}
/*
* Die Funktion ausgabe_Seite() erzeugt die dritte und letzte Seite, hier werden alle Eingaben aus beiden Formulare ausgegeben.
*/
function ausgabe_Seite() {

    echo ' <h1>Ausgabe</h1>';

    foreach ($_SESSION as $key=>$value) {
        echo "<p>" . $key . ": " . $value . " </p>" ;
      }
    
	echo' <form name="ausgabe" method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" accept-charset="ISO-8859-1">
	    <input type="submit" value="zur&uuml;ck"  >
	    </form>
	';
  
  // Zum Schluß, löschen der Session.
  session_destroy();
}


?>


</body>
</html>
