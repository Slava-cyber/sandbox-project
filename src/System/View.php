<?php

namespace App\System;

use App\Models\Users\User as User;
use App\View\ListView;
use App\View\PageView;
use App\View\NavbarView;

class View
{
    protected $header = [];
    protected $path;

    public function __construct()
    {
        $this->path = ROOT . '../templates/';
    }

    public function setHeader(string $name, $value): void
    {
        $this->header[$name] = $value;
    }

    public static function render(string $templateName, ?User $user, array $data = [])
    {
        extract($data);
        ob_start();
        include(ROOT . '../templates/' . $templateName . '.php');
        $buffer = ob_get_contents();
        ob_end_clean();
        return $buffer;
    }

    public function print(array $data = [])
    {
        extract($this->header);

        $js = [];
        foreach ($data as $block => $value) {
            if ($block == 'page') {
                continue;
            }
            $className = 'App\View\\' . ucfirst($value['class']) . 'View';
            if (class_exists($className)) {
                $method = $value['type'];
                if (method_exists($className, $method)) {
                    $content[$block] = $className::$method($value, $user);
                    if (isset($value['js'])) {
                        $js = array_merge($js, $value['js']);
                    }
                    if (isset($value['modalWindow'])) {
                        $className = 'App\View\\' . 'ModalWindowView';
                        $method = $value['modalWindow']['type'];
                        $content[$block] = $className::$method(
                            $value['modalWindow'],
                            $content[$block],
                            $user
                        );
                    }
                }
            }
        }
        $js[] = 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"';
        $method = $data['page']['type'];
        $pageHtml = PageView::$method($content, $js, $user, $data['page']);
        echo $pageHtml;
    }
}
