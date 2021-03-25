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
       'log_at' => 'datetime'
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

}
