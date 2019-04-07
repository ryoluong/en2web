<?php
return [
    /*
    |--------------------------------------------------------------------------
    | Const
    |--------------------------------------------------------------------------
    */

    // 0:仮登録 1:本登録 2:メール認証済 9:退会済
    'USER_STATUS' => [
        'PRE_REGISTER' => '0',
        'REGISTER' => '1',
        'MAIL_AUTHED' => '2',
        'DEACTIVE' => '9',
    ],
    'LINE_CHANNEL_TOKEN' => env('LINE_CHANNEL_TOKEN'),
    'LINE_MY_USER_ID' => env('LINE_MY_USER_ID'),
    'LINE_EN2_KYOYU_GROUP_ID' => env('LINE_EN2_KYOYU_GROUP_ID'),
    'SLACK_WEBHOOK_URI' => env('SLACK_WEBHOOK_URI')
];