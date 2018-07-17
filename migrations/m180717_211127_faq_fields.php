<?php

namespace craft\contentmigrations;

use Craft;
use craft\db\Migration;

/**
 * m180717_211127_faq_fields migration.
 */
class m180717_211127_faq_fields extends Migration
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

        // Initialize the question
        $questionField = new \craft\fields\PlainText([
            "groupId" => $group["id"],
            "name" => "Question",
            "handle" => "exampleFaqQuestion",
            "instructions" => "Question to be answered",
            "required" => true,
            "placeholder" => "Type here...",
            "charLimit" => 150,
            "multiline" => false,
            "initialRows" => "1",
            "translationMethod" => "site",
            "translationKeyFormat" => null,
        ]);

        // Initialize the answer
        $answerField = new \craft\fields\PlainText([
            "groupId" => $group["id"],
            "name" => "Answer",
            "handle" => "exampleFaqAnswer",
            "instructions" => "Answer to the question",
            "required" => true,
            "placeholder" => "Type here...",
            "charLimit" => "",
            "multiline" => true,
            "initialRows" => "4",
            "translationMethod" => "site",
            "translationKeyFormat" => null,
        ]);

        // Save the fields
        return (Craft::$app->getFields()->saveField($questionField) && Craft::$app->getFields()->saveField($answerField));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        // Find the field
        $question = Craft::$app->fields->getFieldByHandle("exampleFaqQuestion");
        $answer = Craft::$app->fields->getFieldByHandle("exampleFaqAnswer");

        // Delete the question field if exists
        if (!is_null($question)) {
            Craft::$app->fields->deleteFieldById($question->id);
        }

        // Delete the answer field if exists
        if (!is_null($answer)) {
            Craft::$app->fields->deleteFieldById($answer->id);
        }
    }
}
