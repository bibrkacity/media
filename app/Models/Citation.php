<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Citation extends Model
{
    use HasFactory;

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
}
