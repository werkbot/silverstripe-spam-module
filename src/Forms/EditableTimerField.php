<?php

namespace Werkbot\SpamProtection;

use Werkbot\SpamProtection\TimerField;
use SilverStripe\Forms\FormField;
use SilverStripe\Forms\NumericField;
use SilverStripe\UserForms\Model\EditableFormField;
use SilverStripe\ORM\UnsavedRelationList;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Core\Injector\Injector;

class EditableTimerField extends EditableFormField
{
  /**/
    private static $singular_name = 'Timer Spam Protection Field';
    private static $plural_name = 'Timer Spam Protection Fields';
    private static $table_name = 'EditableTimerField';
  /**/
  private static $db = [
    'TimeNotABot' => 'Int'
  ];
  /**
   * @var FormField
   */
    protected $formField = null;
   /**/
   public function getFormField(){
    // Clear Any existing errors
    $Request = Injector::inst()->get(HTTPRequest::class);
    $Session = $Request->getSession();
    $Session->clear('spam-protection-error-exists');
    //
    $field = TimerField::create($this->Name, $this->Title, time())->setFieldHolderTemplate('Form\\SpamFieldHolder');
    $this->doUpdateFormField($field);
    //
    return $field;
  }
  /**
   * @param FormField $field
   * @return self
   */
    public function setFormField(FormField $field)
    {
        $this->formField = $field;
        return $this;
    }
  /**
   * Used in userforms 3.x and above
   *
   * {@inheritDoc}
   */
  public function getCMSFields() {
    $this->beforeUpdateCMSFields(function ($fields) {
      $fields->addFieldsToTab(
        'Root.Main',
        [
          NumericField::create(
            'TimeNotABot',
            'Minimum amount of time to fill out the form'
          )->setDescription('Minimum time in seconds it takes to fill out the form, anything less is considered a bot')
        ]
      );
    });
    //
    return parent::getCMSFields();
  }
  /**
   * Updates a formfield with the additional metadata specified by this field
   *
   * @param FormField $field
   */
  protected function updateFormField($field)
  {
    parent::updateFormField($field);
    // Add custom time
    if (is_numeric($this->TimeNotABot) && $this->TimeNotABot > 0) {
      $field->setAttribute('data-rule-customtime', (int) $this->TimeNotABot);
    }
    // Add custom error
    if ($this->CustomErrorMessage <> ""){
      $field->setAttribute('data-custommsg', (string) $this->CustomErrorMessage);
    }
  }
  /**/
    public function getRequired()
    {
        return false;
    }
  /**/
    public function showInReports()
    {
        return false;
    }
}
