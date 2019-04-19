<?php

namespace App\maguttiCms\Admin;

class AdminFormSelect
{
    /**
     * The singleton instance.
     *
     * @var AdminFormSelect|null
     */
    private static $instance = null;

    /**
     * The select options.
     *
     * @var array
     */
    protected $options = [];

    /**
     * The field name.
     *
     * @var string
     */
    protected $name = '';

    /**
     * The currently selected option.
     *
     * @var string
     */
    protected $selected = '';

    /**
     * This is the method to get the singleton instance.
     *
     * @return AdminFormSelect
     */
    public static function getInstance(): AdminFormSelect
    {
        if (!isset(self::$instance)) {
            self::$instance = new AdminFormSelect();
        }

        return self::$instance;
    }

    /**
     * This method is used to specify the options to render.
     *
     * @param array $options
     *
     * @return AdminFormSelect
     */
    public static function withOptions(array $options): self
    {
        $instance = self::getInstance();
        $instance->options = $options;

        return $instance;
    }

    /**
     * This method is used to specify the name of the field.
     *
     * @param string $name
     *
     * @return AdminFormSelect
     */
    public static function withName(string $name): self
    {
        $instance = self::getInstance();
        $instance->name = $name;

        return $instance;
    }

    /**
     * This method is used to specify which is the currently selected option.
     *
     * @param string $value
     *
     * @return AdminFormSelect
     */
    public static function withSelected(string $value): self
    {
        $instance = self::getInstance();
        $instance->selected = $value;

        return $instance;
    }

    /**
     * This method is used to render the form element.
     *
     * @return string
     */
    public function render(): string
    {
        $openingTag = "<select name=\"{$this->name}\" class=\"form-control\">";
        $closingTag = "</select>";

        // Start building the form element.
        $formElement = $openingTag;

        foreach ($this->options as $key => $value) {

            // Append the opening option tag.
            $formElement .= "<option value=\"$key\"";

            // Mark it as selected if necessary.
            if ($key == $this->selected) {
                $formElement .= " selected";
            }

            // Append the closing option tag.
            $formElement .= ">$value</option>";
        }

        $formElement .= $closingTag;

        return $formElement;
    }
}
