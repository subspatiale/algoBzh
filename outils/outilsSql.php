<?php 

//fonction de connexion � la basz de donn�e.

function connexionSql(){
	
try {
	$connexion = new PDO('mysql:host=localhost;dbname=algobreizh_gestion','root','',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (Exception $e) {
	
	echo "Impossible de se connecter � la base de donn�e, Erreur:". $e->getMessage() . "</br>";
}


return $connexion;
}

//fonction qui �x�cute des requ�tes sql rentr�e en param�tre

function requeteExe($connexion, $requete){


$resultat = $connexion->query($requete);

return $resultat;
}


//fonction qui v�rifie l'�xistance d'un nom d'utilisateur entr� en param�tre dans la base de donn�e 

function verifUserExist($pseudo){
	
	$co = connexionSql();	
	$req = "SELECT id FROM utilisateur WHERE id ='".$pseudo."'";	
	$res = requeteExe($co, $req);
	$res = $res->fetch();
	if ($res['id'] == $pseudo){
		
		$exist = true;
		
	}else {
		
		$exist = false;
	}
	
	return $exist;
	
}

//fonction qui v�rifie l'�xistance d'un couple nom d'utilisateur et mot de passe rent� en param�te dans la base de donn�e

function testMdp($pseudo, $mdp){
	
	$co = connexionSql();
	$req = "select mdp from utilisateur where id ='".$pseudo."'";
	$res = requeteExe ($co, $req);
	$mdpTest = $res->fetch();
	$hash = hashMdp($mdp);
	
	if ($mdpTest['mdp'] == $hash){
		
		$exist = true;
	}else{
		
		$exist = false;
	}
	
	return $exist;
}


//fonction qui v�rifie l'existance du num�ro client

function verifNumCli($numCli){
	
	$co = connexionSql();
	$req = "SELECT id FROM customer WHERE id = '".$numCli."'";
	$res = requeteExe ($co, $req);
	$test = $res->fetch();
	
	if ($test['id'] == $numCli){
		
		$exist = true;
		
	}else{
		
		$exist = false;
		
	}
	
	return $exist;
	
}

function stockMdp($co, $mdp, $numCli){
	
	$co = connexionSql();
	$req = "INSERT INTO utilisateur VALUES ('".$numCli."', '".$mdp."')";
	$res = requeteExe ($co, $req);

	
}



//fonction qui hashe le mod de passe rent� en parma�tre et retourne ce dernier hash�

function hashMdp($mdp){
	
	$hash = password_hash($mdp,PASSWORD_BCRYPT ,array('cost'=>12, 'salt'=>"FlI78FilMgi86hgeOGHEoghnesom",));
	$tabMdp =  explode("-", $hash);	
	return $hash;
}






?>