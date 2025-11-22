<?php

namespace wcf\acp\page;

use Override;
use wcf\page\AbstractGridViewPage;
use wcf\system\gridView\AbstractGridView;
use wcf\system\gridView\admin\FaqQuestionGridView;
use wcf\system\WCF;

final class FaqQuestionListPage extends AbstractGridViewPage
{
    /**
     * @inheritDoc
     */
    public $activeMenuItem = 'wcf.acp.menu.link.faq.questions.list';

    /**
     * @inheritDoc
     */
    public $neededPermissions = ['admin.faq.canViewQuestion'];

    public int $showFaqAddDialog = 0;

    #[Override]
    public function readParameters()
    {
        parent::readParameters();

        if (!empty($_REQUEST['showFaqAddDialog'])) {
            $this->showFaqAddDialog = 1;
        }
    }

    #[Override]
    protected function createGridView(): AbstractGridView
    {
        return new FaqQuestionGridView();
    }

    #[Override]
    public function assignVariables()
    {
        parent::assignVariables();

        WCF::getTPL()->assign([
            'showFaqAddDialog' => $this->showFaqAddDialog,
        ]);
    }
}
