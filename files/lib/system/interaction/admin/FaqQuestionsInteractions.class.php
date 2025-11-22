<?php

namespace wcf\system\interaction\admin;

use Override;
use wcf\data\faq\Question;
use wcf\event\interaction\admin\FaqQuestionsInteractionCollecting;
use wcf\system\event\EventHandler;
use wcf\system\interaction\AbstractInteractionProvider;
use wcf\system\interaction\DeleteInteraction;

final class FaqQuestionsInteractions extends AbstractInteractionProvider
{
    public function __construct()
    {
        $this->addInteractions([
            new DeleteInteraction("hanashi/questions/%s"),
        ]);

        EventHandler::getInstance()->fire(
            new FaqQuestionsInteractionCollecting($this)
        );
    }

    #[Override]
    public function getObjectClassName(): string
    {
        return Question::class;
    }
}
