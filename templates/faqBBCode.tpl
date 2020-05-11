<blockquote class="faqBBcodeBox collapsibleBbcode jsCollapsibleBbcode{if $collapseQuestion} collapsed{/if}">
	<div class="faqBBcodeBoxIcon">
        <span class="faqBBcodeBoxFaqSymbol"></span>
	</div>
	
	<div class="faqBBcodeBoxTitle">
		<span class="faqBBcodeBoxTitle">
            FAQ: {$question->getTitle()}
		</span>
	</div>
	
	<div class="faqBBcodeBoxContent">
		{@$question->getFormattedOutput()}
	</div>
	
	{if $collapseQuestion}
		<span class="toggleButton" data-title-collapse="{lang}wcf.bbcode.button.collapse{/lang}" data-title-expand="{lang}wcf.bbcode.button.showAll{/lang}">{lang}wcf.bbcode.button.showAll{/lang}</span>
		
		{if !$__overlongBBCodeBoxSeen|isset}
			{assign var='__overlongBBCodeBoxSeen' value=true}
			<script data-relocate="true">
				require(['WoltLabSuite/Core/Bbcode/Collapsible'], function(BbcodeCollapsible) {
					BbcodeCollapsible.observe();
				});
			</script>
		{/if}
	{/if}
</blockquote>
