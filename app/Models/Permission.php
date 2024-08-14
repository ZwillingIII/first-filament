<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends \Spatie\Permission\Models\Permission
{
    use HasFactory;

    protected $appends = ['full_name'];

    public function getFullNameAttribute()
    {
//        return trans('filament.permissions.' . $this->name);
        return $this->name;
    }
}
