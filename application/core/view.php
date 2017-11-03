<?php

class View
{

    function generates($content_view, $template_view, $data = null)
    {
        include 'application/views/' . $template_view;
    }
}