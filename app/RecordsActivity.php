<?php


namespace App;


trait RecordsActivity 
{

    protected static function bootRecordsActivity()//ako nazovemo boot pa ime traita, laravel ce prepoznati i okinuti kao da se nalazi na modelu
    {
        if (auth()->guest()) return;

        foreach (static::getActivitiesToRecord() as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($event);
            });
        }
    }

    
    protected static function getActivitiesToRecord()
    {
        return ['created'];
    }



    public function recordActivity($event)
    {
        $this->activity()->create([
            'user_id' => auth()->id(),
            'type' => $this->getActivityType($event),//Zbog morphMany veze ne moramo da unesemo subject_id i subject_type
        ]);

        // Activity::create([
        //     'user_id' => auth()->id(),
        //     'type' => $this->getActivityType($event),
        //     'subject_id' => $this->id,
        //     'subject_type' => get_class($this)
        // ]);
    }

    public function activity()
    {
        return $this->morphMany('App\Activity', 'subject');
    }

    protected function getActivityType($event)
    {
        $type = strtolower((new \ReflectionClass($this))->getShortName());
        return "{$event}_{$type}"; 
    }
}