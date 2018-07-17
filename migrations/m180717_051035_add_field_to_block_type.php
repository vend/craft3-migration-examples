<?php

namespace craft\contentmigrations;

use Craft;
use craft\db\Migration;

/**
 * m180717_051035_add_field_to_block_type migration.
 */
class m180717_051035_add_field_to_block_type extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        // Get the matrix field
        $exampleContents = Craft::$app->fields->getFieldByHandle("exampleContents");

        // Get the block types
        $blockTypes = $exampleContents->getBlockTypes();

        // Find the one with `justText` as the handle
        foreach ($blockTypes as $blockType) {
            if ($blockType->handle == "justText") {
                // Get all the fields
                $fields = $blockType->getFields();

                // Add a new field to the fields array
                array_push(
                    $fields,

                    // Dropdown color select
                    new \craft\fields\Dropdown([
                        "name" => "Text Color",
                        "handle" => "textColor",
                        "instructions" => "Choose one of three amazing text colors",
                        "options" => [
                            [
                                "label" => "Red",
                                "value" => "#ff0000",
                                "default" => 1,
                            ], [
                                "label" => "Green",
                                "value" => "#00ff00",
                                "default" => "",
                            ], [
                                "label" => "Blue",
                                "value" => "#0000ff",
                                "default" => "",
                            ],
                        ],
                    ])
                );

                // And finally set the fields and then the blocktype
                $blockType->setFields($fields);
                return (Craft::$app->matrix->saveBlockType($blockType));
            }
        }
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

        // Find the one with `justText` as the handle
        foreach ($blockTypes as $blockType) {
            if ($blockType->handle == "justText") {
                // Get all the fields
                $fields = $blockType->getFields();

                // Find the field
                foreach ($fields as $field) {
                    if ($field->handle == "textColor") {
                        // And delete it
                        return (Craft::$app->fields->deleteFieldById($field->id));
                    }
                }
            }
        }

        return false;
    }
}
