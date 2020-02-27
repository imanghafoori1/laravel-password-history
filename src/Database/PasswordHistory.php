<?php

namespace Imanghafoori\PasswordHistory\Database;

use Illuminate\Database\Eloquent\Model;

class PasswordHistory extends Model
{
    public function __construct()
    {
        $this->table = config('password_history.table_name');
        parent::__construct();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['password', 'guard'];
}
