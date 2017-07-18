<?php

function create($class, $atts = [], $times = null)
{
    return factory($class, $times)->create($atts);
}

function make($class, $atts = [], $times = null)
{
    return factory($class, $times)->make($atts);
}