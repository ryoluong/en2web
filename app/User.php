<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\PasswordResetNotification;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new PasswordResetNotification($token));
    }

    public function countries()
    {
        return $this->belongsToMany(Country::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function favNotes()
    {
        return $this->belongsToMany(Note::class, 'favorites');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function meetings()
    {
        return $this->belongsToMany(Meeting::class, 'attendances');
    }

    /**
     * ユーザーの「プロフィール」のエスケープをした上で、%%で囲まれた部分をヘッダー(span)に置き換える
     * ユーザーのプロフィールに記載されたハイパーリンクを有効化する
     * @return string
     */
    public function getEscapedProfile()
    {
        $pattern = ['/%%(.+)%%/'];
        $replacement = ['<span class="prof_heading">$1</span>'];
        $escapedString = nl2br(htmlspecialchars($this->profile, ENT_QUOTES, 'UTF-8'));
        $escapedString = preg_replace($pattern, $replacement, $escapedString);
        $escapedString = str_replace('&amp;nbsp;', ' ', $escapedString);
        $urlPattern = '/(http|https):\/\/([A-Z0-9][A-Z0-9_-]*(?:[\.\/][\?%#A-Z0-9][\?&%;=#A-Z0-9_-]*)+):?(\d+)?\/?/i';
        $replacement = '<a class="escaped_link" href="$0" target="_blank">$0</a>';
        $escapedString = preg_replace($urlPattern, $replacement, $escapedString);
        return $escapedString;        
    }

    /**
     * ユーザーの「留学先大学」を,(コンマ)で区切り改行する
     * @return string
     */
    public function getEscapedStringWithBr()
    {
        $temp = mb_convert_kana($this->university, 'as');
        $temp = preg_replace('/,\s*/', "\n", $temp);
        return nl2br(htmlspecialchars($temp, ENT_QUOTES, 'UTF-8'));
    }

    public function fetchSlackInfo()
    {
        if (!$this->slack_id) {
            return null;
        }
        $token = config('const.SLACK_BOT_OAUTH_TOKEN');
        $url = "https://slack.com/api/users.info?user={$this->slack_id}";
        $header = implode(PHP_EOL, [
            "Authorization: Bearer {$token}"
        ]);
        $options = [
            'http' => [
                'method' => 'GET',
                'header' => $header,
                'ignore_errors' => true,
                'protocol_version' => '1.1',
            ],
        ];
        return json_decode(file_get_contents($url, false, stream_context_create($options)));
    }
}
