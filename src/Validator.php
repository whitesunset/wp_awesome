<?php

namespace LooksAwesome\Common;

class Validator {
    /* array of validation messages */
    protected $messages;
    protected $model;
    protected $textdomain;

    public function __construct($model = '', $namespace = '\\', $textdomain = ''){
        $model = $namespace . '\App\Model\\' .ucfirst($model);
        $this->model = $model;
        $this->textdomain = $textdomain;
        $this->fill_messages();
    }

    /**
     * Fill validation messages for all rules
     */
    protected function fill_messages(){
        $this->messages = array(
            'required' => __('%1$s is required.', $this->textdomain)
        );
    }

    /**
     * Validation method for all routes
     *
     * @param array $request
     * @param array $rules
     * @return array
     * @internal param $action
     */
    public function validate($request, $rules = array()){
        $model = $this->model;
        $rules = null !== $rules ? $rules: $model::$validation_rules;
        $errors = new \WP_Error();

        foreach($request as $key => $value){
            if(array_key_exists($key, $rules)){
                $rule = $rules[$key]['rule'];
                $field = trim($value);

                /* Check if filed required (must not be empty) */
                if($rule == 'required' && empty($field)){
                    $field = str_replace('_', ' ', ucfirst($key));
                    $message = sprintf($this->messages[$rule], __($field, $this->textdomain));
                    $errors->add($key, $message);
                }
            }
        }
        return $errors;
    }
}