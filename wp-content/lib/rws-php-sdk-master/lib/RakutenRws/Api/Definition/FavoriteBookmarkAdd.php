<?php

/**
 * This file is part of Rakuten Web Service SDK
 *
 * (c) Rakuten, Inc
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with source code.
 */

/**
 * FavoriteBookmarkAdd
 *
 * @package RakutenRws
 * @subpackage Api_Definition
 */
class RakutenRws_Api_Definition_FavoriteBookmarkAdd extends RakutenRws_Api_AppRakutenApi
{
    protected
        $versionMap = array(
            '20120627' => '20120627'
        );

    public function getService()
    {
        return 'FavoriteBookmark';
    }

    public function getOperation()
    {
        return 'Add';
    }

    public function getMethod()
    {
        return 'POST';
    }
}
