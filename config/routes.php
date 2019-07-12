<?php

$ConfigRoutes = ConfigRoutes::getInstance();

$ConfigRoutes->addRoute(
    'Default',
    '/:controller/:action/:params'
);
/*
$ConfigRoutes->addRoute(
    'DefaultWithLanguage',
    '/:language/:controller/:action/:params'
);*/
