var Recup = {
	
	/**
	 * General identifier used on #{ID}_count, #add_{ID}, #{ID}_list and #main_{ID}
	 */
	identifier: "recup",

	/**
	 * The ID of the fusionEditor (like "#news_content"), if any, otherwise put false
	 */
	fusionEditor: false,

	/**
	 * Links for the ajax requests
	 */
	Links: {
		refund: "recup/admin/refund/",
		save: "recup/admin/save/",
		validate: "recup/admin/validate/"
	},

	refund: function(id, accountId, costDp, element)
	{
		var identifier = this.identifier,
			refundLink = this.Links.refund;

		UI.confirm("Êtes-vous sûr de vouloir rembourser ce péon ?", "Oui", function()
		{
			$("#" + identifier + "_count").html(parseInt($("#" + identifier + "_count").html()) - 1);

			$(element).parents("tr").slideUp(300, function()
			{
				$(this).remove();
			});

			$.get(Config.URL + refundLink + "?id=" + id + "&accountId=" + accountId + "&costDp=" + costDp);
		});
	},

	/**
	 * Submit the form contents to the save link
	 * @param Object form
	 */
	save: function(form, id)
	{
		var values = {csrf_token_name: Config.CSRF};

		$(form).find("input, select").each(function()
		{
			if($(this).attr("type") != "submit")
			{
				values[$(this).attr("name")] = $(this).val();
			}
		});

		if(this.fusionEditor != false)
		{
			values[this.fusionEditor.replace("#", "")] = $(this.fusionEditor).html();
		}

		$.post(Config.URL + this.Links.save + id, values, function(data)
		{
			$("html").html(data);
		});
	},

	validate: function(id, element)
	{
		var identifier = this.identifier,
			validateLink = this.Links.validate;

		UI.confirm("Êtes-vous sûr de vouloir accepter cette récup ?", "Oui", function()
		{
			$("#" + identifier + "_count").html(parseInt($("#" + identifier + "_count").html()) - 1);

			$(element).parents("tr").slideUp(300, function()
			{
				$(this).remove();
			});

			$.get(Config.URL + validateLink + id);
		});
	}
}