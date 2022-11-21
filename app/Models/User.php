<?php

namespace App\Models;

use App\Utils\Subscription;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;
use Statamic\Facades\GlobalSet;
use App\Utils\Media;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'gender',
        'email_verified_at',
        'stripe_customer_id',
        'social',
        'last_opened_note',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'social' => 'object',
    ];

    protected $appends = ['avatar_image', 'trial_days', 'current_plan'];

    public function folders()
    {
        return $this->hasMany(Folder::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function getAvatarImageAttribute()
    {
        $image = $this->avatar;

        if ($image != null && $image != '' && file_exists(storage_path($image))) {
            return asset($image);
        } else {
            return "https://ui-avatars.com/api/?name={$this->name}&background=random&bold=true&rounded=true&format=svg";
        }
    }

    public function getCurrentPlanAttribute()
    {
        $subscription = $this->subscriptions()->active()->latest()->first();

        if ($subscription && $subscription->valid()) {
            $subscription->product = Subscription::product($subscription->items->first()->stripe_product);
            $subscription->is_cancel_plan = ($subscription->cancelled() && $subscription->notOnGracePeriod()) ? true : false;

            return $subscription;
        }
    }

    public function getTrialDaysAttribute()
    {
        $days = 0;

        if ($this->current_plan) {
            $days = Carbon::parse($this->current_plan->trial_ends_at)->diffInDays(now()->startOfDay());
        }

        return $days;
    }

    public function getMemoryUsedAttribute()
    {
        return $this->memoryUsed();
    }
    
    public function memoryUsed($unit = true) {

        $size = 0;

        $this->notes()->each(function ($note) use (&$size) {
            $size += (int) $note->size;
        });

        if ($unit) {
            return Media::unitConverter($size);
        }

        return $size;

    }

    public function getStatusAttribute()
    {
        return Subscription::status($this);
    }

    public function unVerify()
    {
        $this->update(['email_verified_at' => null]);
    }

    public function dirPath()
    {
        return "public/user/{$this->id}/avatar";
    }

    public function cancelSubscription()
    {
        Subscription::cancel($this);
    }

    public function extendTrial($date)
    {
        Subscription::extendTrial($this, $date);
    }

    public function checkout($request)
    {
        return Subscription::checkout($this, $request);
    }

    public function change($price)
    {
        return Subscription::change($this, $price);
    }

    public function resumeSubscription()
    {
        return Subscription::resume($this);
    }

    public function isMemoryExceed()
    {
        $memory = Media::memoryLimit();       
        $usedMemory = $this->memoryUsed(false);

        if ($usedMemory > $memory) {
            return false;
        } else {
            return true;
        }
    }
}
