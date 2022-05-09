<?php
/**/
namespace Werkbot\SpamProtection;
/**/
use Werkbot\SpamProtection\TimerField;
use SilverStripe\Forms\FormField;
use SilverStripe\UserForms\Model\EditableFormField;
use SilverStripe\ORM\UnsavedRelationList;
/**/
class EditableTimerField extends EditableFormField {
  /**/
  private static $singular_name = 'Timer Spam Protection Field';
  private static $plural_name = 'Timer Spam Protection Fields';
  private static $table_name = 'EditableTimerField';
  /**/
  private static $db = [];
  /**
   * @var FormField
   */
  protected $formField = null;
   /**/
   public function getFormField(){
    //
    $field = TimerField::create($this->Name, $this->Title, time())->addExtraClass('wb-spam-hidden');
    $this->doUpdateFormField($field);
    //
    return $field;
  }
  /**
   * @param FormField $field
   * @return self
   */
  public function setFormField(FormField $field){
      $this->formField = $field;
      return $this;
  }
  /**
   * Used in userforms 3.x and above
   *
   * {@inheritDoc}
   */
  public function getCMSFields() {
    //
    $fields = parent::getCMSFields();
    //
    if ($this->Parent()->Fields() instanceof UnsavedRelationList) {
        return $fields;
    }
    //
    return $fields;
  }
  /**/
  public function getRequired(){
    return false;
  }
  /**/
  public function showInReports(){
    return false;
  }
}
