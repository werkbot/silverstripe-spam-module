<?php

namespace Werkbot\SpamProtection\Forms;

use SilverStripe\Forms\TextField;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Core\Injector\Injector;

class TimerField extends TextField
{
  /**
   * @config
   */
  private static $time_not_bot = 10;
  /**
   * Adds in the requirements for the field
   * @param array $properties Array of properties for the form element (not used)
   * @return string Rendered field template
   */
  public function Field($properties = array())
  {
    return parent::Field($properties);
  }

  public function validate($validator)
  {
    $Attributes = $this->getAttributes();
    $Request = Injector::inst()->get(HTTPRequest::class);
    $Session = $Request->getSession();

    $Timer = ((isset($Attributes['data-rule-customtime'])) ? $Attributes['data-rule-customtime'] : (($this->config()->time_not_bot) ? $this->config()->time_not_bot : $this->time_not_bot));
    $CurrentTime = time();

    // Compare time difference with allowed time difference
    if ((empty($this->Value()) || !is_numeric($this->Value()) || (($CurrentTime - $this->Value()) < $Timer))) {
      if (!$Session->get('spam-protection-error-exists')) {
        // Set Session
        $Session->set('spam-protection-error-exists', true);

        if(isset($Attributes['data-custommsg']) && $Attributes['data-custommsg'] <> ""){
          $validator->validationError(
            $this->Name,
            $Attributes['data-custommsg']
          );
        } else {
          $validator->validationError(
            $this->Name,
            _t('Werkbot\SpamProtection\Timer.INVALID', 'There was an error submitting this form. Please try again.')
          );
        }
      }
      return false;
    }

    return true;
  }

  /**
   * @return array
   */
  public function getAttributes()
  {
    $attributes = [
      'class' => 'wb-spam-hidden',
      'style' => 'height: 1px; opacity: 0; margin: 0;'
    ];

    return array_merge(
      parent::getAttributes(),
      $attributes
    );
  }

}

