<?php
declare(strict_types=1);

namespace Budgetcontrol\Core\Http\Controller;

use Budgetcontrol\Library\Model\Label;
use Budgetcontrol\Registry\Schema\Labels as LabelsSchema;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class LabelController extends Controller
{
    public function list(Request $request, Response $response, array $args)
    {
        return response(Label::where(LabelsSchema::workspace_id, $args['workspace_id'])->get());
    }
}