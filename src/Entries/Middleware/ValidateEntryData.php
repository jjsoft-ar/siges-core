<?php

namespace JJSoft\SigesCore\Entries\Middleware;

use League\Tactician\Middleware;
use Illuminate\Support\Facades\Validator;
use JJSoft\SigesCore\Exceptions\EntryValidationException;

/**
 * Class ValidateEntryData
 * @package JJSoft\SigesCore\Entries\Middleware
 */
class ValidateEntryData implements Middleware
{
    /**
     * @var array
     */
    public $rules = [];

    /**
     * @param object $command
     * @param callable $next
     * @return mixed
     * @throws EntryValidationException
     */
    public function execute($command, callable $next)
    {
        $this->prepareValidation($command)->performValidation($command);
        return $next($command);
    }

    /**
     * @param $command
     * @return $this
     */
    protected function prepareValidation($command)
    {
        $fields = $command->entity->fields;
        foreach ($fields as $field) {
            $this->setRulesForField($field);
        }
        return $this;
    }

    /**
     * Set the validation rules for the Field
     * @param $field
     */
    protected function setRulesForField($field)
    {
        $this->rules[$field->slug] = [];
        if ((bool)$field->required === true) {
            array_push($this->rules[$field->slug], 'required');
        }
        // Import the validation rules from the fieldtype Class
        $type = $field->getType();
        $classValidationRules = isset($type->validationRules) ? $type->validationRules : [];
        foreach ($classValidationRules as $key => $rule) {
            $rule = (is_string($rule)) ? explode('|', $rule) : $rule;
            $this->rules[$field->slug] = array_merge($this->rules[$field->slug], $rule);
        }
        return $this;
    }

    /**
     * @param $command
     * @throws EntryValidationException
     */
    protected function performValidation($command)
    {
        $validator = Validator::make($command->input, $this->rules);
        if ($validator->fails()) {
            throw new EntryValidationException($validator);
        }
    }
}
