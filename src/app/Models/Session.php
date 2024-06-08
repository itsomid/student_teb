<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Jenssegers\Agent\Agent;
use Morilog\Jalali\Jalalian;


class Session extends Model
{
    protected $appends = ['expires_at'];
    public $incrementing = false;
    protected $primaryKey = 'id';

    public function isExpired()
    {
        return $this->last_activity < Carbon::now()->subMinutes(config('session.lifetime'))->getTimestamp();
    }

    public function getExpiresAtAttribute()
    {
        return Carbon::createFromTimestamp($this->last_activity)->addMinutes(config('session.lifetime'))->toDateTimeString();
    }

    public function expires_at()
    {

        $expiresAt = Carbon::createFromTimestamp($this->last_activity)->addMinutes(intval(config('session.lifetime')));

        return Jalalian::forge($expiresAt->toDateTimeString())->format('%A, %d %B %Y, H:i:s');
    }

    public function is_desktop()
    {
        $agent= $this->createAgent();
        return $agent->isDesktop();
    }

    public function platform()
    {
        $agent= $this->createAgent();
        return $agent->platform();
    }

    public function browser()
    {
        $agent= $this->createAgent();
        return $agent->browser();
    }

    protected function createAgent()
    {
        return tap(new Agent, function ($agent) {
            $agent->setUserAgent($this->user_agent);
        });
    }
}
