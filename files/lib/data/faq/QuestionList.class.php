<?php

namespace wcf\data\faq;

use wcf\data\DatabaseObjectList;

/**
 * @extends DatabaseObjectList<Question>
 */
final class QuestionList extends DatabaseObjectList
{
    /**
     * @inheritDoc
     */
    public $sqlOrderBy = 'showOrder, questionID';
}
