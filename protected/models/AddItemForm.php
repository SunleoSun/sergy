<?php

class AddItemForm extends CFormModel
{
    public $category;
    public $name;
    public $width;
    public $length;
    public $diameter;
    public $price;
    public $description;
    public $colors;
    public $materials;

    public function rules()
    {
        return array(
            array('name, category, price', 'required'),
            array('width, length, diameter, price', 'numerical'),
        );
    }


}