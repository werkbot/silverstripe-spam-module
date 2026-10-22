<?php

namespace Werkbot\SpamProtection\Forms;

use Override;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Core\Validation\ValidationResult;
use SilverStripe\Forms\TextField;

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
  #[Override]
  public function Field($properties = [])
  {
    return parent::Field($properties);
  }

  #[Override]
  public function validate(): ValidationResult
  {
    $validationResult = parent::validate();
    $Attributes = $this->getAttributes();
    $Request = Injector::inst()->get(HTTPRequest::class);
    $Session = $Request->getSession();

    $Timer = ($Attributes['data-rule-customtime'] ?? (($this->config()->time_not_bot ?: $this->time_not_bot)));
    $CurrentTime = time();

    // Compare time difference with allowed time difference
    if ((empty($this->Value()) || !is_numeric($this->Value()) || (($CurrentTime - $this->Value()) < $Timer))) {
      if (!$Session->get('spam-protection-error-exists')) {
        // Set Session
        $Session->set('spam-protection-error-exists', true);

        if(isset($Attributes['data-custommsg']) && $Attributes['data-custommsg'] <> ""){
          $validationResult->addFieldError(
            $this->Name,
            $Attributes['data-custommsg']
          );
        } else {
          $validationResult->addFieldError(
            $this->Name,
            _t('Werkbot\SpamProtection\Timer.INVALID', 'There was an error submitting this form. Please try again.')
          );
        }
      }
    }

    return $validationResult;
  }

  /**
   * @return array
   */
  #[Override]
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

