<?php

namespace JJSoft\SigesCore\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class FieldsServiceProvider
 * @package JJSoft\SigesCore\Providers
 */
class FieldsServiceProvider extends ServiceProvider
{
    /**
     * The system Field types
     * @var array
     */
    public $defaultTypes = [
        'text' => \JJSoft\SigesCore\Field\Text\TextFieldType::class,
        'email' => \JJSoft\SigesCore\Field\Email\EmailFieldType::class,
        'textarea' => \JJSoft\SigesCore\Field\TextArea\TextAreaFieldType::class,
        'date' => \JJSoft\SigesCore\Field\Date\DateFieldType::class,
        'select' => \JJSoft\SigesCore\Field\Select\SelectFieldType::class
    ];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('field.types', 'JJSoft\SigesCore\Field\FieldTypes');
        $this->setDefaultTypes();
    }

    /**
     * Set the default Field Types
     */
    public function setDefaultTypes()
    {
        $types = $this->app->make('field.types');
        foreach ($this->defaultTypes as $alias => $fieldType) {
            $types->addFieldType([
                'type' => $alias,
                'class' => $fieldType
            ]);
        }
    }
}
