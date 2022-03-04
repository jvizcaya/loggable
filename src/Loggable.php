<?php

declare(strict_types=1);

namespace Jvizcaya\Loggable;

use Jvizcaya\Loggable\Models\Log;

/**
 * Provides functions to record user activities in the application models.
 *
 * @author Jorge Vizcaya <jorgevizcayaa@gmail.com>
 *
 *
 */
trait Loggable
{
		/**
		* The "boot" method of the model.
		*
		* @param  object $this->model	model object
		* @return void
		*/
		protected static function bootLoggable()
		{
				if(auth()->check())
				{
					static::created(function ($model) {
						if(config('loggable.log_events.created')){
							self::save_log($model, 'create');
						}
					});

					static::saved(function ($model) {
						if(config('loggable.log_events.saved')){
							self::save_log($model, 'save');
						}
					});

					static::updated(function ($model){
						if(config('loggable.log_events.updated')){
							self::save_log($model, 'update');
						}
					});

					static::deleted(function ($model){
						if(config('loggable.log_events.deleted')){
							self::save_log($model, 'delete');
						}
					});

					static::retrieved(function ($model){
						if(config('loggable.log_events.retrieved')){
							self::save_log($model, 'retriev');
						}
					});

					if(function_exists('restored')){
						static::restored(function ($model){
							if(config('loggable.log_events.restored')){
								self::save_log($model, 'restore');
							}
						});
				}
			}
		}

		/**
     * Get all of the user's logs.
     *
     */
    public function logs()
    {
        return $this->morphMany(Log::class, 'model');
    }

		/**
     * (scope) Load the model logs.
     *
     * @param integer $limit maximum number of results
     * @param boolean $loadUser if user data must be loaded
     * @param string $userColumns $userColumns user columns to load
     */
		public function scopeLastLogs($query, $limit = 10, $loadUser = true, $userColumns = 'id,name')
		{
					return $query->with(['logs' => function ($q) use ($limit, $loadUser, $userColumns){
									  $q->orderBy('log_at', 'desc')->take($limit);

										if($loadUser){
											$q->with('user:'.$userColumns);
										}
								}]);
		}

		/**
		* The "save log" method.
		*
		* @param  object $this->model	model object
		* @param string $type the model type operation
		* @return void
		*/
		static function save_log($model, $type){

					Log::create([
						'user_id' => auth()->user()->id,
						'model_id' => $model->id,
						'model_type' => get_class($model),
						'type' => $type,
						'table' => $model->getTable(),
						'payload' => [
							'user' => [
								'id' => auth()->user()->id,
								'name' => auth()->user()->name,
								'email' => auth()->user()->email
							],
							'data' => config('loggable.log_data') && $type == 'delete' ? $model->toArray() : null
						],
						'log_at' => now()->toDateTimeString()
					]);
		}


}
