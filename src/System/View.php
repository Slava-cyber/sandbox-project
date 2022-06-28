<?php

namespace App\System;

class View
{
    private $header = [];
    private $path;

    public function __construct() {
        $this->path = ROOT . '../templates/';
    }

    public function setHeader(string $name, $value) : void {
        $this->header[$name] = $value;
    }

    public function render(string $templateName, array $data = [])
    {
        //$fullPath = ROOT . '../templates/' . $path . '.php';

        extract($this->header);
        extract($data);
        /*if (!empty($data)) {
            foreach ($data as $key => $value) {
                $$key = $value;
            }
        }*/

        ob_start();
        include($this->path . $templateName . '.php');
        $buffer = ob_get_contents();
        ob_end_clean();

        echo $buffer;

        //include($fullPath);
    }
}
