<?php

namespace Imanghafoori\PasswordHistory\Database;

use Illuminate\Database\Eloquent\Model;

class PasswordHistory extends Model
{
    protected $table;

    protected $fillable = ['user_id','password', 'guard'];

    public function __construct(array $attributes = [])
    {
        $this->table = config('password_history.table_name');
        parent::__construct($attributes);
    }

}
