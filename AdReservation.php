<html>
	<!-- this page will allow the management
	of all the reservations-->
	<head>
        <title>Récapitulatif des réservations</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="style.css" />
    </head>
	
	<body>
		<?php
			
			/*connection to the database*/
			$bdd = new mysqli("localhost","root","","reservation") or
					die ("Could not select database");		
			/*sql request*/
			$query= "SELECT recapitulatif.id ,Destination ,Assurance,Total
						,Nom,Age
						FROM recapitulatif , personnes
						where personnes.id =recapitulatif.Personnes_id";
					
			$result = $bdd->query($query) or die ("Query failed");
			
			
		
			echo '<h1>Liste des réservations</h1>';
			/*display of columns*/
			if ($result->num_rows ==0)
			{
				echo "Aucune ligne trouvée, rien à afficher.";
				exit;
			}
			else
			{	
			 echo' 
				<table class="cadre">
					<tr>
						<th class="cadre">Id</th><th class="cadre">Destination</th>
						<th class="cadre">Assurance</th><th class="cadre">Total</th>
						<th class="cadre">Nom</th><th class="cadre">Age</th>
					</tr>';
			}
		
	
			echo "</tr>\n";
			/*display of sql request's answer*/
			while($line=$result->fetch_assoc())
			{
				foreach($line as $value)
				{
					
					echo "\t\t<td class=\"cadre\">$value</td>\n";
					
				}
				echo"\t<tr>\n";
			}
	
		
		?>
	</body>

</html>