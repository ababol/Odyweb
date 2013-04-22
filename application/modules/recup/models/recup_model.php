<?php

class Recup_model extends CI_Model
{
	public function add($cDB, $guid, $account, $serveur, $money, $job1, $metier1, $job2, $metier2, $archeologie, $cuisine, $peche, $secourisme, $armurerie, $type, $costDp)
	{
		$date = date("Y-m-d H:i:s");
		$cDB->query("REPLACE INTO ".table("character_recup")." (`".column("character_recup", "guid")."`, `".column("character_recup", "account")."`, `".column("character_recup", "serveur")."`, 
			`".column("character_recup", "level")."`, `".column("character_recup", "money")."`, `".column("character_recup", "ip")."`, `".column("character_recup", "job1")."`, `".column("character_recup", "metier1")."`, 
			`".column("character_recup", "job2")."`, `".column("character_recup", "metier2")."`, `".column("character_recup", "archeologie")."`, `".column("character_recup", "cuisine")."`, `".column("character_recup", "peche")."`
			, `".column("character_recup", "secourisme")."`, `".column("character_recup", "armurerie")."`, `".column("character_recup", "date_creation")."`, `".column("character_recup", "last_maj")."`
			, `".column("character_recup", "commentaire")."`, `".column("character_recup", "type")."`, `".column("character_recup", "etat")."`, `".column("character_recup", "costDp")."`) 
			VALUES (".$guid.", '".$account."', '".$serveur."', 85, '".$money."', '".$_SERVER['REMOTE_ADDR']."', '".$job1."', '".$metier1."', '".$job2."', '".$metier2."', '".$archeologie."', '".$cuisine."', '".$peche."', 
				'".$secourisme."', '".$armurerie."', '".$date."', '".$date."', 'Attente de Validation', '".$type."', 0,  '".$costDp."')");
	}

	public function del($cDB, $guid)
	{
		$cDB->query("DELETE FROM ".table("character_recup")." WHERE `".column("character_recup", "guid")."` =  '".$guid."'");
	}

	public function getRecupList($cDB, $etat, $page) {
		$page = intval($page);
		$limitMin = $page*50;
		$limitMax = $limitMin+50;
		$query = $cDB->query("SELECT * FROM character_recup WHERE etat = ? LIMIT ?,?", array($etat, $limitMin, $limitMax));
		
		if($query->num_rows() > 0)
		{
			$queryArray = $query->result_array();
			$size = sizeof($queryArray);
			for ($i=0; $i < $size; $i++) { 
				$queryArray[$i]['name'] = $this->realms->getRealm(1)->getCharacters()->getNameByGuid($queryArray[$i]["guid"]);
			}
			return $queryArray;
		}
		else
		{
			return false;
		}
	}

	public function getRecup($cDB, $guid) {
		$query = $cDB->query("SELECT guid, account, money, job1, metier1, job2, metier2, archeologie, cuisine, peche, secourisme, commentaire, etat FROM character_recup WHERE guid = ?", $guid);

		if($query->num_rows() > 0)
		{
			$result = $query->result_array();
			return $result[0];
		}
		else
		{
			return false;
		}
	}

	public function edit($cDB, $guid, $money, $job1, $metier1, $job2, $metier2, $archeologie, $cuisine, $peche, $secourisme, $etat, $commentaire) {
		$last_maj = date("Y-m-d H:i:s");
		$cDB->query("UPDATE character_recup SET `money` = ?, `job1` = ?, `metier1` = ?, `job2` = ?, `metier2` = ?, `archeologie` = ?, `cuisine` = ?, `peche` = ?, `secourisme` = ?, `commentaire` = ?, `etat` = ?, `last_maj` = ? WHERE guid = ?", array($money, $job1, $metier1, $job2, $metier2, $archeologie, $cuisine, $peche, $secourisme, $commentaire, $etat, $last_maj, $guid));
	}

	public function editEtat($cDB, $guid, $etat) {
		$last_maj = date("Y-m-d H:i:s");
		$comment = "";
		if ($etat == 8) { $comment = "Récup Invalide - Vous avez été remboursé, veuillez réefectuer celle-ci."; }
		if ($etat == 1) { $comment = "Récup Validée"; }
		$cDB->query("UPDATE character_recup SET `commentaire` = ?, `etat` = ?, `last_maj` = ? WHERE guid = ?", array($comment, $etat, $last_maj, $guid));
	}

	public function getDp($guid) {
		$this->db->select('dp')->from('account_data')->where(array('guid' => $guid));
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			$result = $query->result_array();
			return $result[0]['dp'];
		}
		else 
		{
			return "User inconnu !";
		}
	}

	public function getAccountIdFromGuid($cDB, $guid) {
		$query = $cDB->query("SELECT account FROM characters WHERE guid = ?", $guid);

		if($query->num_rows() > 0)
		{
			$result = $query->result_array();
			return $result[0]['account'];
		}
		else
		{
			return false;
		}
	}
}
