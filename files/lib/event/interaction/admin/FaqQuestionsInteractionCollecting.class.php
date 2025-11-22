<?php

namespace wcf\event\interaction\admin;

use wcf\event\IPsr14Event;
use wcf\system\interaction\admin\FaqQuestionsInteractions;

final class FaqQuestionsInteractionCollecting implements IPsr14Event
{
    public function __construct(public readonly FaqQuestionsInteractions $provider)
    {
    }
}
