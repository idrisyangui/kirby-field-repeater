<?php

class RepeaterField extends BaseField {


  public $type = 'textarea';
  // public $fields = array();

  public $validate = array(
    'min' => 0,
    'max' => null
  );

  public $fieldid = '';

  public $fieldposition = '';

  static public $assets = array(
    'css' => array(
      'repeater.css'
    ),
    'js' => array(
      'vue.min.js',
      'yaml.js',
      'sortable.js',
      'vue-sortable.js',
      'repeater.js',
    )
  );

  public function label() {
    return null;
  }

  public function headline() {

    if(!$this->readonly) {

      $add = new Brick('div');
      $add->html('<i class="icon icon-left fa fa-plus-circle"></i>' . l('fields.structure.add'));
      $add->addClass('structure-add-button label-option');
      $add->attr(array(
        "v-on:click" => "addEntrie"
      ));

    } else {
      $add = null;
    }

    $label = parent::label();
    $label->addClass('structure-label');
    $label->append($add);

    return $label;

  }

  public function input() {

    $input = new Brick('input', null);
    $input->addClass('input');
    $input->attr(array(
      'type'         => $this->type(),
      'value'        => '',
      'required'     => $this->required(),
      'name'         => $this->name(),
      'autocomplete' => $this->autocomplete() === false ? 'off' : 'on',
      'autofocus'    => $this->autofocus(),
      'placeholder'  => $this->i18n($this->placeholder()),
      'readonly'     => $this->readonly(),
      'disabled'     => $this->disabled(),
      'id'           => $this->id()
    ));
    $input->tag('textarea');
    $input->removeAttr('type');
    $input->removeAttr('value');
    $input->data('field', 'editor');
    $input->html('{{yamlvalues}}' ?: false);

    if(!is_array($this->value())) {
      $input->val('{{yamlvalues}}');
    }

    if($this->readonly()) {
      $input->attr('tabindex', '-1');
      $input->addClass('input-is-readonly');
    }

    return $input;

  }


  public function content_multi() {
    return tpl::load(__DIR__ . DS . 'template.php', array('field' => $this));
  }

  public function content() {

    $content = new Brick('div');
    $content->addClass('field-content');
    $content->append($this->input());
    $content->append($this->icon());
    return $content;

  }

  public function result() {

    $yaml_result = parent::result();
    $array_result = yaml($yaml_result);

    if ($this->fieldposition()) {
      return $array_result;
    } else {
      return $yaml_result;
    }

  }

  public function values() {
    if (is_array($this->value())) {
      return $this->value();
    } else {
      return yaml($this->value());
    }
  }

  public function fieldposition() {
    if ($this->fieldposition=="structure") {
      $this->fieldposition = true;
      return $this->fieldposition;
    }
  }

  public function fieldid() {
      if (empty($this->fieldid)) {
        $this->fieldid = 'repeaterfield_'.$this->name().'_'.md5(uniqid($this->id(), true));
        return $this->fieldid;
      } else {
        return $this->fieldid;
      }

  }

  public function template() {

    return $this->element()
      ->addClass($this->fieldid())
      ->append($this->label())
      ->append($this->content()->addClass('hidden'))
      ->append($this->content_multi())
      ->append($this->help());

  }

}
