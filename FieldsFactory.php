<?php
namespace Awesome;

class FieldsFactory{
    protected $model;
    protected $placeholder = '';
    protected static $wrapper_classes = array(
        'colorpicker' => 'bootstrap-colorpicker',
        'align' => 'btn-group btn-group-align btn-group-radio'
    );

    public function __construct($model, $placeholder = ''){
        $this->model = $model;
        $this->placeholder = $placeholder;
    }

    protected function get_arg($array, $key){
        return isset($array[$key]) ? $array[$key] : '';
    }

    protected function colorpicker($name, $args){
        $html = '<span class="input-group-addon color"><i></i></span>';
        $html .= '<input type="hidden"
               name="' . $name . '"
               class="option-color"
               value=""
               class="form-control" />';
        return $html;
    }

    protected function text_field($name, $args){
        return '<input type="text" name="' . $name . '" class="form-control" placeholder="' . $this->get_arg($args, 'placeholder') . '">';
    }

    protected function select($name, $args){
        $options = $this->get_arg($args, 'options');
        $html = '<select name="' . $name . '" data-field="' . $this->get_arg($args, 'name') . '">';
        if(is_array($options)){
            foreach($options as $key => $value){
                $html .= '<option value="'. $key . '">' . $value . '</option>';
            }
        }
        $html .= '</select>';
        return $html;
    }

    protected function get_wrapper($field, $field_name, $args){
        $type = $this->get_arg($args, 'type');
        $label = $this->get_arg($args, 'label');
        $class = $this->get_arg($args, 'wrapper_class') . $this->get_arg(static::$wrapper_classes, $type);
        $html = '<div class="' . $field_name . ' model-field ' . $class . '">';
        if($label){
            $html .= '<span class="field_label">' . $label . '</span>';
        }
        $html .= $field;
        $html .= '</div>';
        return $html;
    }

    public function get($args){
        $type = $this->get_arg($args, 'type');
        $field_name = $this->placeholder ? $this->placeholder . '_' . $this->get_arg($args, 'name') : '_' . $this->get_arg($args, 'name');
        $name = $this->model . '_' . $field_name;
        if(!method_exists($this, $type)){
            return;
        }
        $field = $this->$type($name, $args);
        $html = $this->get_wrapper($field, $field_name, $args);
        return $html;
    }
}