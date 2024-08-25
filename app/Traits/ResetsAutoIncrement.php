<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait ResetsAutoIncrement
{
    //Trait to Reset Auto Increment ID

    public static function resetAutoIncrement()
    {
        DB::statement('SET @count = 0');
        DB::statement('UPDATE ' . (new static)->getTable() . ' SET id = @count:= @count + 1');
        DB::statement('ALTER TABLE ' . (new static)->getTable() . ' AUTO_INCREMENT = 1');
    }
}
