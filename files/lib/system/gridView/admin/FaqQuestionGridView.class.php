<?php

namespace wcf\system\gridView\admin;

use Override;
use wcf\acp\form\FaqQuestionEditForm;
use wcf\data\category\CategoryNodeTree;
use wcf\data\DatabaseObjectList;
use wcf\data\faq\QuestionList;
use wcf\system\gridView\AbstractGridView;
use wcf\system\gridView\GridViewColumn;
use wcf\system\gridView\GridViewRowLink;
use wcf\system\gridView\renderer\CategoryColumnRenderer;
use wcf\system\gridView\renderer\NumberColumnRenderer;
use wcf\system\gridView\renderer\ObjectIdColumnRenderer;
use wcf\system\gridView\renderer\PhraseColumnRenderer;
use wcf\system\interaction\admin\FaqQuestionsInteractions;
use wcf\system\interaction\Divider;
use wcf\system\interaction\EditInteraction;
use wcf\system\interaction\FaqCopyInteraction;
use wcf\system\interaction\ToggleInteraction;
use wcf\system\view\filter\CategoryFilter;
use wcf\system\view\filter\I18nTextFilter;
use wcf\system\view\filter\IntegerFilter;
use wcf\system\view\filter\ObjectIdFilter;
use wcf\system\WCF;

final class FaqQuestionGridView extends AbstractGridView
{
    public function __construct()
    {
        $this->addColumns([
            GridViewColumn::for('questionID')
                ->label('wcf.global.objectID')
                ->renderer(new ObjectIdColumnRenderer())
                ->filter(ObjectIdFilter::class)
                ->sortable(),
            GridViewColumn::for('question')
                ->label('wcf.acp.faq.question.question')
                ->renderer(new PhraseColumnRenderer())
                ->filter(I18nTextFilter::class)
                ->titleColumn()
                ->sortable(),
            GridViewColumn::for('categoryID')
                ->label('wcf.global.category')
                ->renderer(new CategoryColumnRenderer())
                ->filter(
                    new CategoryFilter(
                        (new CategoryNodeTree('dev.tkirch.wsc.faq.category'))->getIterator(),
                        'categoryID',
                        'wcf.global.category'
                    )
                )
                ->sortable(),
            GridViewColumn::for('showOrder')
                ->label('wcf.global.showOrder')
                ->renderer(new NumberColumnRenderer())
                ->filter(IntegerFilter::class)
                ->sortable(),
        ]);

        $this->addAvailableFilter(
            new I18nTextFilter(
                'answer',
                'wcf.acp.faq.question.answer'
            )
        );

        $provider = new FaqQuestionsInteractions();
        $provider->addInteractions([
            new Divider(),
            new EditInteraction(FaqQuestionEditForm::class),
            new FaqCopyInteraction('copy'),
        ]);
        $this->setInteractionProvider($provider);

        $this->addQuickInteraction(
            new ToggleInteraction(
                'isDisabled',
                'hanashi/questions/%s/enable',
                'hanashi/questions/%s/disable',
            )
        );

        $this->addRowLink(
            new GridViewRowLink(
                FaqQuestionEditForm::class
            )
        );

        $this->setDefaultSortField('showOrder');
        $this->setDefaultSortOrder('ASC');
    }

    #[Override]
    protected function createObjectList(): DatabaseObjectList
    {
        return new QuestionList();
    }

    #[Override]
    public function isAccessible(): bool
    {
        return WCF::getSession()->getPermission('admin.faq.canViewQuestion');
    }
}
