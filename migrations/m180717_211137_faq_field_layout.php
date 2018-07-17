<?php

namespace craft\contentmigrations;

use Craft;
use craft\db\Migration;

/**
 * m180717_211137_faq_field_layout migration.
 */
class m180717_211137_faq_field_layout extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        // Get the entry
        $section = Craft::$app->sections->getSectionByHandle("exampleFAQ");
        $entries = $section->getEntryTypes();
        $faqEntry = $entries[0];

        // Update the entry settings to auto generate the title from the question
        $faqEntry->hasTitleField = false;
        $faqEntry->titleFormat = "{exampleFaqQuestion}";

        // Get the current field layout
        $fieldLayout = $faqEntry->getFieldLayout();

        // FAQ Tab
        $faqTab = new \craft\models\FieldLayoutTab(["name" => "FAQ"]);
        // Select the fields for question and answer
        $question = Craft::$app->fields->getFieldByHandle("exampleFaqQuestion");
        $answer = Craft::$app->fields->getFieldByHandle("exampleFaqAnswer");

        // Set the fields
        $faqTab->setFields([$question, $answer]);

        // Set the tabs on the field layout
        $fieldLayout->setTabs([$faqTab]);

        // And finally save the new entry settings and field layout
        return (Craft::$app->fields->saveLayout($fieldLayout) && Craft::$app->sections->saveEntryType($faqEntry));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        // Get the entry
        $section = Craft::$app->sections->getSectionByHandle("exampleFAQ");
        $entries = $section->getEntryTypes();
        $faqEntry = $entries[0];

        // Get the current field layout
        $fieldLayout = $faqEntry->getFieldLayout();

        // set the field layout to null
        $fieldLayout->setTabs([]);

        // And save it
        return (Craft::$app->fields->saveLayout($fieldLayout));
    }
}
