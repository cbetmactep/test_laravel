<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'articles';

    protected $fillable = ['text'];

    protected $dates = ['deleted_at'];
    
    /**
    * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
    */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function isAuthor($user)
    {
        
        if(!empty($user) &&  !($user instanceof User)) 
        {
            return 'mismatch';
        }

        if ($this->trashed())
        {
            return null;
        }

        if($this->users()->find($user->id))
        {
            return true;
        }

        return false;
    }

}
