<?php
/**/
namespace Werkbot\SpamProtection;
/**/
use SilverStripe\Forms\FieldGroup;
use SilverStripe\SpamProtection\SpamProtector;
/**/
class HoneypotProtector implements SpamProtector {
  /**
   * Return the Field(S) that we will use in this protector
   * @return FieldGroup of Honeypot and Timer fields
   */
  public function getFormField($name="_email", $title="This field should be left empty", $value=null) {
    // Send both Honeypot and Timer Fields
    return FieldGroup::create(
      HoneypotField::create($name, $title, $value)->addExtraClass('wb-spam-hidden'),
      TimerField::create("time", $title, time())->addExtraClass('wb-spam-hidden')
    );
  }
  /**
   * Not used by Honeypot
   */
  public function setFieldMapping($fieldMapping) {}
}
