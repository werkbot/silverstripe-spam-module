<?php

namespace Werkbot\SpamProtection;

use SilverStripe\Forms\TextField;
use SilverStripe\Control\Controller;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\ORM\ValidationResult;
use SilverStripe\Core\Injector\Injector;

class HoneypotField extends TextField
{
  /**
   * Adds in the requirements for the field
   * @param array $properties Array of properties for the form element (not used)
   * @return string Rendered field template
   */
    public function Field($properties = array())
    {
        return parent::Field($properties);
    }
  /**/
    public function validate($validator)
    {
      //
        $form = $this->getForm();
        $attributes = $form->FormAttributes();
        $StringID = explode(" ", $attributes);
        $ID = substr($StringID[0], strrpos($StringID[0], '_') + 1);
        $ID = rtrim($ID, '"');
      //
        if (!empty($this->Value())) {
          // Not expecting any value
            $validator->validationError(
                $this->Name,
                _t('Werkbot\SpamProtection\Honeypot.INVALID', 'There was an error submitting this form. Please try again.')
            );
            if (intval($ID !== 0)) {
                  $form->sessionMessage(_t('Werkbot\SpamProtection\Honeypot.INVALID', 'There was an error submitting this form. Please try again.'), 'bad');
            }
            return false;
        }
      //
        return true;
    }
  /**
   * @return array
   */
    public function getAttributes()
    {
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
