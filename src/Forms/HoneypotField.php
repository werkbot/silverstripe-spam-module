<?php

namespace Werkbot\SpamProtection\Forms;

use Override;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Core\Validation\ValidationResult;
use SilverStripe\Forms\TextField;

class HoneypotField extends TextField
{
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
    $form = $this->getForm();
    $attributes = $form->FormAttributes();
    $StringID = explode(" ", $attributes);
    $ID = substr($StringID[0], strrpos($StringID[0], '_') + 1);
    $ID = rtrim($ID, '"');

    $Attributes = $this->getAttributes();
    $Request = Injector::inst()->get(HTTPRequest::class);
    $Session = $Request->getSession();

    if (!empty($this->Value())) {
      if (!$Session->get('spam-protection-error-exists')) {
        $Session->set('spam-protection-error-exists', true);
        // Add custom error message
        if(isset($Attributes['data-custommsg']) && $Attributes['data-custommsg'] <> ""){
          $validationResult->addFieldError(
            $this->Name,
            $Attributes['data-custommsg']
          );
          if (intval($ID !== 0)) {
            $form->sessionMessage($Attributes['data-custommsg'], 'bad');
          }
        } else {
          // Not expecting any value
          $validationResult->addFieldError(
            $this->Name,
            _t('Werkbot\SpamProtection\Honeypot.INVALID', 'There was an error submitting this form. Please try again.')
          );
          if (intval($ID !== 0)) {
            $form->sessionMessage(_t('Werkbot\SpamProtection\Honeypot.INVALID', 'There was an error submitting this form. Please try again.'), 'bad');
          }
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

