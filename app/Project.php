<?php

namespace App;

use Auth;

class Project extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'license', 'description',
    ];

    /**
     * Check if user is owner of project in query.
     * 
     * @param  [type] $query [description]
     */
    public function scopeUserIsOwner($query)
    {
        $query->where('user_id', '=', Auth::id());
    }

    /**
     * Helper function to check if user is owner of project.
     *
     * @return bool
     */
    public function userOwned()
    {
        // Always return true if user is admin
        if (Auth::user() && Auth::user()->permissions->role_id === 3) { // TODO role_name
            return true;
        }

        return $this->user->id === Auth::id();
    }

    /**
     * Format a project's name into an URL friendly "slug".
     *
     * @return string
     */
    public function getSlug()
    {
        return str_slug($this->name);
    }

    public function getImageAttribute() {
        // return $this->image ? $this->image : config('project.stockimg');
        return config('project.stockimg');
    }

    /**
     * Get a list of tag ids associated with the current project.
     * 
     * @return array
     */
    public function getTagListAttribute()
    {
        return $this->tags->pluck('id')->all();
    }

    /**
     * Get a list of tag names associated with the current project.
     * 
     * @return array
     */
    public function getTagListNameAttribute()
    {
        return $this->tags->pluck('name')->all();
    }

    /**
     * Get relationship for User model.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get relationship for File model.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function files()
    {
        return $this->hasMany('App\File');
    }

    /**
     * Get relationship for Tag model.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany('App\Tag')->withTimestamps();
    }
}
