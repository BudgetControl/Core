<?php

namespace App\BudgetTracker\Services;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BudgetTracker\Models\ActionJobConfiguration;
use App\BudgetTracker\Models\SubCategory;
use App\BudgetTracker\Models\Labels;


class CategoryService 
{   
    private $categories;
    private $labels;

    public function __construct()
    {
        $this->categories = ActionJobConfiguration::where("action","category")->get();
        $this->labels = ActionJobConfiguration::where("action","label")->get();
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
}
