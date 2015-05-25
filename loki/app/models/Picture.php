<?php

class Picture extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pictures';
    public $timestamps = false;

    public function group()
    {
        return $this->belongsTo('Group');
    }

}

