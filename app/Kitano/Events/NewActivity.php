<?php

namespace App\Kitano\Events;


class NewActivity
{
    /** @var int */
    public $user;

    /** @var string */
    public $op;
    /** @var string */
    public $old;
    /** @var string */
    public $new;

    /**
     * NewActivity constructor.
     * @param int           $uid  The user ID
     * @param string        $op   The performede operation
     * @param null|string   $old  The Old value
     * @param null|string   $new  The New value
     */
    public function __construct($uid, $op, $old = null, $new = null)
    {
        $this->user = $uid;
        $this->op = $op;
        $this->old = $old;
        $this->new = $new;
    }
}
