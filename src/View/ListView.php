<?php

namespace App\View;

use App\System\View as View;
use App\Models\Users\User as User;

class ListView extends View
{
    public static function default(array $info, ?User $user): string
    {
        if (!empty($info['data'])) {
            if (isset($info['paginator'])) {
                return self::formWithPagination($info, $user);
            } else {
                return self::formListData($info, $user, $info['data']);
            }
        } else {
            return 'В этом городе еще нет ивентов';
        }
    }

    private static function formListData(array $info, ?User $user, array $pageData): string
    {
        $classView = 'App\View\\' . ucfirst($info['entity']) . 'View';
        $method = $info['typePart'];
        $arrayOfItem = [];
        $number = 0;
        foreach ($pageData as $item) {
            $element = $classView::$method($item, $user, $number);
            array_push($arrayOfItem, $element);
            $number += 1;
        }
        return ListView::render(
            'Lists/listDefault',
            $user,
            [
                'arrayOfItem' => $arrayOfItem,
                'info' => $info,
            ]
        );
    }

    private static function formWithPagination(array $info, ?User $user): string
    {
        $currentPage = (int)$info['paginator']['currentPage'];
        $perPage = (int)$info['paginator']['perPage'];
        $countPages = ceil(count($info['data']) / $perPage);
        if ($currentPage <= $countPages && $currentPage > 0) {
            $pageData = array_slice($info['data'], $perPage * ($currentPage - 1), $perPage);
        }
        if (isset($pageData)) {
            $list = self::formListData($info, $user, $pageData);
            $pagination = self::render(
                'Lists/pagination',
                $user,
                [
                    'pagination' => self::paginationArrayForm($currentPage, $countPages),
                    'currentPage' => $currentPage,
                    'prefix' => $info['paginator']['prefix'],
                ]
            );
            return $list . $pagination;
        } else {
            return 'на этой странице нет записей';
        }
    }

    private static function paginationArrayForm(int $currentPage, int $countPages): array
    {
        $result = [];

        for ($i = -2; $i <= 2; $i++) {
            $pageCheck = $currentPage + $i;
            if (self::existPage($pageCheck, $countPages)) {
                $result["$pageCheck"] = $pageCheck;
            }
        }
        if (self::existPage($currentPage - 1, $countPages)) {
            $previousPage['<'] = $currentPage - 1;
        }
        if (self::existPage($currentPage + 1, $countPages)) {
            $result['>'] = $currentPage + 1;
        }
        return (isset($previousPage)) ? $previousPage + $result : $result;
    }

    private static function existPage($page, $countPages): bool
    {
        return ($page > 0 && $page <= $countPages) ? true : false;
    }
}


