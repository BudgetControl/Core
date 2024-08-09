<?php
declare(strict_types=1);

namespace Budgetcontrol\Core\Http\Controller;

use Budgetcontrol\Library\Model\Currency;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CurrencyController extends Controller
{
    public function index()
    {
        return response(Currency::all());
    }
}