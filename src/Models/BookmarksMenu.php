<?php

namespace STAFEGROUPAB\FilamentBookmarksMenu\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class BookmarksMenu extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = "filament_bookmarks_menu_table";

    public function user() {
        $userModel = config('filament-bookmarks-menu.user_model', User::class);
        return $this->belongsTo($userModel, 'menu_user_id', 'id');
    }
}
