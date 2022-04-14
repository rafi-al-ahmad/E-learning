<?php

use App\Models\Language;
use App\Models\Settings;

if (!function_exists('AdminUrl')) {
    function AdminUrl($url = null)
    {
        return url('admin/' . $url);
    }
}


if (!function_exists('langLines')) {

    function langLines($local, $payload)
    {
        $lines = Language::getlang($local)->payload;
        return $lines[$payload];
    }
}




if (!function_exists('langArrayPrintInputs')) {

    function langArrayPrintInputs($array, $parentKey = '', $style = '')
    {
        $printed = false;
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                langArrayPrintInputs($value, $parentKey . 'KeyDotE' . $key);
            } else {
                echo ("<div style='" . $style . "' class='form-row'>
                                        <div  class=' form-group col'>
                                            <label for='payloadKeyDotE" . $parentKey . 'KeyDotE' . $key . "'>" . $value . "</label>
                                            <input required name='payloadKeyDotE" . $parentKey . 'KeyDotE' . $key . "' type='text' id='" . $parentKey . '.' . $key . "' value='".old('payloadKeyDotE' . $parentKey . 'KeyDotE' . $key)."' class='form-control' placeholder='Translate' />
                                        </div>
                                    </div>");
            }
        }
        // echo $html;
    }
}

if (!function_exists('langArrayPrintInputsToEdit')) {

    function langArrayPrintInputsToEdit($array, $parentKey = '', $style = '')
    {
        $printed = false;
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                langArrayPrintInputsToEdit($value, $parentKey . 'KeyDotE' . $key);
            } else {
                echo ("<div style='" . $style . "' class='form-row'>
                                        <div  class=' form-group col'>
                                            <label for='payloadKeyDotE" . $parentKey . 'KeyDotE' . $key . "'>" . $value . "</label>
                                            <input required name='payloadKeyDotE" . $parentKey . 'KeyDotE' . $key . "' type='text' id='" . $parentKey . '.' . $key . "' value='" .(old('payloadKeyDotE' . $parentKey . 'KeyDotE' . $key) ? old('payloadKeyDotE' . $parentKey . 'KeyDotE' . $key) : $value ). "' class='form-control' placeholder='Translate' />
                                        </div>
                                    </div>");
            }
        }
        // echo $html;
    }
}

if (!function_exists('settings')) {

    function settings($attr = null)
    {
        if ($attr) {
            return Settings::getsettings()->getAttribute($attr);
        }
        return Settings::getsettings();
    }
}


if (!function_exists('langDirection')) {

    function langDirection()
    {
        return (Language::getlang(app()->getLocale())->getDir());
    }
}


if (!function_exists('getLangs')) {

    function getLangs()
    {
        return (Language::getAllLanguagesNames());
    }
}


