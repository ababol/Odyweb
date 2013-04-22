<?php

class Recup extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		
		//Make sure that we are logged in
		$this->user->is_logged_in();

		//Load url and form library
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');

		$this->load->config('captcha');

		$this->load->model('recup_model');

		//Init the variables
		$this->init();
	}

	/**
	 * Init every variable
	 */
	private function init()
	{
		$this->characters = $this->user->getCharacters($this->user->getId());

		$this->total = 0;
		$counter = 0;

		foreach($this->characters as $realm)
		{
			if($realm['characters'] && $realm['characters'][$counter]['level'] < 5)
			{
				$this->total += count($realm['characters']);
				$counter++;
			}
		}
	}
	

	public function index()
	{
		$argentDp = 2;
		$bronzeDp = 0;
		$costDp = $bronzeDp;
		$upload_errors = "";
		$jobError = "";
		$enoughDp = true;
		$job = true;

		$this->template->setTitle("Recup de Perso");

		//Load the form validations for if they tried to sneaky bypass our js system
		$this->form_validation->set_rules('recup_type_recup', 'type_recup', 'trim|required|min_length[5]|max_length[6]|xss_clean|alpha');
		$this->form_validation->set_rules('recup_perso', 'perso', 'trim|required|min_length[1]|max_length[10]|xss_clean|numeric');
		$this->form_validation->set_rules('recup_serveur', 'serveur', 'trim|required|min_length[3]|max_length[32]|xss_clean|alpha_numeric');
		$this->form_validation->set_rules('recup_money', 'money', 'trim|required|min_length[0]|max_length[4]|xss_clean|integer|less_than[5001]|greater_than[-1]');
		$this->form_validation->set_rules('recup_job1', 'job1', 'trim|required|min_length[3]|max_length[20]|xss_clean|alpha');
		$this->form_validation->set_rules('recup_metier1', 'metier1', 'trim|required|min_length[0]|max_length[3]|xss_clean|integer|less_than[526]|greater_than[-1]');
		$this->form_validation->set_rules('recup_job2', 'job2', 'trim|required|min_length[3]|max_length[20]|xss_clean|alpha');
		$this->form_validation->set_rules('recup_metier2', 'metier2', 'trim|required|min_length[0]|max_length[3]|xss_clean|integer|less_than[526]|greater_than[-1]');
		$this->form_validation->set_rules('recup_archeologie', 'archeologie', 'trim|required|min_length[0]|max_length[3]|xss_clean|integer|less_than[526]|greater_than[-1]');
		$this->form_validation->set_rules('recup_cuisine', 'cuisine', 'trim|required|min_length[0]|max_length[3]|xss_clean|integer|less_than[526]|greater_than[-1]');
		$this->form_validation->set_rules('recup_peche', 'peche', 'trim|required|min_length[0]|max_length[3]|xss_clean|integer|less_than[526]|greater_than[-1]');
		$this->form_validation->set_rules('recup_secourisme', 'secourisme', 'trim|required|min_length[0]|max_length[3]|xss_clean|integer|less_than[526]|greater_than[-1]');
		$this->form_validation->set_rules('recup_armurerie', 'armurerie', 'trim|min_length[0]|max_length[255]|xss_clean');

		$this->form_validation->set_error_delimiters('<img src="'.$this->template->page_url.'application/images/icons/exclamation.png" data-tip="', '" />');

		require_once('application/libraries/captcha.php');

		$captchaObj = new Captcha($this->config->item('use_captcha'));
		if ($this->input->post("recup_type_recup") == "argent") {
			$costDp = $argentDp;
			if ($this->user->getDp()-$argentDp < 0) {
				$enoughDp = false;
			}
		}
		if (!isset($_FILES['userfile'])) {
			$cpt = 0;
			$upload_errors = "Vous devez au moins upload 2 fichiers !";
		} else {
		    $cpt = count($_FILES['userfile']['name']);
		    if ($cpt < 2) {
				$upload_errors = "Vous devez au moins upload 2 fichiers !";
		    }
		}

		if ($this->input->post("recup_job1") == $this->input->post("recup_job2")) {
			$job = false;
			$jobError = "Les deux métiers principaux doivent être différents.";
		}

		//Check if everything went correct
		if($this->form_validation->run() == FALSE
			|| strtoupper($this->input->post('recup_captcha')) != strtoupper($captchaObj->getValue())
			|| !count($_POST)
			|| !$enoughDp
			|| !$job
			|| $cpt < 2)
		{				
			$data = $this->getErrors($upload_errors, $jobError);
			$this->displayErrors($data, $captchaObj);
		}
		else
		{
			if($this->input->post("recup_type_recup") != false)
			{
				if($this->input->post("recup_type_recup") != "bronze")
				{
					if($this->input->post("recup_type_recup") != "argent") {
						die("Vilain, ne modifies pas les valeurs de select à l'avenir !");
					} else {
						$type = 2;
					}
				} else {
					$type = 1;
				}
			}

			if ($type == 1) {
				if ($this->input->post("recup_money") > 3000) {
					die("La limite de gold est fixé à 3000.");
				}
				if ($this->input->post("recup_metier1") > 450) {
					die("La limite de métier est fixé à 450.");
				}
				if ($this->input->post("recup_metier2") > 450) {
					die("La limite de métier est fixé à 450.");
				}
				if ($this->input->post("recup_cuisine") > 450) {
					die("La limite de métier est fixé à 450.");
				}
				if ($this->input->post("recup_peche") > 450) {
					die("La limite de métier est fixé à 450.");
				}
				if ($this->input->post("recup_secourisme") > 450) {
					die("La limite de métier est fixé à 450.");
				}
				if ($this->input->post("recup_archeologie") > 450) {
					die("La limite de métier est fixé à 450.");
				}
			}

			$accountRecup = $this->recup_model->getAccountIdFromGuid($this->realms->getRealm(1)->getCharacters()->getConnection(), $this->input->post("recup_perso"));
			if ($accountRecup) {
				if ($accountRecup != $this->user->getId()) {
					die("Personnage choisi erroné.");
				}
			} else {
				die("Problème lors de la récupération du personnage, veuillez recommencer.");
			}

			$repertoire = './demandes/recups/' . md5($this->input->post("recup_perso"))  . '/';
			if (!is_dir($repertoire)) {
				mkdir ( $repertoire, 0777 );
			}
			if (!$this->do_upload($this->input->post("recup_perso"), $cpt, $costDp, $captchaObj)) {
				die("Problème lors de l'upload de vos photos, veuillez recommencer.");
			}
			if ($type == 2) {
				$this->user->setDp($this->user->getDp() - $costDp);
			}

			$this->recup_model->add($this->realms->getRealm(1)->getCharacters()->getConnection(), $this->input->post("recup_perso"), $this->user->getId(), $this->input->post("recup_serveur"), $this->input->post("recup_money"), $this->input->post("recup_job1"), $this->input->post("recup_metier1"),
				$this->input->post("recup_job2"), $this->input->post("recup_metier2"), $this->input->post("recup_archeologie"), $this->input->post("recup_cuisine"), $this->input->post("recup_peche"), $this->input->post("recup_secourisme"),
				$this->input->post("recup_armurerie"), $type, $costDp);

			$title = "Recup de perso envoyé !";
			$this->template->view($this->template->box($title, $this->template->loadPage("recup_success.tpl")));
		}
	}


	private function do_upload($guid, $cpt, $costDp, $captchaObj)
	{
	    $this->load->library('upload');

	    $files = $_FILES;
	    for($i=0; $i<$cpt; $i++)
	    {
	        $_FILES['userfile']['name']= $files['userfile']['name'][$i];
	        $_FILES['userfile']['type']= $files['userfile']['type'][$i];
	        $_FILES['userfile']['tmp_name']= $files['userfile']['tmp_name'][$i];
	        $_FILES['userfile']['error']= $files['userfile']['error'][$i];
	        $_FILES['userfile']['size']= $files['userfile']['size'][$i];
		    $this->upload->initialize($this->set_upload_options($guid));
			if ( ! $this->upload->do_upload())
			{
				$error = $this->getErrors($this->upload->display_errors());
				$this->recup_model->del($this->realms->getRealm(1)->getCharacters()->getConnection(), $guid);
				$this->user->setDp($this->user->getDp() + $costDp);
				$this->displayErrors($error, $captchaObj);
				return false;
			}
	    }
	    return true;
	}

	private function set_upload_options($guid)
	{   
	//  upload an image options
	    $config = array();
		$config['upload_path'] = './demandes/recups/' . md5($guid)  . '/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
		$config['max_size']	= '2000';
		$config['max_width']  = '2600';
		$config['max_height']  = '2600';
	    $config['overwrite']     = TRUE;


	    return $config;
	}

	private function getErrors($upload_errors, $jobError = "") {
		return array(
			"date" => date("Y-m-d"),
			"vp" => $this->user->getVp(),
			"dp" => $this->user->getDp(),
			"id" => $this->user->getId(),
			"type_recup_error" => "",
			"perso_error" => "",
			"money_error" => "",
			"serveur_error" => "",
			"job1_error" => $jobError,
			"metier1_error" => "",
			"job2_error" => $jobError,
			"metier2_error" => "",
			"archeologie_error" => "",
			"cuisine_error" => "",
			"peche_error" => "",
			"secourisme_error" => "",
			"armurerie_error" => "",
			"use_captcha" => $this->config->item('use_captcha'),
			"captcha_error" => "",
			"upload_error" => $upload_errors,
			"characters" => $this->characters,
			"total" => $this->total,
		);
	}

	private function displayView($error) {
		$this->template->view($this->template->loadPage("page.tpl", array(
			"module" => "default", 
			"headline" => "Recup Perso", 
			"content" => $this->template->loadPage("recup.tpl", $error),
		)), "modules/recup/css/recup.css", "modules/recup/js/recup.js", "Recup de Perso");
	}

	private function displayErrors($data, $captchaObj) {
		$fields = array('type_recup', 'perso', 'serveur', 'money', 'job1', 'metier1', 'job2', 'metier2', 'cuisine', 'peche', 'secourisme', 'archeologie', 'armurerie');

		if(count($_POST) > 0)
		{
			// Loop through fields and assign error or success image
			foreach($fields as $field)
			{
				if(strlen(form_error('recup_' . $field)) == 0 && empty($data[$field."_error"]))
				{
					$data[$field."_error"] = '<img src="'.$this->template->page_url.'application/images/icons/accept.png" />';
				}
				elseif(empty($data[$field."_error"]))
				{
					$data[$field."_error"] = form_error('recup_' . $field);
				}
			}

			if($this->input->post('recup_captcha') != $captchaObj->getValue())
			{
				$data['captcha_error'] = '<img src="'.$this->template->page_url.'application/images/icons/exclamation.png" />';
			}
		}

		// If not then display our page again
		$this->displayView($data);
	}
}