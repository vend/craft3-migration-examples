<?php

namespace craft\contentmigrations;

use Craft;
use craft\db\Migration;

/**
 * m180717_053947_update_field_instructions migration.
 */
class m180717_053947_update_field_instructions extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        // Get the intro text field
        $introText = Craft::$app->fields->getFieldByHandle("introText");

        // Change the instructions
        $introText->instructions = "Please enter a useful intro text here.";

        // Save the field
        return (Craft::$app->fields->saveField($introText));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "Skip migration as it is not revertable.\n";
        return true;
    }
}
