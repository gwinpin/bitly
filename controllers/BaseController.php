<?php


class BaseController
{
    protected function renderView($view)
    {
        include(ROOT . '/views/' . $view . '.php');
    }
}