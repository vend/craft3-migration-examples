<?php

namespace craft\contentmigrations;

use Craft;
use craft\db\Migration;

/**
 * m180717_214112_faq_entry_matrix_block migration.
 */
class m180717_214112_faq_entry_matrix_block extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        // Get the matrix field
        $exampleContents = Craft::$app->fields->getFieldByHandle("exampleContents");

        // Grab the section with the questions
        $questionsSection = Craft::$app->sections->getSectionByHandle("exampleFAQ");

        // Initialize the block type
        $faqBlockType = new \craft\models\MatrixBlockType([
            "fieldId" => $exampleContents->id,
            "name" => "Frequently Asked Questions",
            "handle" => "faqs",
            "fields" => [
                // Questions field
                new \craft\fields\Entries([
                    "name" => "Questions",
                    "handle" => "questions",
                    "instructions" => "Choose one or more questions",
                    "sources" => ["section:" . $questionsSection->id],
                    "limit" => 10,
                    "required" => false,
                    "selectionLabel" => "Select Questions",
                ]),
            ],
        ]);

        return (Craft::$app->matrix->saveBlockType($faqBlockType));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        // Get the matrix field
        $exampleContents = Craft::$app->fields->getFieldByHandle("exampleContents");

        // Get the block types
        $blockTypes = $exampleContents->getBlockTypes();

        // Find the one with `faqs` as the handle
        foreach ($blockTypes as $blockType) {
            if ($blockType->handle == "faqs") {
                // And delete it
                return (Craft::$app->matrix->deleteBlockType($blockType));
            }
        }

        return false;
    }
}
