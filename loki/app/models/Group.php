<?php

class Group extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'group';
    public $timestamps = false;

    public function pictures()
    {
        return $this->hasMany('Picture');
    }

}

