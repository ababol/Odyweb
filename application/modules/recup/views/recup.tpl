<script type="text/javascript">
	var alchimiste = "alchimiste";
	var calligraphe = "calligraphe";
	var enchanteur = "enchanteur";
	var ingenieur = "ingenieur";
	var forgeron = "forgeron";
	var herboriste = "herboriste";
	var depeceur = "depeceur";
	var joaillier = "joaillier";
	var mineur = "mineur";
	var travailleurducuir = "travailleurducuir";
	var couturier = "couturier";
	$(document).ready(function()
	{
		function initializeRecup()
		{
			if(typeof Recup != "undefined")
			{
				Recup.User.initialize({$vp}, {$dp});
			}
			else
			{
				setTimeout(initializeRecup, 50);
			}
		}

		initializeRecup();

		//Watch clicks on the add button
		var limitMax = 8,
			limitMin = 2;
		var imgAdd = $("#recup :input[name='recup_add']");
		imgAdd.click(function () {
	      if ($("#recup .file").length < limitMax) {
	      	var tmp = $("#recup .file:last").clone(true).insertAfter("#recup .file:last");
	      	tmp.find("input").val("");
	      }
		});
		var imgMin = $("#recup :input[name='recup_minus']");
		imgMin.click(function () {
			if ($("#recup .file").length > limitMin) {
	      		$("#recup .file:last").remove();
			}
		});

		var skillValue = $("#recup .skillValue");
		var moneyValue = $("#recup .moneyValue");
		var recupSelect = $('#recup  #recup_type_recup');
		var recupSelected = recupSelect.val();
		window.changeRecup = function(selection) {
			recupSelect.val(selection);
			if (selection === "argent") {
				moneyValue.html("/5000");
				skillValue.html("/525");
			} else {
				moneyValue.html("/3000");
				skillValue.html("/450");
			}
		}
		if (recupSelected === "argent") {
			changeRecup(recupSelected);
		}
		recupSelect.change(function() {
			changeRecup($(this).val());
		});
		{literal}$("#recup #recup_job1").val({/literal}{set_value('recup_job1')}{literal});
		$("#recup #recup_job2").val({/literal}{set_value('recup_job2')}{literal});{/literal}
	});
</script>

