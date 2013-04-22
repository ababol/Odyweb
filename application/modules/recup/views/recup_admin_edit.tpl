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
		var comment = $('#commentaire');
		var etatSelect = $('#etatSelect');
		var etatSelected = etatSelect.val();
		var changeEtat = function(selection) {
			if (selection == 0) {
				comment.val("En Attente de Validation");
			}
			etatSelect.val(selection);
			if (selection == 8) {
				comment.val("Récup Invalide - Veuillez la refaire");
			}
			if (selection == 9) {
				comment.val("Récup Validée");
			}
		}
		etatSelect.change(function() {
			changeEtat($(this).val());
		});
		{literal}$("#job1").val({/literal}{$recup.job1}{literal});
		$("#job2").val({/literal}{$recup.job2}{literal});
		changeEtat({/literal}{$recup.etat}{literal});{/literal}
	});
</script>
<section class="box big">
	<h2>Validate Recup</h2>
	<form onSubmit="Recup.save(this, {$recup.guid}); return false" id="submit_form">
		<label for="money">Pos</label>
		<input type="text" name="money" id="money" value="{$recup.money}"/>
		<span id="money_error">{$money_error}</span>

		<label for="job1">Métier 1</label>
		<select name="job1" id="job1">
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

		<label for="metier1">Niveau 1</label>
		<input type="text" name="metier1" id="metier1" value="{$recup.metier1}"/>
		<span id="metier1_error">{$metier1_error}</span>

		<label for="job2">Métier 2</label>
		<select name="job2" id="job2">
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

		<label for="metier2">Niveau 2</label>
		<input type="text" name="metier2" id="metier2" value="{$recup.metier2}"/>
		<span id="metier2_error">{$metier2_error}</span>

		<label for="archeologie">Archéologie</label>
		<input type="text" name="archeologie" id="archeologie" value="{$recup.archeologie}"/>
		<span id="archeologie_error">{$archeologie_error}</span>

		<label for="cuisine">Cuisine</label>
		<input type="text" name="cuisine" id="cuisine" value="{$recup.cuisine}"/>
		<span id="cuisine_error">{$cuisine_error}</span>

		<label for="peche">Pêche</label>
		<input type="text" name="peche" id="peche" value="{$recup.peche}"/>
		<span id="peche_error">{$peche_error}</span>

		<label for="secourisme">Secourisme</label>
		<input type="text" name="secourisme" id="secourisme" value="{$recup.secourisme}"/>
		<span id="secourisme_error">{$secourisme_error}</span>

		<label for="etatSelect">Etat</label>
		<select id="etatSelect" name="etatSelect">
			<option value="0">A validé</option>
			<option value="1">Valider</option>
			<option value="8">Invalide</option>
		</select>
		<span id="etatSelect_error">{$etatSelect_error}</span>

		<label for="commentaire">Commentaire</label>
		<input type="text" name="commentaire" id="commentaire" value="{$recup.commentaire}"/>
		<span id="commentaire_error">{$commentaire_error}</span>
		
		<input type="submit" value="Save Recup" />
	</form>
</section>