<?php

declare(strict_types=1);

namespace Jvizcaya\Loggable\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(config('loggable.table'));
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'model_type',
        'model_id',
        'type',
        'table',
        'payload',
        'log_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
     protected $casts = [
       'user_id' => 'integer',
       'model_type' => 'string',
       'model_id' => 'integer',
       'type' => 'string',
       'table' => 'string',
       'payload' => 'array',
       'log_at' => 'datetime:Y-m-d H:i:s'
     ];

     /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
     public $timestamps = false;

     /**
     * Get the user that owns the logs.
     *
     */
      public function user()
      {
          return $this->belongsTo(config('auth.providers.users.model'));
      }

     /**
      * Get the parent model.
      *
      */
     public function model()
     {
         return $this->morphTo();
     }

     /**
     * Scope a query to only include user.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByUser($query, $value)
    {
        if($value){
          return $query->where('user_id', $value);
        }
    }

    /**
    * Scope a query to only include table.
    *
    * @param  \Illuminate\Database\Eloquent\Builder  $query
    * @return \Illuminate\Database\Eloquent\Builder
    */
     public function scopeByTable($query, $value)
     {
         if($value){
           return $query->where('table', $value);
         }
     }

     /**
     * Scope a query to only include table.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
      public function scopeByModel($query, $value)
      {
          if($value){
            return $query->where('model_id', $value);
          }
      }

      /**
      * Scope a query to only include a date.
      *
      * @param  \Illuminate\Database\Eloquent\Builder  $query
      * @return \Illuminate\Database\Eloquent\Builder
      */
       public function scopeDate($query, $value)
       {
           if($value){
             return $query->whereDate('log_at', '=', now()->parse($value)->format('Y-m-d'));
           }
       }

       /**
       * Get the log date in string format
       *
       * @return string
       */
      public function getLogAtStringAttribute()
      {
          if($this->log_at->diffInDays(now()) < 7){
            return $this->log_at->diffForHumans(now());
          }

          return $this->log_at->format('Y-m-d H:i:s');
      }
}
