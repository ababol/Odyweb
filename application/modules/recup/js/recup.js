var Recup = {

	User: {

		vp: null,
		dp: null,

		initialize: function(vp, dp)
		{
			this.vp = vp;
			this.dp = dp;
		}
	},

	recupSelected: $('#recup #recup_type_recup'),

	/**
	 * Mark the field as valid
	 * @param String field
	 */
	valid: function(field)
	{
		var field = $(field.replace("recup_", "") + "_error");
		
		field.html('<img src="' + Config.URL + 'application/images/icons/accept.png" />');
	},

	/**
	 * Mark the field as invalid
	 * @param String field
	 * @param String error
	 */
	invalid: function(field, error)
	{
		var field = $(field.replace("recup_", "") + "_error");

		if(error.length > 0)
		{
			field.html('<img src="' + Config.URL + 'application/images/icons/exclamation.png" data-tip="' + error + '" />');
			Tooltip.refresh();
		}
		else
		{
			field.html('<img src="' + Config.URL + 'application/images/icons/exclamation.png" />');
		}
	},

	/**
	 * Show loading image
	 * @param String field
	 */
	ajax: function(field, error)
	{
		var field = $(field.replace("recup_", "") + "_error");
		
		field.html('<img src="' + Config.image_path + 'ajax_small.gif" />');
		
	},

	checkDp : function() {
		var field_name = '#recup_type_recup',
			field = this.recupSelected,
			value = field.val(),
			check = true,
			argentDp = 2,
			manque = this.User.dp;

		if (field.val() === "argent") {
			manque -= argentDp;
			if (manque < 0) {
				this.invalid(field_name, "Vous n'avez pas assez de DP."+" Il vous manque "+-manque+" DPs.");
				check = false;
			}
		}

		if (check) {
			this.ajax(field_name);
			Recup.valid(field_name);
		}
	},

	/**
	 * Validate Guid
	 */
	checkGuid: function()
	{
		var field_name = '#recup_perso',
			field = $(field_name),
			value = field.val();

		// Length check
		if(value.length > 10)
		{
			this.invalid(field_name, "Guid trop élevé.");
		}
		// Alpha check
		else if(!/^[0-9]+$/i.test(value))
		{
			this.invalid(field_name, "Guid pas en num !");
		}

		// Availability check
		else
		{
			this.ajax(field_name);
			Recup.valid(field_name);
		}
	},

	checkMetier: function(el)
	{
		var field_name = el,
			field = $(field_name),
			value = field.val();

		// Length check
		if(value.length > 18)
		{
			this.invalid(field_name, "Vous avez changé le select.");
		}
		// Alpha check
		else if(!/^[a-z]+$/i.test(value))
		{
			this.invalid(field_name, "Vous avez changé le select.");
		}
		else if($('#recup_job1').val() === $('#recup_job2').val()) {
			this.invalid(field_name, "Les 2 métiers sélectionnés doivent être différents.")
		}

		// Availability check
		else
		{
			this.ajax(field_name);

			Recup.valid(field_name);
		}
	},

	/**
	 * Validate text
	 */
	checkServeur: function()
	{
		var field_name = '#recup_serveur',
			field = $(field_name),
			value = field.val();

		// Length check
		if(value.length < 3 || value.length > 32)
		{
			this.invalid(field_name, "Must be between 3 and 32 characters long");
		}

		// Availability check
		else
		{
			this.ajax(field_name);

			Recup.valid(field_name);
		}
	},


	/**
	 * Validate username
	 */
	checkMoney: function()
	{
		var field_name = "#recup_money",
			field = $(field_name),
			value = field.val();


		// Length check
		if(value.length > 4)
		{
			this.invalid(field_name, "Ne doit pas contenir plus de 4 chiffres.");
		}
		// Alpha-numeric check
		else if(!/^[0-9]+$/i.test(value))
		{
			this.invalid(field_name, "Doit être composé de chiffres seulement.");
		}

		// Availability check
		else
		{
			var check = true;
			value = parseInt(value);
			if (this.recupSelected.val() === "argent") {
				if(value > 5000) {
					this.invalid(field_name, "Doit être <= 5000.");
					check = false;
				}
			} else {
				if(value > 3000) {
					this.invalid(field_name, "Doit être <= 3000.");
					check = false;
				}
			}
			if (check) {
				this.ajax(field_name);

				Recup.valid(field_name);
			}
		}
	},

	/**
	 * Validate username
	 */
	checkSkill: function(el)
	{
		var field_name = el,
			field = $(field_name),
			value = field.val();

		// Length check
		if(value.length > 3)
		{
			this.invalid(field_name, "Ne doit pas contenir plus de 3 chiffres.");
		}
		// Alpha-numeric check
		else if(!/^[0-9]+$/i.test(value))
		{
			this.invalid(field_name, "Doit être composé de chiffres seulement.");
		}

		// Availability check
		else
		{
			var check = true;
			value = parseInt(value);
			if (this.recupSelected.val() === "argent") {
				if(value > 525) {
					this.invalid(field_name, "Doit être <= 525.");
					check = false;
				}
			} else {
				if(value > 450) {
					this.invalid(field_name, "Doit être <= 450.");
					check = false;
				}
			}
			if (check) {
				this.ajax(field_name);

				Recup.valid(field_name);
			}
		}
	},

	checkUrl: function() {
		var field_name = '#recup_armurerie',
			field = $(field_name),
			value = field.val(),
			noCheck = false,
			urlregex = null;

		if (value != "") {
	    	var urlregex = new RegExp("^(http|https|ftp)\://([a-zA-Z0-9\.\-]+(\:[a-zA-Z0-9\.&amp;%\$\-]+)*@)*((25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9])\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[0-9])|([a-zA-Z0-9\-]+\.)*[a-zA-Z0-9\-]+\.(com|edu|gov|int|mil|net|org|biz|arpa|info|name|pro|aero|coop|museum|[a-zA-Z]{2}))(\:[0-9]+)*(/($|[a-zA-Z0-9\.\,\?\'\\\+&amp;%\$#\=~_\-]+))*$");
	    } else {
	    	noCheck = true;
	    }

		this.invalid(field_name, "URL invalide");

	    if (noCheck || urlregex.test(value)) {
	    	if (value.length < 256) {
				this.ajax(field_name);
				Recup.valid(field_name);
			}
	    }
	}
}