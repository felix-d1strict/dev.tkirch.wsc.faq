{include file='header' pageTitle='wcf.acp.menu.link.faq.questions.list'}

<header class="contentHeader">
	<div class="contentHeaderTitle">
		<h1 class="contentTitle">{lang}wcf.acp.menu.link.faq.questions.list{/lang}</h1>
	</div>

	<nav class="contentHeaderNavigation">
		<ul>
			{if $gridView->countRows() > 1}
				<li>
					<button type="button" class="button jsChangeShowOrder">{icon name='up-down'} <span>{lang}wcf.global.changeShowOrder{/lang}</span></button>
				</li>
			{/if}
			<li><a href="{link controller='FaqQuestionAdd'}{/link}" class="button">{icon name='plus' size=16} <span>{lang}wcf.acp.menu.link.faq.questions.add{/lang}</span></a></li>

			{event name='contentHeaderNavigation'}
		</ul>
	</nav>
</header>

<div class="section">
    {unsafe:$gridView->render()}
</div>

<script data-relocate="true">
	require(["WoltLabSuite/Core/Component/ChangeShowOrder"], ({ setup }) => {
		{jsphrase name='wcf.global.changeShowOrder'}

		setup(
			document.querySelector('.jsChangeShowOrder'),
			'hanashi/questions/show-order',
		);
	});
</script>

{include file='faqQuestionAddDialog'}

{include file='footer'}
