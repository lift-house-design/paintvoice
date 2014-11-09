<?php

/* For data/form validation */
class Valid
{
    public function phone(&$phone)
    {
        $phone = preg_replace('/(^1|[^\d]+)/','',$phone);

        if(strlen($phone) != 10)
            return " should be a valid 10-digit phone number";
        $phone = '('.substr($phone,0,3).') '.substr($phone,3,3).'-'.substr($phone,6,4);
    }

    public function fullname(&$name)
    {
        $name = trim($name);
        if(stripos($name,' ') === false)
            return ' should contain first AND last name';
        if(preg_match('/[^a-zA-Z.\-\' ]/', $name, $match))
            return " should not contain '{$match[0]}'";
    }

    public function email(&$email)
    {
        $email = trim($email);
        if(!preg_match('/[a-zA-Z0-9.!#$%&\'*+\-\/=?\^_`{|}~]+\@[a-zA-Z0-9\.\-]{3,}/', $email))
            return ' should be a valid email address';
    }

    public function vin(&$vin)
    {
        $vin = strtoupper(trim($vin));
        if(preg_match('/[^A-Z0-9]/', $vin))
            return ' should only contain letters and numbers';
        if(strlen($vin) != 17)
            return ' should be 17 characters long';
    }

    public function zip(&$zip)
    {
        $zip = trim($zip);
        if(preg_match('/[^0-9]/', $zip))
            return ' should only contain numbers';
        if(strlen($zip) != 5)
            return ' should be 5 digits long';
    }

    public function required(&$val)
    {
        $val = trim($val);
        if(empty($val))
            return ' is required';
    }

    /* 
        $data is usually the $_POST array
        $rules = array( array(<index>, '<function1>|<function2>|...', <is_optional> ), ...)
    */
    public function validate(&$data, $rules)
    {
        foreach($rules as $rule)
        {
            if(isset($rule[2]) && empty($data[$rule[0]]))
                continue;
            if(empty($data[$rule[0]]))
                return $this->label($rule[0])." is required";
            $functions = preg_split('/\|/', $rule[1], 0, PREG_SPLIT_NO_EMPTY);
            foreach($functions as $function)
            {
                eval('$err = $this->'.$function.'($data[$rule[0]]);');
                if(!empty($err))
                    return $this->label($rule[0])." $err";
            }
        }
    }

    public function label($index)
    {
        if($index == 'vin')
            return 'VIN';
        return ucwords(str_replace('_',' ',$index));
    }

    public function fill_empty(&$data, $rules)
    {
        foreach($rules as $rule)
            if(empty($data[$rule[0]]))
                $data[$rule[0]] = '';
    }

    public function make_empty(&$data, $rules)
    {
        foreach($rules as $rule)
            $data[$rule[0]] = '';
    }
}
?>
