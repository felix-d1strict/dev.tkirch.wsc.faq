<?php

namespace wcf\system\endpoint\controller\hanashi\questions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use wcf\data\faq\Question;
use wcf\data\faq\QuestionList;
use wcf\system\endpoint\GetRequest;
use wcf\system\endpoint\IController;
use wcf\system\showOrder\ShowOrderHandler;
use wcf\system\showOrder\ShowOrderItem;
use wcf\system\WCF;

#[GetRequest('/hanashi/questions/show-order')]
final class GetShowOrder implements IController
{
    public function __invoke(ServerRequestInterface $request, array $variables): ResponseInterface
    {
        WCF::getSession()->checkPermissions(['admin.faq.canAddQuestion']);

        $questionList = new QuestionList();
        $questionList->sqlOrderBy = 'showOrder ASC';
        $questionList->readObjects();

        $items = \array_map(
            static fn (Question $question) => new ShowOrderItem($question->questionID, $question->getTitle()),
            $questionList->getObjects()
        );

        return (new ShowOrderHandler($items))->toJsonResponse();
    }
}
