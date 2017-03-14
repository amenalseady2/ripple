<?php

/*
 * This file is part of the ripple library.
 *
 * (c) Tomoki Morita <tmsongbooks215@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace jamband\ripple;

use stdClass;

/**
 * Vimeo class file.
 * url pattern 1: https?://vimeo.com/{id}
 *
 * Vimeo's playlists is not implemented. The reasons are as follows:
 * https://vimeo.com/album/{id} is work. But playlists can not get title and thumbnails when using oembed.
 * https://vimeo.com/album/{id}/video/{id} is work. But this will get one video information, not a playlist.
 */
class Vimeo
{
    /**
     * @var string[]
     */
    public static $hosts = [
        'vimeo.com',
    ];

    /**
     * @var string
     */
    public static $multiplePattern = '/album/';

    /**
     * @var string
     * @link https://developer.vimeo.com/apis/oembed
     */
    public static $endpoint = 'https://vimeo.com/api/oembed.json?url=';

    /**
     * @return string
     */
    public static function validUrlPattern()
    {
        return '#\Ahttps?\://(www\.)?vimeo\.com/[1-9][0-9]+\z#';
    }

    /**
     * @param stdClass $content
     * @return null|string
     */
    public static function id(stdClass $content = null)
    {
        if (isset($content->video_id)) {
            return (string)$content->video_id;
        }
        return null;
    }

    /**
     * @param stdClass $content
     * @return null|string
     */
    public static function title(stdClass $content = null)
    {
        if (isset($content->title)) {
            return $content->title;
        }
        return null;
    }

    /**
     * @param stdClass $content
     * @return null|string
     */
    public static function image(stdClass $content = null)
    {
        if (isset($content->thumbnail_url)) {
            return $content->thumbnail_url;
        }
        return null;
    }

    /**
     * @param string $id
     * @param bool $hasMultiple
     * @return string
     */
    public static function embed($id, $hasMultiple)
    {
        $embed =  'https://player.vimeo.com/video';
        return $hasMultiple ? "$embed/album/$id" : "$embed/$id";
    }
}
