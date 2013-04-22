{$head}
	<body>
		<!--[if lte IE 8]>
			<style type="text/css">
				body {
					background-image:url(images/bg.jpg);
					background-position:top center;
				}
			</style>
		<![endif]-->
		<header id="fixMenu">
			<ul id="left_menu">
				{foreach from=$menu_side item=menu_2}
					<li><a {$menu_2.link}><img src="{$image_path}bullet.png">{$menu_2.name}</a></li>
				{/foreach}
			</ul>
		</header>
		<div id="websiteContainer">
			<div id="logo"></div>
			<ul id="top_menu">
				<li><a href="armurerie" class="armurerie"></a></li>
				<li><a href="commun" class="communaute"></a></li>
				<li><a href="aaventure" class="aventure"></a></li>
				<li><a href="store.php" class="boutique"></a></li>
				<li><a href="supprot.php" class="support"></a></li>
			</ul>
			<section id="slider_bg" {if !$show_slider}style="display:none;"{/if}>
				<div id="slider">
					{foreach from=$slider item=image}
						<a href="{$image.link}"><img src="{$image.image}" title="{$image.text}"/></a>
					{/foreach}
				</div>
			</section>
			<section id="wrapper">
				{$modals}
				<div id="main">

					<aside id="left">

						{$page}
					</aside>
					<aside id="right">
						<article>
							<h1 class="top">Main menu</h1>
						</article>

						{foreach from=$sideboxes item=sidebox}
							<article>
								<h1 class="top">{$sidebox.name}</h1>
								<section class="body">
									{$sidebox.data}
								</section>
							</article>
						{/foreach}
					</aside>

					<div class="clear"></div>
				</div>
			</div>
			<footer>
				<p>&copy; Copyright 2012 {$serverName}</p>
			</footer>
		</section>
	</body>
</html>