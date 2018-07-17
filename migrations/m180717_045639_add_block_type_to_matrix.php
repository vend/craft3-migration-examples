<?php

namespace craft\contentmigrations;

use Craft;
use craft\db\Migration;

/**
 * m180717_045639_add_block_type_to_matrix migration.
 */
class m180717_045639_add_block_type_to_matrix extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        // Get the matrix field
        $exampleContents = Craft::$app->fields->getFieldByHandle("exampleContents");

        // Initialize the block type
        $table = new \craft\models\MatrixBlockType([
            "fieldId" => $exampleContents->id,
            "name" => "Opening hours",
            "handle" => "openingHours",
            "fields" => [
                // Table
                new \craft\fields\Table([
                    "name" => "Table",
                    "handle" => "openingHoursTable",
                    "columns" => [
                        "col1" => [
                            "heading" => "Day",
                            "handle" => "day",
                            "type" => "singleline",
                        ],
                        "col2" => [
                            "heading" => "Opening Hours",
                            "handle" => "openingHours",
                            "type" => "singleline",
                        ],
                    ],
                ]),
            ],
        ]);

        return (Craft::$app->matrix->saveBlockType($table));
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

        // Find the one with `openingHours` as the handle
        foreach ($blockTypes as $blockType) {
            if ($blockType->handle == "openingHours") {
                // And delete it
                return (Craft::$app->matrix->deleteBlockType($blockType));
            }
        }

        return false;
    }
}
