<?php

namespace wcf\system\interaction;

use wcf\acp\form\FaqQuestionAddForm;
use wcf\data\DatabaseObject;
use wcf\data\faq\Question;
use wcf\system\request\LinkHandler;
use wcf\system\WCF;

final class FaqCopyInteraction extends AbstractInteraction
{
    public function render(DatabaseObject $object): string
    {
        \assert($object instanceof Question);

        return \sprintf(
            '<a href="%s" class="jsTooltip">%s</a>',
            LinkHandler::getInstance()->getControllerLink(
                FaqQuestionAddForm::class,
                [
                    'duplicateID' => $object->questionID,
                    'isMultilingual' => $object->isMultilingual,
                ]
            ),
            WCF::getLanguage()->get('wcf.acp.faqQuestion.copy')
        );
    }
}
