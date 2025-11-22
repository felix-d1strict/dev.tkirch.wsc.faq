<?php

namespace wcf\system\endpoint\controller\hanashi\questions;

use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use wcf\data\faq\Question;
use wcf\data\faq\QuestionAction;
use wcf\http\Helper;
use wcf\system\endpoint\IController;
use wcf\system\endpoint\PostRequest;
use wcf\system\exception\PermissionDeniedException;
use wcf\system\WCF;

#[PostRequest("/hanashi/questions/{id:\\d+}/disable")]
final class DisableQuestion implements IController
{
    public function __invoke(ServerRequestInterface $request, array $variables): ResponseInterface
    {
        $question = Helper::fetchObjectFromRequestParameter($variables['id'], Question::class);

        WCF::getSession()->checkPermissions(['admin.faq.canAddQuestion']);
        if ($question->isDisabled) {
            throw new PermissionDeniedException();
        }

        (new QuestionAction([$question], 'toggle'))->executeAction();

        return new JsonResponse([]);
    }
}
