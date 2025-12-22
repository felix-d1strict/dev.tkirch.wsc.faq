<?php

namespace wcf\system\attachment;

use Override;
use wcf\data\faq\Question;
use wcf\system\WCF;

/**
 * @extends AbstractAttachmentObjectType<Question>
 */
final class FaqQuestionAttachmentObjectType extends AbstractAttachmentObjectType
{
    #[Override]
    public function canDownload($objectID)
    {
        return true;
    }

    #[Override]
    public function canUpload($objectID, $parentObjectID = 0)
    {
        return WCF::getSession()->getPermission('admin.faq.canAddQuestion');
    }

    #[Override]
    public function canDelete($objectID)
    {
        return WCF::getSession()->getPermission('admin.faq.canDeleteQuestion');
    }
}
