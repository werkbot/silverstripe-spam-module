<?php

namespace Werkbot\SpamProtection;
/**/
use SilverStripe\Forms\TextField;
/**/
class TimerField extends TextField{
  /**/
  private static $time_not_bot = 10;
  /**
   * Adds in the requirements for the field
   * @param array $properties Array of properties for the form element (not used)
   * @return string Rendered field template
   */
  public function Field($properties=array()) {
    return parent::Field($properties);
  }
  /**/
  public function validate($validator) {
    //
    $Timer = (($this->config()->time_not_bot) ? $this->config()->time_not_bot : $this->time_not_bot);
    $CurrentTime = time();
    // Compare time difference with allowed time difference
    if ( empty($this->Value()) || !is_numeric($this->Value()) || (($CurrentTime - $this->Value()) < $Timer) ){
      // Not the expected value, set error
      $validator->validationError(
        $this->Name,
        _t('Werkbot\SpamProtection\Timer.INVALID', 'There was an error submitting this form. Please try again.')
      );
      return false;
    }
    //
    return true;
  }
  /**
   * @return array
   */
  public function getAttributes() {
    //
    $attributes = [
      'class' => 'wb-spam-hidden',
      'style' => 'height: 1px; opacity: 0; margin: 0;'
    ];
    //
    return array_merge(
      parent::getAttributes(),
      $attributes
    );
  }
}
