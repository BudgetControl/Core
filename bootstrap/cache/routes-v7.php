<?php

/*
|--------------------------------------------------------------------------
| Load The Cached Routes
|--------------------------------------------------------------------------
|
| Here we will decode and unserialize the RouteCollection instance that
| holds all of the route information for an application. This allows
| us to instantaneously load the entire route map into the router.
|
*/

app('router')->setCompiledRoutes(
    array (
  'compiled' => 
  array (
    0 => false,
    1 => 
    array (
      '/sanctum/csrf-cookie' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'sanctum.csrf-cookie',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/_ignition/health-check' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ignition.healthCheck',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/_ignition/execute-solution' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ignition.executeSolution',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/_ignition/update-config' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ignition.updateConfig',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/budget-tracker/incoming' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'incoming.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'incoming.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/budget-tracker/expenses' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'expenses.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'expenses.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/budget-tracker/debit' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'debit.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'debit.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/budget-tracker/transfer' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'transfer.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'transfer.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/budget-tracker/planning-recursively' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'planning-recursively.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'planning-recursively.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/budget-tracker/payee' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'payee.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'payee.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/budget-tracker/entry' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'entry.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'entry.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/budget-tracker/categories' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'categories.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'categories.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/budget-tracker/accounts' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'accounts.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'accounts.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/budget-tracker/labels' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'labels.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'labels.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/budget-tracker/currencies' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'currencies.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'currencies.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/budget-tracker/model' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'model.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'model.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/budget-tracker/paymentstype' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'paymentstype.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'paymentstype.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/budget-tracker/search' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::k9WlH2hqSIaw8Mjl',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::WHgJOENSiWxTR7Xj',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
    ),
    2 => 
    array (
      0 => '{^(?|/api/budget\\-tracker/(?|incoming/([^/]++)(?|(*:51))|e(?|xpenses/([^/]++)(?|(*:82))|ntry/(?|([^/]++)(?|(*:109))|account/([^/]++)(*:134)))|debit/([^/]++)(?|(*:161))|transfer/([^/]++)(?|(*:190))|p(?|lanning\\-recursively/([^/]++)(?|(*:235))|ay(?|ee/([^/]++)(?|(*:263))|mentstype/([^/]++)(?|(*:293))))|c(?|ategories/([^/]++)(?|(*:329))|urrencies/([^/]++)(?|(*:359)))|accounts/([^/]++)(?|(*:389))|labels/([^/]++)(?|(*:416))|model/([^/]++)(?|(*:442))|stats/month\\-wallet/([^/]++)(?:/([^/]++))?(*:493)))/?$}sDu',
    ),
    3 => 
    array (
      51 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'incoming.show',
          ),
          1 => 
          array (
            0 => 'incoming',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'incoming.update',
          ),
          1 => 
          array (
            0 => 'incoming',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        2 => 
        array (
          0 => 
          array (
            '_route' => 'incoming.destroy',
          ),
          1 => 
          array (
            0 => 'incoming',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      82 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'expenses.show',
          ),
          1 => 
          array (
            0 => 'expense',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'expenses.update',
          ),
          1 => 
          array (
            0 => 'expense',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        2 => 
        array (
          0 => 
          array (
            '_route' => 'expenses.destroy',
          ),
          1 => 
          array (
            0 => 'expense',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      109 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'entry.show',
          ),
          1 => 
          array (
            0 => 'entry',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'entry.update',
          ),
          1 => 
          array (
            0 => 'entry',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        2 => 
        array (
          0 => 
          array (
            '_route' => 'entry.destroy',
          ),
          1 => 
          array (
            0 => 'entry',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      134 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::eSRVPaELBafVNOeR',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      161 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'debit.show',
          ),
          1 => 
          array (
            0 => 'debit',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'debit.update',
          ),
          1 => 
          array (
            0 => 'debit',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        2 => 
        array (
          0 => 
          array (
            '_route' => 'debit.destroy',
          ),
          1 => 
          array (
            0 => 'debit',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      190 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'transfer.show',
          ),
          1 => 
          array (
            0 => 'transfer',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'transfer.update',
          ),
          1 => 
          array (
            0 => 'transfer',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        2 => 
        array (
          0 => 
          array (
            '_route' => 'transfer.destroy',
          ),
          1 => 
          array (
            0 => 'transfer',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      235 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'planning-recursively.show',
          ),
          1 => 
          array (
            0 => 'planning_recursively',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'planning-recursively.update',
          ),
          1 => 
          array (
            0 => 'planning_recursively',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        2 => 
        array (
          0 => 
          array (
            '_route' => 'planning-recursively.destroy',
          ),
          1 => 
          array (
            0 => 'planning_recursively',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      263 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'payee.show',
          ),
          1 => 
          array (
            0 => 'payee',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'payee.update',
          ),
          1 => 
          array (
            0 => 'payee',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        2 => 
        array (
          0 => 
          array (
            '_route' => 'payee.destroy',
          ),
          1 => 
          array (
            0 => 'payee',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      293 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'paymentstype.show',
          ),
          1 => 
          array (
            0 => 'paymentstype',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'paymentstype.update',
          ),
          1 => 
          array (
            0 => 'paymentstype',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        2 => 
        array (
          0 => 
          array (
            '_route' => 'paymentstype.destroy',
          ),
          1 => 
          array (
            0 => 'paymentstype',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      329 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'categories.show',
          ),
          1 => 
          array (
            0 => 'category',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'categories.update',
          ),
          1 => 
          array (
            0 => 'category',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        2 => 
        array (
          0 => 
          array (
            '_route' => 'categories.destroy',
          ),
          1 => 
          array (
            0 => 'category',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      359 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'currencies.show',
          ),
          1 => 
          array (
            0 => 'currency',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'currencies.update',
          ),
          1 => 
          array (
            0 => 'currency',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        2 => 
        array (
          0 => 
          array (
            '_route' => 'currencies.destroy',
          ),
          1 => 
          array (
            0 => 'currency',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      389 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'accounts.show',
          ),
          1 => 
          array (
            0 => 'account',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'accounts.update',
          ),
          1 => 
          array (
            0 => 'account',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        2 => 
        array (
          0 => 
          array (
            '_route' => 'accounts.destroy',
          ),
          1 => 
          array (
            0 => 'account',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      416 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'labels.show',
          ),
          1 => 
          array (
            0 => 'label',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'labels.update',
          ),
          1 => 
          array (
            0 => 'label',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        2 => 
        array (
          0 => 
          array (
            '_route' => 'labels.destroy',
          ),
          1 => 
          array (
            0 => 'label',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      442 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'model.show',
          ),
          1 => 
          array (
            0 => 'model',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'model.update',
          ),
          1 => 
          array (
            0 => 'model',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        2 => 
        array (
          0 => 
          array (
            '_route' => 'model.destroy',
          ),
          1 => 
          array (
            0 => 'model',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      493 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::JBPlvbGRptHWTlZY',
            'planned' => NULL,
          ),
          1 => 
          array (
            0 => 'type',
            1 => 'planned',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => NULL,
          1 => NULL,
          2 => NULL,
          3 => NULL,
          4 => false,
          5 => false,
          6 => 0,
        ),
      ),
    ),
    4 => NULL,
  ),
  'attributes' => 
  array (
    'sanctum.csrf-cookie' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'sanctum/csrf-cookie',
      'action' => 
      array (
        'uses' => 'Laravel\\Sanctum\\Http\\Controllers\\CsrfCookieController@show',
        'controller' => 'Laravel\\Sanctum\\Http\\Controllers\\CsrfCookieController@show',
        'namespace' => NULL,
        'prefix' => 'sanctum',
        'where' => 
        array (
        ),
        'middleware' => 
        array (
          0 => 'web',
        ),
        'as' => 'sanctum.csrf-cookie',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ignition.healthCheck' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '_ignition/health-check',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'Spatie\\LaravelIgnition\\Http\\Middleware\\RunnableSolutionsEnabled',
        ),
        'uses' => 'Spatie\\LaravelIgnition\\Http\\Controllers\\HealthCheckController@__invoke',
        'controller' => 'Spatie\\LaravelIgnition\\Http\\Controllers\\HealthCheckController',
        'as' => 'ignition.healthCheck',
        'namespace' => NULL,
        'prefix' => '_ignition',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ignition.executeSolution' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => '_ignition/execute-solution',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'Spatie\\LaravelIgnition\\Http\\Middleware\\RunnableSolutionsEnabled',
        ),
        'uses' => 'Spatie\\LaravelIgnition\\Http\\Controllers\\ExecuteSolutionController@__invoke',
        'controller' => 'Spatie\\LaravelIgnition\\Http\\Controllers\\ExecuteSolutionController',
        'as' => 'ignition.executeSolution',
        'namespace' => NULL,
        'prefix' => '_ignition',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ignition.updateConfig' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => '_ignition/update-config',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'Spatie\\LaravelIgnition\\Http\\Middleware\\RunnableSolutionsEnabled',
        ),
        'uses' => 'Spatie\\LaravelIgnition\\Http\\Controllers\\UpdateConfigController@__invoke',
        'controller' => 'Spatie\\LaravelIgnition\\Http\\Controllers\\UpdateConfigController',
        'as' => 'ignition.updateConfig',
        'namespace' => NULL,
        'prefix' => '_ignition',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'incoming.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/budget-tracker/incoming',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'incoming.index',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\IncomingController@index',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\IncomingController@index',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'incoming.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/budget-tracker/incoming',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'incoming.store',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\IncomingController@store',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\IncomingController@store',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'incoming.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/budget-tracker/incoming/{incoming}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'incoming.show',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\IncomingController@show',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\IncomingController@show',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'incoming.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'api/budget-tracker/incoming/{incoming}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'incoming.update',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\IncomingController@update',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\IncomingController@update',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'incoming.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/budget-tracker/incoming/{incoming}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'incoming.destroy',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\IncomingController@destroy',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\IncomingController@destroy',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'expenses.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/budget-tracker/expenses',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'expenses.index',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\ExpensesController@index',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\ExpensesController@index',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'expenses.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/budget-tracker/expenses',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'expenses.store',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\ExpensesController@store',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\ExpensesController@store',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'expenses.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/budget-tracker/expenses/{expense}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'expenses.show',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\ExpensesController@show',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\ExpensesController@show',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'expenses.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'api/budget-tracker/expenses/{expense}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'expenses.update',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\ExpensesController@update',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\ExpensesController@update',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'expenses.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/budget-tracker/expenses/{expense}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'expenses.destroy',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\ExpensesController@destroy',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\ExpensesController@destroy',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'debit.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/budget-tracker/debit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'debit.index',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\DebitController@index',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\DebitController@index',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'debit.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/budget-tracker/debit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'debit.store',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\DebitController@store',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\DebitController@store',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'debit.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/budget-tracker/debit/{debit}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'debit.show',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\DebitController@show',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\DebitController@show',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'debit.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'api/budget-tracker/debit/{debit}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'debit.update',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\DebitController@update',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\DebitController@update',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'debit.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/budget-tracker/debit/{debit}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'debit.destroy',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\DebitController@destroy',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\DebitController@destroy',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'transfer.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/budget-tracker/transfer',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'transfer.index',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\TransferController@index',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\TransferController@index',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'transfer.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/budget-tracker/transfer',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'transfer.store',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\TransferController@store',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\TransferController@store',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'transfer.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/budget-tracker/transfer/{transfer}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'transfer.show',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\TransferController@show',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\TransferController@show',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'transfer.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'api/budget-tracker/transfer/{transfer}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'transfer.update',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\TransferController@update',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\TransferController@update',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'transfer.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/budget-tracker/transfer/{transfer}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'transfer.destroy',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\TransferController@destroy',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\TransferController@destroy',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'planning-recursively.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/budget-tracker/planning-recursively',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'planning-recursively.index',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\PlanningRecursivelyController@index',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\PlanningRecursivelyController@index',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'planning-recursively.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/budget-tracker/planning-recursively',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'planning-recursively.store',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\PlanningRecursivelyController@store',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\PlanningRecursivelyController@store',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'planning-recursively.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/budget-tracker/planning-recursively/{planning_recursively}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'planning-recursively.show',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\PlanningRecursivelyController@show',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\PlanningRecursivelyController@show',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'planning-recursively.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'api/budget-tracker/planning-recursively/{planning_recursively}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'planning-recursively.update',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\PlanningRecursivelyController@update',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\PlanningRecursivelyController@update',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'planning-recursively.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/budget-tracker/planning-recursively/{planning_recursively}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'planning-recursively.destroy',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\PlanningRecursivelyController@destroy',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\PlanningRecursivelyController@destroy',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'payee.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/budget-tracker/payee',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'payee.index',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\PayeeController@index',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\PayeeController@index',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'payee.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/budget-tracker/payee',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'payee.store',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\PayeeController@store',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\PayeeController@store',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'payee.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/budget-tracker/payee/{payee}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'payee.show',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\PayeeController@show',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\PayeeController@show',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'payee.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'api/budget-tracker/payee/{payee}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'payee.update',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\PayeeController@update',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\PayeeController@update',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'payee.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/budget-tracker/payee/{payee}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'payee.destroy',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\PayeeController@destroy',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\PayeeController@destroy',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'entry.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/budget-tracker/entry',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'entry.index',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\EntryController@index',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\EntryController@index',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'entry.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/budget-tracker/entry',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'entry.store',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\EntryController@store',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\EntryController@store',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'entry.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/budget-tracker/entry/{entry}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'entry.show',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\EntryController@show',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\EntryController@show',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'entry.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'api/budget-tracker/entry/{entry}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'entry.update',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\EntryController@update',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\EntryController@update',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'entry.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/budget-tracker/entry/{entry}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'entry.destroy',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\EntryController@destroy',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\EntryController@destroy',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'categories.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/budget-tracker/categories',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'categories.index',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\CategoryController@index',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\CategoryController@index',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'categories.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/budget-tracker/categories',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'categories.store',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\CategoryController@store',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\CategoryController@store',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'categories.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/budget-tracker/categories/{category}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'categories.show',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\CategoryController@show',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\CategoryController@show',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'categories.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'api/budget-tracker/categories/{category}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'categories.update',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\CategoryController@update',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\CategoryController@update',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'categories.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/budget-tracker/categories/{category}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'categories.destroy',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\CategoryController@destroy',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\CategoryController@destroy',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'accounts.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/budget-tracker/accounts',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'accounts.index',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\AccountController@index',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\AccountController@index',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'accounts.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/budget-tracker/accounts',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'accounts.store',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\AccountController@store',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\AccountController@store',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'accounts.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/budget-tracker/accounts/{account}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'accounts.show',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\AccountController@show',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\AccountController@show',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'accounts.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'api/budget-tracker/accounts/{account}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'accounts.update',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\AccountController@update',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\AccountController@update',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'accounts.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/budget-tracker/accounts/{account}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'accounts.destroy',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\AccountController@destroy',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\AccountController@destroy',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'labels.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/budget-tracker/labels',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'labels.index',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\LabelController@index',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\LabelController@index',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'labels.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/budget-tracker/labels',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'labels.store',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\LabelController@store',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\LabelController@store',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'labels.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/budget-tracker/labels/{label}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'labels.show',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\LabelController@show',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\LabelController@show',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'labels.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'api/budget-tracker/labels/{label}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'labels.update',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\LabelController@update',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\LabelController@update',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'labels.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/budget-tracker/labels/{label}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'labels.destroy',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\LabelController@destroy',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\LabelController@destroy',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'currencies.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/budget-tracker/currencies',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'currencies.index',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\CurrencyController@index',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\CurrencyController@index',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'currencies.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/budget-tracker/currencies',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'currencies.store',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\CurrencyController@store',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\CurrencyController@store',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'currencies.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/budget-tracker/currencies/{currency}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'currencies.show',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\CurrencyController@show',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\CurrencyController@show',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'currencies.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'api/budget-tracker/currencies/{currency}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'currencies.update',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\CurrencyController@update',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\CurrencyController@update',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'currencies.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/budget-tracker/currencies/{currency}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'currencies.destroy',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\CurrencyController@destroy',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\CurrencyController@destroy',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'model.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/budget-tracker/model',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'model.index',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\ModelController@index',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\ModelController@index',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'model.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/budget-tracker/model',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'model.store',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\ModelController@store',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\ModelController@store',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'model.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/budget-tracker/model/{model}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'model.show',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\ModelController@show',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\ModelController@show',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'model.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'api/budget-tracker/model/{model}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'model.update',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\ModelController@update',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\ModelController@update',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'model.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/budget-tracker/model/{model}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'model.destroy',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\ModelController@destroy',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\ModelController@destroy',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'paymentstype.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/budget-tracker/paymentstype',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'paymentstype.index',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\PaymentTypeController@index',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\PaymentTypeController@index',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'paymentstype.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/budget-tracker/paymentstype',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'paymentstype.store',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\PaymentTypeController@store',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\PaymentTypeController@store',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'paymentstype.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/budget-tracker/paymentstype/{paymentstype}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'paymentstype.show',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\PaymentTypeController@show',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\PaymentTypeController@show',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'paymentstype.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'api/budget-tracker/paymentstype/{paymentstype}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'paymentstype.update',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\PaymentTypeController@update',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\PaymentTypeController@update',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'paymentstype.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/budget-tracker/paymentstype/{paymentstype}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'as' => 'paymentstype.destroy',
        'uses' => 'App\\BudgetTracker\\Http\\Controllers\\PaymentTypeController@destroy',
        'controller' => 'App\\BudgetTracker\\Http\\Controllers\\PaymentTypeController@destroy',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::k9WlH2hqSIaw8Mjl' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/budget-tracker/search',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'uses' => '\\App\\BudgetTracker\\Http\\Controllers\\SearchEntriesController@find',
        'controller' => '\\App\\BudgetTracker\\Http\\Controllers\\SearchEntriesController@find',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
        'as' => 'generated::k9WlH2hqSIaw8Mjl',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::eSRVPaELBafVNOeR' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/budget-tracker/entry/account/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:125:"function (string $id) {
    return \\App\\BudgetTracker\\Http\\Controllers\\EntryController::getEntriesFromAccount((int) $id);
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000004f40000000000000000";}}',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
        'as' => 'generated::eSRVPaELBafVNOeR',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::JBPlvbGRptHWTlZY' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/budget-tracker/stats/month-wallet/{type}/{planned?}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'budget-tracker',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:693:"function(string $type, string $planned = \'\') {

    $planned = $planned === \'planned\' ? true: false;

    try {
        $startDate = new \\DateTime();
        $endDate = new \\DateTime();
        $stats = new \\App\\BudgetTracker\\Http\\Controllers\\StatsController();
    
        $stats->setDateStart(
            \\date(\'Y/m/d H:i:s\',$startDate->modify(\'first day of this month\')->getTimestamp())
        )
        ->setDateEnd(
            \\date(\'Y/m/d H:i:s\',$endDate->modify(\'last day of this month\')->getTimestamp())
        );
    
        return $stats->$type($planned);

    } catch(\\Exception $e) {

        return \\response("Ops an error occured...",500);

    }

}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000008e20000000000000000";}}',
        'namespace' => NULL,
        'prefix' => 'api/budget-tracker',
        'where' => 
        array (
        ),
        'as' => 'generated::JBPlvbGRptHWTlZY',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::WHgJOENSiWxTR7Xj' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '/',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:44:"function () {
    return \\view(\'welcome\');
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000008e50000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::WHgJOENSiWxTR7Xj',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
  ),
)
);
