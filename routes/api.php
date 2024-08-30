<?php

$app->get('/payment-types', 'Budgetcontrol\Core\Http\Controller\PaymentTypesController:index');
$app->get('/categories', 'Budgetcontrol\Core\Http\Controller\CategoryController:index');
$app->get('/currencies', 'Budgetcontrol\Core\Http\Controller\CurrencyController:index');

$app->get('/monitor', 'Budgetcontrol\Core\Http\Controller\Controller:monitor');