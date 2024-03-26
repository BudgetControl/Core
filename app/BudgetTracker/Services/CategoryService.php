<?php

namespace App\BudgetTracker\Services;

use Illuminate\Http\Request;
use App\User\Services\UserService;
use App\BudgetTracker\Models\Labels;
use App\User\Controllers\Controller;
use App\BudgetTracker\Models\Category;
use App\BudgetTracker\Models\SubCategory;


class CategoryService 
{   
    private $categories;
    private $labels;
    private $id;

    public function __construct(int $id = 0)
    {
        $this->id = $id;
    }

    /**
     * return a category id
     * @param string description
     * @return string category id
     */
    public function getCategoryIdFromAction(string $description) 
    {
        $other = "635bd34d25f01";
        $cat = SubCategory::where("uuid",$other)->firstOrFail();
        foreach($this->categories as $item) {
            
            $configs = json_decode($item->config);
            foreach($configs->keymatch as $config) {
                $find = strpos(strtolower($description),strtolower($config));
                if($find !== false) {
                    // i found a value
                    $cat = SubCategory::where("uuid",$configs->uuid)->first();
                    return $cat->name;
                }
            }
        }
        return $cat->name;
    }

        /**
     * return a labels
     * @param string description
     * @return string labels 
     */
    public function getLabelIdFromAction(string $description) 
    {
        $labels = [];
        foreach($this->labels as $item) {
            $configs = json_decode($item->config);
            foreach($configs->keymatch as $config) {
                $find = strpos(strtolower($description),strtolower($config));
                if($find !== false) {
                    // i found a value
                    $label = Labels::where("uuid",$configs->uuid)->first();
                    if(!empty($label)) {
                        $labels[] = $label->name;
                    }
                }
            }
        }
        return implode("|",$labels);
    }

    /**
     * get all categories
     */
    public function all()
    {
         return Category::with('subCategory')->orderBy('name')->get();
    }

    /**
     * save category
     */
    public function save(Request $request): void
    {
        if(!empty($this->id)) {
            $category = SubCategory::findOrFail($this->id);
        } else {
            $category = new SubCategory();
        }
        
        $category->name = $request->name;
        $category->exclude_from_stats = $request->exclude_stats;
        $category->category_id = $request->parent_category;
        $category->custom = 1;
        $category->save();

    }

}
