<?php
namespace wcf\system\category;
use wcf\system\WCF;

class FAQCategoryType extends AbstractCategoryType {
    
    /**
	 * @inheritDoc
	 */
	protected $forceDescription = false;
	
    /**
	 * @inheritDoc
	 */
	protected $hasDescription = false;

    /**
	 * @inheritDoc
	 */
	protected $maximumNestingLevel = 0;
    
    /**
	 * @inheritDoc
	 */
    protected $langVarPrefix = 'wcf.faq.category';
    
    /**
	 * @inheritDoc
	 */
	protected $permissionPrefix = 'admin.faq';

	/**
	 * @inheritDoc
	 */
	protected $objectTypes = ['com.woltlab.wcf.acl' => 'dev.tkirch.wsc.faq.category'];
}