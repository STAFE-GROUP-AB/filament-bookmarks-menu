<?php

namespace STAFEGROUPAB\FilamentBookmarksMenu\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookmarksMenu extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = "filament_bookmarks_menu_table";

    public function user() {
        return $this->belongsTo(\App\Models\User::class, 'menu_user_id', 'id');
    }
}
