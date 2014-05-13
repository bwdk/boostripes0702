<table widtd="600" border="0"cellpadding="0" cellspacing="0">
<tr>
<th width="175"><div align="left">NOM</div></th>
<th width="150"><div align="left">PRENOM</div></th>
<th width="125"><div align="left">N° COMMANDE</div></th>
<th width="150"><div align="left">STATUT</div></th>
</tr>



<?php

$db = mysql_connect('localhost', '***', '***')or die('Impossible de se connecter au serveur');
mysql_select_db('***',$db);

$sql = 'SELECT * FROM commandes ORDER BY nom';
$req = mysql_query($sql) or die ('Pb avec la requette: '.$sql.''.mysql_error());

while($data = mysql_fetch_array($req))
{
	//on teste la valeur du statut pour déterminer la couleur
	switch ($data['statut']){
		case 'en cours':
			$couleur='red';//a remplacer par le code hexa de la couleur voulue #.......
		break;
		case 'en preparation':
			$couleur='orange';//a remplacer par le code hexa de la couleur voulue #.......
		break;
		default:
			$couleur='black';//a remplacer par le code hexa de la couleur par defaut
		break
	
	
	}
	echo "<tr style=\"color:$couleur;\">";
	echo "<td> $data['nom']</td>";
	echo "<td> $data['prenom']</td>";
	echo "<td> $data['commande']</td>";	
	echo "<td> $data['statut']</td>";
	echo "</tr>";
	
}
mysql_close();


/*autre*/

if ('odd' == $odd_or_even){
$odd_or_even = 'even';
}else{
$odd_or_even = 'odd';
}


?>
</table> 