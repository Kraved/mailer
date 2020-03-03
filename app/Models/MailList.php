<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MailList extends Model
{
    use SoftDeletes;

    protected $table = 'mail_list';

    protected $guarded = [];
}
