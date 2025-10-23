<?php

namespace App\Services;

class BlogService
{
    public static function setContent(array $titles, array $dataContent)
    {
        $title = sprintf('%s',$titles[0]);
        unset($titles[0]);
        $parseTitle = array_map(function($item) {
            return sprintf('<h3>%s</h3>', $item);
        }, $titles);
        $finalContent = collect($dataContent)->map(function($item, $key) use ($parseTitle) {
            if($key > 0)
                return sprintf('%s %s', isset($parseTitle[$key]) ? $parseTitle[$key] : "",$item);
            else
                return $item;
        });

        return ['title' => $title, 'content' => $finalContent];
    }
}
