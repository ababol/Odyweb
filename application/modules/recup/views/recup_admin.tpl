{if isset($smarty.get.page)}
     {$page = $smarty.get.page}
{else}
    {$page = 0}
{/if}
{if isset($smarty.get.etat)}
     {$etat = $smarty.get.etat}
{else}
    {$etat = 0}
{/if}
Voir les récups : <a href="/fusion/recup/admin/?etat=0">En Attente de Validation</a> | <a href="/fusion/recup/admin/?etat=8">Invalide</a> | <a href="/fusion/recup/admin/?etat=1">Validée</a> | <a href="/fusion/recup/admin/?etat=9">Fermée</a><br/>
<center><a href="/fusion/recup/admin/?etat={$etat}&page={$page-1}">Page Précédente</a> | <a href="/fusion/recup/admin/?etat={$etat}&page={$page+1}">Page Suivante</a></center>
<section class="box big" id="main_recup">
	<h2>
		<img src="{$url}application/themes/admin/images/icons/black16x16/ic_picture.png"/>
		Nombre Recups (<div style="display:inline;" id="recup_count">{if !$recup_list}0{else}{count($recup_list)}{/if}</div>)
	</h2>

	<div id="recup_list">
		{if $recup_list}
			<table width="100%">
				<tr>
					<th>Type</th>
					<th>DPs</th>
					<th>Jou.</th>
					<th>Account</th>
					<th>Serveur</th>
					<th>Niv.</th>
					<th>POs</th>
					<th>IP</th>
					<th>Job 1</th>
					<th>Skill 1</th>
					<th>Job 2</th>
					<th>Skill 2</th>
					<th>Archéologie</th>
					<th>Cuisine</th>
					<th>Pêche</th>
					<th>Secourisme</th>
					<th>Armurerie</th>
					<th>Créée le</th>
					<th>Last Maj le</th>
					<th>Commentaire</th>
					<th>Etat</th>
					<th>Screens</th>
				</tr>
				{foreach from=$recup_list item=recup}
				<tr>
					<td>{$recup.type}</td>
					<td>
						{if $recup.costDp}
							<img src="{$url}application/images/icons/coins.png" style="opacity:1;margin-top:3px;position:absolute;"/> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							{$recup.costDp} DP
						{else}
							Free
						{/if}
					</td>
					<td><b>{$recup.name}</b></td>
					<td><b>{$recup.account}</b></td>
					<td>{$recup.serveur}</td>
					<td>{$recup.level}</td>
					<td>{$recup.money}</td>
					<td>{$recup.ip}</td>
					<td>{$recup.job1}</td>
					<td>{$recup.metier1}</td>
					<td>{$recup.job2}</td>
					<td>{$recup.metier2}</td>
					<td>{$recup.archeologie}</td>
					<td>{$recup.cuisine}</td>
					<td>{$recup.peche}</td>
					<td>{$recup.secourisme}</td>
					<td>{$recup.armurerie}</td>
					<td>{$recup.date_creation}</td>
					<td>{$recup.last_maj}</td>
					<td>{$recup.commentaire}</td>
					<td>{$recup.etat}</td>
					<td><a target="_blank" href="http://localhost/fusion/demandes/recups/index.php?id={$recup.guid|md5}">Lien Dossier</a></td>
					<td style="text-align:right;">
						{if hasPermission("canEdit")}
						<a href="{$url}recup/admin/edit/{$recup.guid}" data-tip="Editer"><img src="{$url}application/themes/admin/images/icons/black16x16/ic_edit.png" /></a>&nbsp;
						{/if}
						{if hasPermission("canRefund")}
							<a href="javascript:void(0)" onClick="Recup.refund({$recup.guid}, {$recup.account}, {$recup.costDp}, this)" data-tip="Rembourser"><img alt="Rembourser" src="{$url}application/themes/admin/images/icons/black16x16/ic_sync.png" /></a>
						{/if}

						{if hasPermission("canValidate")}
							<a href="javascript:void(0)" onClick="Recup.validate({$recup.guid}, this)" data-tip="Valider"><img "Valider" src="{$url}application/themes/admin/images/icons/black16x16/ic_ok.png" /></a>
						{/if}
					</td>
				</tr>
				{/foreach}
			</table>
		{/if}
	</div>
</section>