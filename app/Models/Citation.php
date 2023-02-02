<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Citation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'citation',
    ];

    /**
     * Sendings of citation
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function Messengers(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany('App\Models\Messenger',
            'citation_messenger_user','citation_id','messenger_id')
            ->withPivot(['id','user_id','address','status']);
    }

    /**
     * User who add citation
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function User(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }


    /**
     * Accessor for created_at
     * @return string
     */
    public function GetCreatedAtAttribute(): string
    {
        $d = \DateTime::createFromFormat('Y-m-d H:i:s', $this->attributes['created_at']) ;
        return $d->format( 'r');
    }
}
