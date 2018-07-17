<?php

namespace craft\contentmigrations;

use Craft;
use craft\db\Migration;

/**
 * m180717_014246_add_text_field migration.
 */
class m180717_014246_add_text_field extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        // Get the group
        $group = (new \craft\db\Query())
            ->select("id")
            ->from("fieldgroups")
            ->where(["name" => "Example Group"])
            ->one();

        // Initialize the field
        $introField = new \craft\fields\PlainText([
            "groupId" => $group["id"],
            "name" => "Intro Text",
            "handle" => "introText",
            "instructions" => "Intro text for this page",
            "required" => true,
            "placeholder" => "Type here...",
            "charLimit" => 300,
            "multiline" => true,
            "initialRows" => "4",
            "translationMethod" => "site",
            "translationKeyFormat" => null,
        ]);

        // Save the field
        return (Craft::$app->getFields()->saveField($introField));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        // Find the field
        $introField = Craft::$app->fields->getFieldByHandle("introText");

        // Delete it
        return (Craft::$app->fields->deleteFieldById($introField->id));
    }
}
