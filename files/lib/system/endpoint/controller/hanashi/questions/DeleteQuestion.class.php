<?php

namespace wcf\system\endpoint\controller\hanashi\questions;

use Laminas\Diactoros\Response\JsonResponse;
use Override;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use wcf\data\faq\Question;
use wcf\data\faq\QuestionAction;
use wcf\http\Helper;
use wcf\system\endpoint\DeleteRequest;
use wcf\system\endpoint\IController;
use wcf\system\WCF;

#[DeleteRequest("/hanashi/questions/{id:\\d+}")]
final class DeleteQuestion implements IController
{
    #[Override]
    public function __invoke(ServerRequestInterface $request, array $variables): ResponseInterface
    {
        $question = Helper::fetchObjectFromRequestParameter($variables['id'], Question::class);

        WCF::getSession()->checkPermissions(['admin.faq.canAddQuestion']);

        (new QuestionAction([$question], 'delete'))->executeAction();

        return new JsonResponse([]);
    }
}
