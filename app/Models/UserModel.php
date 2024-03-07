<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    use HasFactory;

    protected $table = 'm_user'; //Mendefinisikan nama tabelk yang digunakan oleh model ini
    protected $primarykey = 'user_id'; //Mendefinisikan primary key dari tabel yang digunakan

    /**
     * @var array
     */


    protected $fillable = ['level_id', 'username', 'nama'];
}