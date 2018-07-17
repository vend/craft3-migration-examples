<?php

namespace craft\contentmigrations;

use Craft;
use craft\db\Migration;

/**
 * m180717_200834_example_page_field_layout migration.
 */
class m180717_200834_example_page_field_layout extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        // Get the entry
        $section = Craft::$app->sections->getSectionByHandle("examplePages");
        $entries = Craft::$app->sections->getEntryTypesByHandle("examplePages");
        $examplePageEntry = $entries[0];

        // Get the current field layout
        $fieldLayout = $examplePageEntry->getFieldLayout();

        // TOP TAB
        $topTab = new \craft\models\FieldLayoutTab(["name" => "Top Part"]);
        // Select all the fields for the top tab
        $headerImage = Craft::$app->fields->getFieldByHandle("headerImage");
        $introText = Craft::$app->fields->getFieldByHandle("introText");
        // Set the fields
        $topTab->setFields([$headerImage, $introText]);

        // BODY TAB
        $bodyTab = new \craft\models\FieldLayoutTab(["name" => "Body Part"]);
        // Select the exampleContents matrix for the body tab
        $exampleContents = Craft::$app->fields->getFieldByHandle("exampleContents");
        // Set the fields
        $bodyTab->setFields([$exampleContents]);

        // Set the tabs on the field layout
        $fieldLayout->setTabs([$topTab, $bodyTab]);

        // And finally save the field layout
        return (Craft::$app->fields->saveLayout($fieldLayout));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        // Get the entry
        $section = Craft::$app->sections->getSectionByHandle("examplePages");
        $entries = Craft::$app->sections->getEntryTypesByHandle("examplePages");
        $examplePageEntry = $entries[0];

        // Get the current field layout
        $fieldLayout = $examplePageEntry->getFieldLayout();

        // set the field layout to null
        $fieldLayout->setTabs([]);

        // And save it
        return (Craft::$app->fields->saveLayout($fieldLayout));
    }
}
