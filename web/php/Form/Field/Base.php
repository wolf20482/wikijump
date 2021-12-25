<?php


namespace Wikidot\Form\Field;

class Base
{
    public function __construct(protected $field)
    {
    }

    public function renderView()
    {
        return '';
    }

    public function renderEdit()
    {
        return '';
    }

    protected function hvalue()
    {
        return htmlspecialchars($this->field['value']);
    }
}
