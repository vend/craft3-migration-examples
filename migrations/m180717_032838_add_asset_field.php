<?php

namespace craft\contentmigrations;

use Craft;
use craft\db\Migration;

/**
 * m180717_032838_add_asset_field migration.
 */
class m180717_032838_add_asset_field extends Migration
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
        $headerImage = new \craft\fields\Assets([
            "groupId" => $group["id"],
            "name" => "Header Image",
            "handle" => "headerImage",
            "instructions" => "Choose or upload the header image",
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
            "localizeRelations" => "",
            "translationMethod" => "site",
            "translationKeyFormat" => null,
        ]);

        // Save the field
        Craft::$app->getFields()->saveField($headerImage);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        // Find the field
        $headerImage = Craft::$app->fields->getFieldByHandle("headerImage");

        // Delete the field if it exists
        if (!is_null($headerImage)) {
            Craft::$app->fields->deleteFieldById($headerImage->id);
        }
    }
}
