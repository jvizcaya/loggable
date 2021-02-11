<?php

declare(strict_types=1);

namespace Jvizcaya\Loggable;

use Illuminate\Support\Facades\DB;

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
		* The "booted" method of the model.
		*
		* @param  object $this->model	model object
		* @return void
		*/
		protected static function booted()
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

				if(method_exists($model, 'restored')){
					static::restored(function ($model){
						if(config('loggable.log_events.restored')){
							self::save_log($model, 'restore');
						}
					});
				}
		}

		/**
		* The "save log" method.
		*
		* @param  object $this->model	model object
		* @param string $type the model type operation
		* @return void
		*/
		static function save_log($model, $type){

				if(auth()->check())
				{
						DB::table(config('loggable.table'))->insert([
							'user_id' => auth()->user()->id,
							'register_id' => $model->id,
							'type' => $type,
							'model' => self::class,
							'table' => $model->getTable(),
							'log_at' => now()->toDateTimeString()
						]);
				}
		}


}