<section id="recup">

	{form_open_multipart('recup', 'class="page_form"')}
		<div id="message_error">{set_value('message_error')}</div>
		<table style="margin:0 auto;width:100%">
			<tr>
				<td style="width:50%";><label for="recup_type_recup"> Type de récupération :</label></td>
				<td class="form_fill">
					<select name="recup_type_recup" id="recup_type_recup" onChange="Recup.checkDp()">
						<option value="bronze">Bronze - Stuff vert 85, Skills jusqu'à 450, Gold jusqu'à 3000 - Gratuit</option>
						<option value="argent">Argent - Stuff bleue 85, Skills jusqu'à 525, Gold jusqu'à 5000 - 2DP</option>
						{if set_value('recup_type_recup') == "argent"}
							<script type="text/javascript">
								$(document).ready(function()
								{
									changeRecup("argent");
									//Recup.checkDp();
								});
							</script>
						{else}
							<script type="text/javascript">
								$(document).ready(function()
								{
									changeRecup("bronze");
								});
							</script>
						{/if}
					</select>
					<span id="type_recup_error">{$type_recup_error}</span>
				</td>
			</tr>

			<tr>
				<td class="form_fill"><label for="recup_perso"> Perso (peut avoir classe/race/nom différent) :</label></td>
				<td class="form_fill">
				{if $total}
					{foreach from=$characters item=realm}
						<select name="recup_perso" id="recup_perso" onChange="Recup.checkGuid()">
						{foreach from=$realm.characters item=character}
							{if $character.level < 5}
								<option value="{$character.guid}">{$character.name} - Niveau {$character.level}</option>
							{/if}
						{/foreach}
						</select>
					{/foreach}
				{else}
					<b style="color:red;">Vous n'avez pas de personnage avec un niveau inférieur à 5.</b>
				{/if}
					<span id="perso_error">{$perso_error}</span>
				</td>
			</tr>

			<tr>
				<td class="form_fill"><label for="recup_serveur"> Serveur d'origine :</label></td>
				<td class="form_fill">
					<input name="recup_serveur" type="text" id="recup_serveur" value="{set_value('recup_serveur')}" onChange="Recup.checkServeur()" />
					<span id="serveur_error">{$serveur_error}</span>
				</td>
			</tr>

			<tr>
			    <td class="form_fill"><label for="recup_money"> Gold (POs) :</label></td>
				<td class="form_fill">
					<input name="recup_money" type="text" id="recup_money" value="{if set_value('recup_money')>1000}{set_value('recup_money')}{else}1000{/if}" onChange="Recup.checkMoney()" /><span class="moneyValue">/3000</span>
					<span id="money_error">{$money_error}</span>
				</td>
			</tr>

			<tr>
			    <td class="form_fill"><label for="recup_job1"> Métier 1 :</label></td>
				<td class="form_fill">
					<select name="recup_job1" id="recup_job1" onChange="Recup.checkMetier('#recup_job1')">
						<option value="">Aucun</option>
						<option value="alchimiste">Alchimiste</option>
						<option value="couturier">Couture</option>
						<option value="depeceur">Dépeceur</option>
						<option value="enchanteur">Enchanteur</option>
						<option value="forgeron">Forge</option>
						<option value="herboriste">Herboriste</option>
						<option value="ingenieur">Ingénieur</option>
						<option value="joaillier">Joaillier</option>
						<option value="mineur">Mineur</option>
						<option value="travailleurducuir">Travail du cuir</option>
						<option value="calligraphe">Calligraphie</option>
					</select>
					<span id="job1_error">{$job1_error}</span>
				</td>
			</tr>

			<tr>
			    <td class="form_fill"><label for="recup_metier1"> Niveau métier 1 :</label></td>
				<td class="form_fill">
					<input name="recup_metier1" type="text" id="recup_metier1" value="{if set_value('recup_metier1')>0}{set_value('recup_metier1')}{else}0{/if}" onChange="Recup.checkSkill('#recup_metier1')" /><span class="skillValue">/450</span>
					<span id="metier1_error">{$metier1_error}</span>
				</td>
			</tr>

			<tr>
			    <td class="form_fill"><label for="recup_job2"> Métier 2 :</label></td>
				<td class="form_fill">
					<select name="recup_job2" id="recup_job2" onChange="Recup.checkMetier('#recup_job2')">
						<option value="">Aucun</option>
						<option value="alchimiste">Alchimiste</option>
						<option value="couturier">Couture</option>
						<option value="depeceur">Dépeceur</option>
						<option value="enchanteur">Enchanteur</option>
						<option value="forgeron">Forge</option>
						<option value="herboriste">Herboriste</option>
						<option value="ingenieur">Ingénieur</option>
						<option value="joaillier">Joaillier</option>
						<option value="mineur">Mineur</option>
						<option value="travailleurducuir">Travail du cuir</option>
						<option value="calligraphe">Calligraphie</option>
					</select>
					<span id="job2_error">{$job2_error}</span>
				</td>
			</tr>

			<tr>
			    <td class="form_fill"><label for="recup_metier2"> Niveau métier 2 :</label></td>
				<td class="form_fill">
					<input name="recup_metier2" type="text" id="recup_metier2" value="{if set_value('recup_metier2')>0}{set_value('recup_metier2')}{else}0{/if}" onChange="Recup.checkSkill('#recup_metier2')" /><span class="skillValue">/450</span>
					<span id="metier2_error">{$metier2_error}</span>
				</td>
			</tr>
			<tr>
			    <td class="form_fill"><label for="recup_archeologie"> Archéologie :</label></td>
				<td class="form_fill">
					<input name="recup_archeologie" type="text" id="recup_archeologie" value="{if set_value('recup_archeologie')>0}{set_value('recup_archeologie')}{else}0{/if}" onChange="Recup.checkSkill('#recup_archeologie')" /><span class="skillValue">/450</span>
					<span id="archeologie_error">{$archeologie_error}</span>
				</td>
			</tr>
			<tr>
			    <td class="form_fill"><label for="recup_cuisine"> Cuisine :</label></td>
				<td class="form_fill">
					<input name="recup_cuisine" type="text" id="recup_cuisine" value="{if set_value('recup_cuisine')>0}{set_value('recup_cuisine')}{else}0{/if}" onChange="Recup.checkSkill('#recup_cuisine')" /><span class="skillValue">/450</span>
					<span id="cuisine_error">{$cuisine_error}</span>
				</td>
			</tr>
			<tr>
			    <td class="form_fill"><label for="recup_peche"> Pêche :</label></td>
				<td class="form_fill">
					<input name="recup_peche" type="text" id="recup_peche" value="{if set_value('recup_peche')>0}{set_value('recup_peche')}{else}0{/if}" onChange="Recup.checkSkill('#recup_peche')" /><span class="skillValue">/450</span>
					<span id="peche_error">{$peche_error}</span>
				</td>
			</tr>
			<tr>
			    <td class="form_fill"><label for="recup_secourisme"> Secourisme :</label></td>
				<td class="form_fill">
					<input name="recup_secourisme" type="text" id="recup_secourisme" value="{if set_value('recup_secourisme')>0}{set_value('recup_secourisme')}{else}0{/if}" onChange="Recup.checkSkill('#recup_secourisme')" /><span class="skillValue">/450</span>
					<span id="secourisme_error">{$secourisme_error}</span>
				</td>
			</tr>
			<tr>
				<td class="form_fill"><label for="recup_armurerie"> Armurerie (si existe) :</label></td>
				<td class="form_fill">
					<input name="recup_armurerie" type="text" id="recup_armurerie" value="{set_value('recup_armurerie')}" onChange="Recup.checkUrl()" />
					<span id="armurerie_error">{$armurerie_error}</span>
				</td>
			</tr>

			<tr class="file" id="recup_file">
			    <td class="form_fill"><label for="recup_file">Image* : </label></td>
			    <td class="form_fill"><input type="file" name="userfile[]" id="recup_file" multiple accept="image/*"/></td>
			</tr>
			<tr class="file" id="recup_file">
			    <td class="form_fill"><label for="recup_file">Image* : </label></td>
			    <td class="form_fill"><input type="file" name="userfile[]" id="recup_file" multiple accept="image/*"/></td>
			</tr>
			<tr><td class="form_fill"><span id="upload_error">{$upload_error}</span></td><td class="form_fill"><input class="nice_button" name="recup_add" type="button" value="Une image en plus" /><input class="nice_button" name="recup_minus" type="button" value="Une image en moins" /></td></tr>
		</table>
		<div style="width:100%;"><center>
			{if $use_captcha}
				<br/><label for="captcha"><img src="{$url}application/modules/recup/controllers/getCaptcha.php?{uniqid()}" /></label><br/>
				<input style="width:150px;" type="text" name="recup_captcha" id="recup_captcha"/>
				<span id="captcha_error">{$captcha_error}</span><br/>
			{/if}
			<input type="submit" value="Envoyer" />
		</center></div>
	{form_close()}
	<div class="clear"></div>
</section>