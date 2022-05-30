<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Song;
use Illuminate\Support\Carbon;
class Playlist extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function songs()
    {
        return $this->belongsToMany(Song::class);
    }

    public function getTotalDuration()
    {
        $total_duration = Carbon::createFromFormat('H:i:s', "00:00:00");
        foreach ($this->songs as $song) {
            $duration = Carbon::createFromFormat('H:i:s', $song->duration);
            $total_duration = $total_duration->addSecond($duration->second)->addMinutes($duration->minute)->addHours($duration->hour);
        }
        return $total_duration->format('H:i:s');
    }
}
