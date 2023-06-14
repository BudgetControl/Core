<?php

namespace App\BudgetTracker\Models;

use Illuminate\Database\Eloquent\Model;
use App\BudgetTracker\Enums\EntryType;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Http\Services\UserService;

class Entry extends Model
{
    use SoftDeletes;

    protected $table = 'entries';

    public $hidden = [
        "created_at",
        "updated_at",
        "deleted_at"
      ];

    protected $casts = [
        'created_at'  => 'date:Y-m-d',
        'updated_at'  => 'date:Y-m-d',
        'deletad_at'  => 'date:Y-m-d',
        'date_time' =>  'date:Y-m-d h:i:s'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        
        $this->attributes['date_time'] = date('Y-m-d H:i:s',time());
        $this->attributes['uuid'] = uniqid();
        $this->attributes['transfer'] = 0;
        $this->attributes['confirmed'] = 1;
        if(empty($this->attributes['user_id'])) {
            $this->attributes['user_id'] = UserService::getCacheUserID();
        }

        foreach($attributes as $k => $v) {
            $this->$k = $v;
        }
    }

     /**
     * The users that belong to the role.
     */
    public function label()
    {
        return $this->belongsToMany(Labels::class, 'entry_labels','entry_id');
    }

    /**
     * Get the category
     */
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, "category_id");
    }

    /**
     * Get the currency
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    /**
     * Get the payments_type
     */
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Get the payments_type
     */
    public function transferTo()
    {
        return $this->belongsTo(Account::class, "transfer_id");
    }

    /**
     * Get the payments_type
     */
    public function paymentType()
    {
        return $this->belongsTo(PaymentsTypes::class);
    }

    /**
     * Get the payee
     */
    public function payee()
    {
        return $this->belongsTo(Payee::class);
    }

    /** 
     * retrive only incoming entry of these month
     * 
     */
    public function scopeLastMonth($query): void
    {
        $query->where('type', EntryType::Incoming);
        $query->whereNull('deleted');
    }

    /** 
     * retrive only incoming entry of these month
     * 
     */
    public function scopePlanned($query): void
    {
        $query->where('planned',1);
    }

    /**
     * with relations
     */
    public function scopeWithRelations($query): void
    {
        $query->with('label')->with('subCategory.category')->with('account')->orderBy('date_time','desc')
        ->where('user_id',UserService::getCacheUserID());
    }

    /**
     *  find with specify uuid
     *  @param string $uuid
     *  
     *  @return Entry
     * */
    public static function findFromUuid(string $uuid): Entry
    {
        return Entry::where('uuid',$uuid)->where('user_id',UserService::getCacheUserID())->firstOrFail();
    }

    /**
     * scope user
     */
    public function scopeUser($query): void
    {
        $query->where('user_id',UserService::getCacheUserID());
    }

}
