<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    public function getMenu(){

        $menu=\DB::table("menu")
            ->orderBy("priority")
            ->get();
        return $menu;
    }
}
