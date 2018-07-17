<?php

namespace craft\contentmigrations;

use Craft;
use craft\db\Migration;

/**
 * m180717_042412_add_matrix_field migration.
 */
class m180717_042412_add_matrix_field extends Migration
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

        // Get the folder to save files to
        $v = Craft::$app->volumes->getVolumeByHandle("siteAssets");
        $folders = Craft::$app->assets->getFolderTreeByVolumeIds([$v->id]);
        $folder = "folder:" . $folders[0]->id;

        // Initialize the field
        $contentMatrix = new \craft\fields\Matrix([
            "groupId" => $group["id"],
            "name" => "Example Contents",
            "handle" => "exampleContents",
            "instructions" => "Add some dynamic contents to the page",
            "translationMethod" => "site",
            "translationKeyFormat" => null,
            "minBlocks" => "",
            "maxBlocks" => "",
            "blockTypes" => [
                // Text block
                new \craft\models\MatrixBlockType([
                    "name" => "Just Text",
                    "handle" => "justText",
                    "fields" => [
                        // Content
                        new \craft\fields\PlainText([
                            "name" => "Text Content",
                            "handle" => "textContent",
                            "instructions" => "The content of this block",
                            "required" => true,
                            "placeholder" => "Type here...",
                            "charLimit" => "",
                            "multiline" => true,
                            "initialRows" => "4",
                        ]),
                    ],
                ]),

                // Image and text block
                new \craft\models\MatrixBlockType([
                    "name" => "Image and Text",
                    "handle" => "imageAndText",
                    "fields" => [
                        // Image
                        new \craft\fields\Assets([
                            "name" => "Image",
                            "handle" => "image",
                            "instructions" => "Choose or upload an image",
                            "required" => true,
                            "restrictFiles" => true,
                            "allowedKinds" => ["image"],
                            "limit" => 1,
                            "viewMode" => "list",
                            "selectionLabel" => "Select Image",
                            "defaultUploadLocationSource" => $folder,
                            "defaultUploadLocationSubpath" => "",
                            "sources" => [$folder],
                            "source" => null,
                        ]),

                        // Description
                        new \craft\fields\PlainText([
                            "name" => "Description",
                            "handle" => "decription",
                            "instructions" => "The description of this image",
                            "required" => true,
                            "placeholder" => "Type here...",
                            "charLimit" => 100,
                            "multiline" => false,
                            "initialRows" => "1",
                        ]),
                    ],
                ]),
            ],
        ]);

        return (Craft::$app->fields->saveField($contentMatrix));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        // Find the field
        $contentMatrix = Craft::$app->fields->getFieldByHandle("exampleContents");

        // Delete it
        return (Craft::$app->fields->deleteFieldById($contentMatrix->id));
    }
}
