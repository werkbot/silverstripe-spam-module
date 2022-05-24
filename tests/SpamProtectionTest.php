<?php
/**/
namespace Werkbot\SpamProtection;
/**/
use SilverStripe\Core\Config\Config;
use SilverStripe\Dev\FunctionalTest;
use SilverStripe\UserForms\Control\UserDefinedFormController;
use SilverStripe\UserForms\Model\UserDefinedForm;
/*
    Run with:
    vendor/bin/phpunit vendor/werkbot/werkbot-spam-protection/tests/SpamProtectionTest.php
*/
class SpamProtectionTest extends FunctionalTest
{
    /*
        Runs once before any tests
    */
    public static function setUpBeforeClass() : void
    {
        parent::setUpBeforeClass();

        Config::inst()->update(TimerField::class, 'time_not_bot', 1);
    }

    public function testEditableTimerField()
    {
        $form = UserDefinedForm::create();
        $form->write();
        $form->publishRecursive();

        $field = EditableTimerField::create([
            'ParentID' => $form->ID,
            'ParentClass' => $form->ClassName,
        ]);
        $field->write();
        $field->publishRecursive();

        // Get timer value
        $this->get($form->Link());
        $formData = (new UserDefinedFormController($form))->form()->getData();

        // Submit form
        $this->post($form->Link('Form'), $formData);
        $this->assertPartialMatchBySelector('.error', 'There was an error submitting this form. Please try again.', 'Editable timer field did not prevent bot submission.');
        echo PHP_EOL . ' - Confirmed editable timer field prevents bot submissions' . PHP_EOL;

        // Get timer value
        $this->get($form->Link());
        $formData = (new UserDefinedFormController($form))->form()->getData();

        // Wait a couple of seconds
        sleep(2);

        // Submit form
        $this->post($form->Link('Form'), $formData);
        $this->assertPartialMatchBySelector('p', 'Thanks, we\'ve received your submission.', 'Editable timer field did not allow "human" submission.');
        echo PHP_EOL . ' - Confirmed editable timer field allows "human" submissions' . PHP_EOL;
    }
}