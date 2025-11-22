<?php

namespace wcf\system\endpoint\controller\hanashi\questions;

use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use wcf\data\faq\Question;
use wcf\data\faq\QuestionList;
use wcf\system\cache\builder\FaqQuestionListCacheBuilder;
use wcf\system\endpoint\IController;
use wcf\system\endpoint\PostRequest;
use wcf\system\showOrder\ShowOrderHandler;
use wcf\system\showOrder\ShowOrderItem;
use wcf\system\WCF;

#[PostRequest('/hanashi/questions/show-order')]
final class ChangeShowOrder implements IController
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

        $sortedItems = (new ShowOrderHandler($items))->getSortedItemsFromRequest($request);
        $this->saveShowOrder($sortedItems);

        return new JsonResponse([]);
    }

    /**
     * @param list<ShowOrderItem> $items
     */
    private function saveShowOrder(array $items): void
    {
        WCF::getDB()->beginTransaction();
        $sql = "UPDATE  wcf1_faq_questions
                SET     showOrder = ?
                WHERE   questionID = ?";
        $statement = WCF::getDB()->prepare($sql);
        for ($i = 0, $length = \count($items); $i < $length; $i++) {
            $statement->execute([
                $i + 1,
                $items[$i]->id,
            ]);
        }
        WCF::getDB()->commitTransaction();

        FaqQuestionListCacheBuilder::getInstance()->reset();
    }
}
