<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="description" content="Pages en PHP">
	<title>Cours de PHP</title>
</head>
<body>

	<?php

	//commentaire sur une ligne
	/*
		variables : 
			commence par un $
			logique et en anglais
			camelCase
			auto déclarée et auto typée
			type: String, Int, Float,
			Boolean, Null
			Typage dynamique

	*/
			/*$firstName ="name";
			$lastName = "";
			$age =12;
			$size = 1.90;
			$adult = true;
			$average = null;

			//1er instruction et concaténation
			echo '<b>Bonjour</b> <u>' .$firstName." ".   $lastName.'</u>';

			$x = 5;
			//Bonjour Yves, dans 5 an(s) vous aurez 41 ans.
			echo "Bonjour ".$firstName.", dans ".$x." an(s) vous aurez ".($age+$x)." ans.";
			//opérateur arithmétiques 
			// + - * / %
			//Incrémentation et décrementation 
			$cpt = 0;
			$cpt += 1;
			$cpt = $cpt + 1;
			$cpt ++;
			$cpt++;
			++$cpt;

			/*
			$cpt = 0;
			echo $pt; //0
			echo $cpt + 1; //1
			echo $cpt +=1; //1
			echo $cpt++; //1
			echo $cpt = $cpt +; //3
			echo -- $cpt; //2
			//echo --$cpt++; //Error
			*/

			// Conditions 
			// if elseif  else 
			// switch
			// condition ternaire
			// nulle coalescent 

			/*
			$age = 18;

			if($age <= 0 || $age > 100){
				echo"Menteur";
			}if($age >= 18){
				echo "Majeur";

			}elseif($age == 18){
				echo "tout juste majeur";

			}else{
				echo "Mineur";
			}
			*/
			/*
			$genre = 0;
			switch ($genre) {
			    case 0:
					echo "Homme";
					break;
				case 1:
					echo "Femme";
					break;
				default:
					echo "Autre";
					break;
			} */

			//condition ternaire 
			/*$adult = true;

			if($adult == true){
				echo "Adulte";
			}else{
					echo "Enfant";
				}

				//syntaxe : instruction (condition) ?vrai : faux;
				echo ($adult == true)?"Adulte":"Enfant";

				//Null coalescent

			/* $average = null;
			if($average == null){
				echo "vous n'avez pas de note";
			}else{
				echo "vous n'avez pas de note";
			}

			echo $average??"vous n'avez pas de note" */

			//BOUCLES
			//WHILE -> on se connait pas le nombre d'itération
			//DO WHILE -> Au moins une itération
			//FOR -> on connait le nombre d'itération
			//FOREACH -> tableau

			/*

			$dice = rand(1,6);
			while ($dice != 6) {
				$dice = rand(1,6);
				$cpt++;
			}
			echo $cpt." tentative(5)";
			*/

			/*
			$cpt = 0;
			do{
				$dice = rand(1,6);
				%cpt++;
			}while(ùdice != 6);
			echo $cpt. " tentative(5)" */
			/*
			for($cpt=0; $cpt<10 ; ++$cpt){

			} */

			//afficher Vrai ou faux si un nombre est premier 
			/*echo "<u>question 1 :</u> <br>";
			$x = 5;  
			$isPrime = true;
	
			for ($i = 2; $i < $x; $i++) {
        		if ($x % $i == 0) {  
            	$isPrime = false;
          	     break;
               } 
            }
            /*	$x = 5;  
			$isPrime = true;
			
			if($x > 1){
			$limit = sqrt($x);
			for($cpt=2; $cpt< $ limit; $cpt++){
				if($x % $cpt ==0){
					$isPrime = false;
					break;
					}
				}
			}else {
				$isPrime = false;
			}
			echo ($isPrime($x))?"vrai" : "faux"				*/
           /* if ($isPrime);
             {
            echo 'true <br>';
            } else {
            echo 'false <br>';
            }

			//afficher les nombres premiers entre 1 et 100
			echo "<u>question 2 :</u> <br>";
            for($i = 2; $i <= 100; $i++) {
                $isPrime = true;
    			for($j = 2; $j <= $i/2; $j++) {
                    if($i % $j == 0) {
           			 $isPrime = false;
          			 	break;
                    }
                }
                if ($isPrime == true) {
                       echo $i." <br> ";
                }
            }


			//afficher les $x premiers nombres premiers
			echo "<u>question 3 :</u> <br>";
			$x = 15; 
            $nombre = 0;
            for($i = 2; $nombre < $x; $i++) {
                $isPrime = true;
                for($j = 2; $j <= $i/2; $j++) {
                    if($i % $j == 0) {
                        $isPrime = false;
                       	 break;
                    }
                }
                if($isPrime == true) {
                	$nombre++;
                    echo $i." <br> ";
                   
                }
            }
*/

		//Fonction
        //camelCase
        //Anglais
        //Cohérent
        //Unique
        //Nom résevé


            //1
            function isPrime($x){
              
			$isPrime = true;
			
			if($x > 1){
			$limit = sqrt($x);
			for($cpt=2; $cpt< $limit; $cpt++){
				if($x % $cpt ==0){
					return false;
					break;
					}
				}
			}else{
				return false;
			}	
				return true;
            }

            $x = 6;
            echo (isPrime($x))?"vrai" : "faux";

            //2
            for($number = 2 ; $number < 100; $number++){
            	echo(isPrime($number))?"<li>$number":"";
            }

            //3
            $start = time();
            $x = 100;
            $number = 2;
            while ($x > 0 ){
            	if (isPrime($number)){
            		echo "<li>".$number;
            		$x--;
            	}
            	$number++;
            } 
            echo "<br>";
            echo (microtime(true)-$start)."seconde";

            function helloYou($firstName, $lastName){
            	//global $firstaName
            	echo "bonjour".$firstName." ". $lastName;
            }
           /* helloYou("name", "lastName");
            helloYou("name");
            helloYou();
            helloYou("lastName");*/

            function cleanAndVerifiyFirstname($firstName){

			//3 fonctions natives
			//Supprimer les espaces en debut en fin de chaine
            //$firstName= trim($firstName);
			//Tout mettre en minuscule
            //$firstName = strtolower($firstName);
			//Mettre en majuscule la premiere lettre de chaque mots
            //$firstName = ucwords($firstName);
            //return $firstName;
			//Ecrire la même chose sur une seule ligne
            	//modifier la pour faire ceci (partiel)
            $firstName = ucwords(strtolower(trim($firstName)));

			return $firstName;
		}

		$firstName = " JeAN PIERre  ";
		if(cleanAndVerifiyFirstname($firstName))
		$firstName = cleanFirstname($firstName);
        echo $firstName;
 
	?>


</body>
</html>