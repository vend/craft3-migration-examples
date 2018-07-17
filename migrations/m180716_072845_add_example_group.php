<?php

namespace craft\contentmigrations;

use Craft;
use craft\db\Migration;

/**
 * m180716_072845_add_example_group migration.
 */
class m180716_072845_add_example_group extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $group = new \craft\models\FieldGroup([
            "name" => "Example Group",
        ]);

        // Save the group
        Craft::$app->fields->saveGroup($group);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $group = (new \craft\db\Query())
            ->select("id")
            ->from("fieldgroups")
            ->where(["name" => "Example Group"])
            ->one();

        // Delete the group
        Craft::$app->fields->deleteGroupById($group["id"]);
    }
}
