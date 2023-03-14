<?php

namespace App;

use Illuminate\Support\Arr;
use App\Http\Helpers\AppHelper;
use Illuminate\Database\Eloquent\Model;
use Hrshadhin\Userstamps\UserstampsTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Haruncpi\LaravelIdGenerator\IdGenerator;


class Student extends Model
{
    use SoftDeletes;
    use UserstampsTrait;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'user_id',
        'name',
        'nick_name',
        'dob',
        'gender',
        'source',
        'compaign',
        'nationality',
        'photo',
        'email',
        'phone_no',
        'extra_activity',
        'note',
        'father_name',
        'father_phone_no',
        'mother_name',
        'mother_phone_no',
        'guardian',
        'guardian_phone_no',
        'present_address',
        'permanent_address',
        'sms_receive_no',
        'siblings',
        'status',
    ];

    public function registration()
    {
        return $this->hasMany('App\Registration', 'student_id');
    }
    public function getGenderAttribute($value)
    {
        return Arr::get(AppHelper::GENDER, $value);
    }

    public function getSourceAttribute($value)
    {
        if($value) {
            return Arr::get(AppHelper::SOURCE, $value);
        }
        return "";
    }

    // composer require haruncpi/laravel-id-generator
    public static function boot()
    {
        parent::boot();

        static::creating(function($model){
            $model->code = IdGenerator::generate(['table' => 'students', 'field'=>'code', 'length' => 10, 'prefix' =>'STD-']);
        });
    }

    // public function getBloodGroupAttribute($value)
    // {
    //     if($value) {
    //         return Arr::get(AppHelper::BLOOD_GROUP, $value);
    //     }
    //     return "";
    // }
}
