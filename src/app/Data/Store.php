<?php

namespace App\Data;

use Illuminate\Support\Carbon;

class Store
{
    public static function QUIZ_UPLOAD_URL()
    {
        return config('classino.classino_file_upload_url_4'). '/api/upload/quiz';
    }

    public static function QUIZ_DOWNLOAD_URL($file= null)
    {
        return config('classino.classino_file_upload_url_4'). '/filepond/quiz/' . $file;
    }

    public static function PROFILE_DOWNLOAD_URL($file= null)
    {
        return config('classino.classino_file_upload_url_4'). '/filepond/user_profile/' . $file;
    }
    public static function MENUITEM_ICON_DOWNLOAD_URL($file= null)
    {
        return config('classino.classino_file_upload_url_4'). '/filepond/menu/' . $file;
    }

    public static function MENUITEM_ICON_UPLOAD_URL()
    {
        return config('classino.classino_file_upload_url_4'). '/api/upload/menu';
    }

    public static function PROFILE_UPLOAD_URL()
    {
        return config('classino.classino_file_upload_url_4'). '/api/upload/user_profile';
    }

    public static function TEACHER_DOWNLOAD_URL($file= null)
    {
        return config('classino.classino_file_upload_url_4'). '/filepond/profile/' . $file;
    }

    public static function TEACHER_UPLOAD_URL()
    {
        return config('classino.classino_file_upload_url_4'). '/api/upload/profile';
    }

    public static function QA_UPLOAD_URL()
    {
        return config('classino.classino_file_upload_url_4'). '/api/upload/classqa';
    }

    public static function QA_DOWNLOAD_URL($file= null)
    {
        return config('classino.classino_file_upload_url_4'). '/filepond/classqa/'. $file;
    }

    public static function BLOCK_REASON_IMAGE_DOWNLOAD_URL($file= null)
    {
        return config('classino.classino_file_upload_url_4'). '/filepond/block/' . $file ;
    }
    public static function BLOCK_REASON_IMAGE_UPLOAD_URL()
    {
        return config('classino.classino_file_upload_url_4'). '/api/upload/block';
    }

    public static function HOMEWORK_DOWNLOAD_URL($file= null)
    {
        if (ends_with($file, '.mp4') || ends_with($file, '.mov')|| ends_with($file, '.mkv'))
            $file= 'video/'.$file;

        return config('classino.classino_file_upload_url_4'). '/filepond/homework/' . $file;
    }
    public static function REPORT_DOWNLOAD_URL($file= null)
    {
        return config('classino.classino_file_upload_url_4'). '/filepond/report/' . $file;
    }
    public static function HOMEWORK_UPLOAD_URL()
    {
        return config('classino.classino_file_upload_url_4'). '/api/upload/homework';
    }
    public static function PRODUCT_UPLOAD_URL()
    {
        return config('classino.classino_file_upload_url_4'). '/api/upload/product';
    }
    public static function PRODUCT_DOWNLOAD_URL($file= null)
    {
        return config('classino.classino_file_upload_url_4'). '/filepond/product/' . $file;
    }
    public static function CATEGORY_BANNER_UPLOAD_URL()
    {
        return config('classino.classino_file_upload_url_4'). '/api/upload/category_banner';
    }
    public static function CATEGORY_BANNER_DOWNLOAD_URL($file= null)
    {
        return config('classino.classino_file_upload_url_4'). '/filepond/category_banner' . $file;
    }
    public static function ANNOUNCEMENT_DOWNLOAD_URL($file= null)
    {
        return config('classino.classino_file_upload_url_4'). '/filepond/announcement/' . $file;
    }
    public static function ANNOUNCEMENT_UPLOAD_URL()
    {
        return config('classino.classino_file_upload_url_4'). '/api/upload/announcement';
    }
    public static function DEBITCARD_DOWNLOAD_URL($file= null)
    {
        $timestamp=Carbon::now()->addSeconds(30)->timestamp;
        $hash= sha1(config('classino.store4_key'). $file . $_SERVER['HTTP_X_FORWARDED_FOR'] ?? request()->ip() . $timestamp);

        return config('classino.classino_file_upload_url_4'). '/api/download/debit_card/' . $file . '?mac='.$hash .'&expire_at='.$timestamp;
    }
    public static function DEBITCARD_UPLOAD_URL()
    {
        return config('classino.classino_file_upload_url_4'). '/api/upload/debit_card';
    }
}
