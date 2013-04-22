<?php

class Admin extends MX_Controller
{
	public function __construct()
	{
		// Make sure to load the administrator library!
		$this->load->library('administrator');
		$this->load->model('recup_model');
		$this->load->library('form_validation');

		parent::__construct();

		requirePermission("canViewAdmin");
	}

	public function index()
	{
		// Change the title
		$this->administrator->setTitle("Recup List");

		$etat = $this->input->get("etat");
		if (!$etat) {
			$etat = 0;
		}
		$page = $this->input->get("page");
		if (!$page) {
			$page = 0;
		}
		if ($page < 0) {
			$page = 0;
		}
		
		$recup_list = $this->recup_model->getRecupList($this->realms->getRealm(1)->getCharacters()->getConnection(), $etat, $page);
			
		// Prepare my data
		$data = array(
			'url' => $this->template->page_url,
			'recup_list' => $recup_list,
			'realms' => $this->realms->getRealms()
		);

		// Load my view
		$output = $this->template->loadPage("recup_admin.tpl", $data);

		// Put my view in the main box with a headline
		$content = $this->administrator->box('Recup List', $output);

		// Output my content. The method accepts the same arguments as template->view
		$this->administrator->view($content, "modules/recup/css/recup_admin.css", "modules/recup/js/recup_admin.js");
	}

	public function edit($id = false)
	{
		// Check for the permission
		requirePermission("canEdit");

		if(!is_numeric($id) || !$id)
		{
			die();
		}
		
		$recup = $this->recup_model->getRecup($this->realms->getRealm(1)->getCharacters()->getConnection(), $id);
		
		if(!$recup)
		{
			show_error("Il n'y a pas de récup avec ce GUID ".$id);

			die();
		}
		
		// Change the title
		$this->administrator->setTitle($this->realms->getRealm(1)->getCharacters()->getNameByGuid($recup['guid']));
			
		// Prepare my data
		$data = array(
			'url' => $this->template->page_url,
			'recup' => $recup,
			'realms' => $this->realms->getRealms(),
			"money_error" => "",
			"job1_error" => "",
			"metier1_error" => "",
			"job2_error" => "",
			"metier2_error" => "",
			"archeologie_error" => "",
			"cuisine_error" => "",
			"peche_error" => "",
			"secourisme_error" => "",
			"commentaire_error" => "",
			"etatSelect_error" => ""
		);

		// Load my view
		$output = $this->template->loadPage("recup_admin_edit.tpl", $data);

		// Put my view in the main box with a headline
		$content = $this->administrator->box('<a href="'.$this->template->page_url.'recup/admin">Recup Lists</a> &rarr; '.$this->realms->getRealm(1)->getCharacters()->getNameByGuid($recup['guid']), $output);

		// Output my content. The method accepts the same arguments as template->view
		$this->administrator->view($content, false, "modules/recup/js/recup_admin.js");
	}

	public function save($id = false)
	{
		// Check for the permission
		requirePermission("canEdit");

		if(!$id || !is_numeric($id))
		{
			die();
		}

		$this->form_validation->set_rules('money', 'money', 'trim|required|min_length[0]|max_length[4]|xss_clean|integer|less_than[10001]|greater_than[-1]');;
		$this->form_validation->set_rules('job1', 'job1', 'trim|required|min_length[3]|max_length[20]|xss_clean|alpha');
		$this->form_validation->set_rules('metier1', 'metier1', 'trim|required|min_length[0]|max_length[3]|xss_clean|integer|less_than[526]|greater_than[-1]');
		$this->form_validation->set_rules('job2', 'job2', 'trim|required|min_length[3]|max_length[20]|xss_clean|alpha');
		$this->form_validation->set_rules('metier2', 'metier2', 'trim|required|min_length[0]|max_length[3]|xss_clean|integer|less_than[526]|greater_than[-1]');
		$this->form_validation->set_rules('archeologie', 'archeologie', 'trim|required|min_length[0]|max_length[3]|xss_clean|integer|less_than[526]|greater_than[-1]');
		$this->form_validation->set_rules('cuisine', 'cuisine', 'trim|required|min_length[0]|max_length[3]|xss_clean|integer|less_than[526]|greater_than[-1]');
		$this->form_validation->set_rules('peche', 'peche', 'trim|required|min_length[0]|max_length[3]|xss_clean|integer|less_than[526]|greater_than[-1]');
		$this->form_validation->set_rules('secourisme', 'secourisme', 'trim|required|min_length[0]|max_length[3]|xss_clean|integer|less_than[526]|greater_than[-1]');
		$this->form_validation->set_rules('commentaire', 'commentaire', 'trim|min_length[0]|max_length[255]|xss_clean');
		$this->form_validation->set_rules('etatSelect', 'etatSelect', 'trim|required|min_length[1]|max_length[1]|xss_clean|integer|less_than[10]|greater_than[-1]');;
		$this->form_validation->set_error_delimiters('<img src="'.$this->template->page_url.'application/images/icons/exclamation.png" data-tip="', '" />');
		if($this->form_validation->run() == FALSE)
		{
			die("Formulaire invalide, erreur de valeur. On coupe court à la transaction !");
		} else {
			$this->recup_model->edit($this->realms->getRealm(1)->getCharacters()->getConnection(), $id, $this->input->post("money"), $this->input->post("job1"), $this->input->post("metier1"), $this->input->post("job2"), $this->input->post("metier2"), 
			$this->input->post("archeologie"), $this->input->post("cuisine"), $this->input->post("peche"),	$this->input->post("secourisme"), $this->input->post("etatSelect"), $this->input->post("commentaire"));

			//header("Location: ".$this->template->page_url.'recup/admin');
			die('<script>window.location="'.$this->template->page_url.'recup/admin"</script>');
		}
	}

	public function refund()
	{
		// Check for the permission
		requirePermission("canRefund");

		$id = intval($this->input->get("id"));
		$costDp = intval($this->input->get("costDp"));
		$accountId = intval($this->input->get("accountId"));
		
		if(!$id || !is_numeric($id))
		{
			die();
		}

		if ($costDp != "Free") {
			if(!$costDp || !is_numeric($costDp))
			{
				die();
			}
		}

		if(!$accountId || !is_numeric($accountId))
		{
			die();
		}

		if ($costDp != "Free") {
			if ($costDp > 0) {
				$userDp = intval($this->recup_model->getDp($accountId));
				if(!$userDp || !is_numeric($userDp))
				{
					die("Problème lors de l'acquisition des users dps.");
				}
				$this->internal_user_model->setDp($accountId, $userDp+$costDp);
			}
		}
		$this->recup_model->editEtat($this->realms->getRealm(1)->getCharacters()->getConnection(), $id, 8);
	}

	public function validate($id = false)
	{
		// Check for the permission
		requirePermission("canValidate");
		
		if(!$id || !is_numeric($id))
		{
			die();
		}

		$this->recup_model->editEtat($this->realms->getRealm(1)->getCharacters()->getConnection(), $id, 1);
	}
}