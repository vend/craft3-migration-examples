<?php

namespace craft\contentmigrations;

use Craft;
use craft\db\Migration;

/**
 * m180717_195352_add_entry_type_example_page_variant migration.
 */
class m180717_195352_add_entry_type_example_page_variant extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        // Get the section
        $section = Craft::$app->sections->getSectionByHandle("examplePages");

        // Initialize entry type
        $exampleVariant = new \craft\models\EntryType([
            "sectionId" => $section->id,
            "name" => "Example Page Variant",
            "handle" => "examplePageVariant",
            "hasTitleField" => true,
            "titleLabel" => "Example Page Title",
        ]);

        return (Craft::$app->sections->saveEntryType($exampleVariant));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $section = Craft::$app->sections->getSectionByHandle("examplePages");
        $exampleVariants = Craft::$app->sections->getEntryTypesByHandle("examplePageVariant");
        $exampleVariant = $exampleVariants[0];

        return (Craft::$app->sections->deleteEntryType($exampleVariant));
    }
}
