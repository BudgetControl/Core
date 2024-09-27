<?php
declare(strict_types=1);

namespace Budgetcontrol\Core\Http\Controller;

use Budgetcontrol\Library\Model\Category;
use Budgetcontrol\Library\Model\SubCategory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CategoryController extends Controller
{
    public function index()
    {
        return response(SubCategory::with('category')->get());
    }

    public function getCategoriesAndSubCategories()
    {
        $responseData = [];
        $categories = Category::all();
        foreach ($categories as $category) {
            $data = $category->toArray();
            $subCategoryData = SubCategory::where('category_id',$category->id)->get();
            $data['subCategories'] = $subCategoryData->toArray();
            $responseData[] = $data;
        }

        return response($responseData);
    }
}