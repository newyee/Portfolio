<?php
namespace App\Http\Validators;

use Illuminate\Validation\Validator;

class CustomValidator extends Validator
{
  public function validateKatakana($attribute,$value,$parameters){
    return (bool) preg_match('/^[ァ-ヾ]+$/u', $value);
  }
}
