<?php

namespace wcf\data\faq\category;

use wcf\data\category\Category;
use wcf\system\category\CategoryHandler;
use wcf\system\SingletonFactory;
use wcf\system\WCF;

final class FaqCategoryCache extends SingletonFactory
{
    /**
     * number of total questions
     * @var int[]
     */
    private array $questions;

    private function initQuestions(): void
    {
        $this->questions = [];

        $sql = "SELECT      COUNT(questionID) AS count,
                            categoryID
                FROM        wcf1_faq_questions
                GROUP BY    categoryID";
        $stmnt = WCF::getDB()->prepare($sql);
        $stmnt->execute();
        $contacts = $stmnt->fetchMap('categoryID', 'count');

        $categoryToParent = [];
        /** @var Category $category */
        foreach (CategoryHandler::getInstance()->getCategories(FaqCategory::OBJECT_TYPE_NAME) as $category) {
            if (!isset($categoryToParent[$category->parentCategoryID])) {
                $categoryToParent[$category->parentCategoryID] = [];
            }
            $categoryToParent[$category->parentCategoryID][] = $category->categoryID;
        }

        $this->countQuestions($categoryToParent, $contacts, 0);
    }

    /**
     *
     * @param array<int, list<int>> $categoryToParent
     * @param array<int, int> &$contacts
     * @param int $categoryID
     */
    private function countQuestions(array $categoryToParent, array &$contacts, int $categoryID): int
    {
        $count = (isset($contacts[$categoryID])) ? $contacts[$categoryID] : 0;
        if (isset($categoryToParent[$categoryID])) {
            foreach ($categoryToParent[$categoryID] as $childCategoryID) {
                $count += $this->countQuestions($categoryToParent, $contacts, $childCategoryID);
            }
        }

        if ($categoryID) {
            $this->questions[$categoryID] = $count;
        }

        return $count;
    }

    public function getQuestions(int $categoryID): int
    {
        if (!isset($this->questions)) {
            $this->initQuestions();
        }

        if (isset($this->questions[$categoryID])) {
            return $this->questions[$categoryID];
        }

        return 0;
    }
}
