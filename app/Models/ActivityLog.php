<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = ['admin_name', 'action'];

    public static function logAction($adminName, $action)
    {
        self::create([
            'admin_name' => $adminName,
            'action' => $action
        ]);

        // limit to 50 logs
        $count = self::count();
        if ($count > 50) {
            // Get the oldest IDs that exceed the limit
            $excess = $count - 50;
            $oldestIds = self::orderBy('created_at', 'asc')->take($excess)->pluck('id');
            self::whereIn('id', $oldestIds)->delete();
        }
    }
}
