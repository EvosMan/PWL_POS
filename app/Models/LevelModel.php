<?php

namespace app\Models;

use illuminate\Database\Eloquent\Model;
use illuminate\Database\Eloquent\Relations\HasMany;

class LevelModel extends Model
{
    protected $table = 'm_level';
    protected $primaryKey = 'level_id';

    protected $fillable = ['level_kode', 'level_nama'];


}
