<?php

namespace App\BudgetTracker\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\BudgetTracker\Enums\EntryType;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

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

        foreach($attributes as $k => $v) {
            $this->$k = $v;
        }
    }

    /**
     * casting amount value
     */
    protected function amount(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => $value,
            set: fn (string $value) => $this->cleanAmount($value),
        );
    }

    /**
     * casting amount value
     */
    protected function dateTime(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => strtotime($value),
        );
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
     * Get the payments_type
     */
    public function geolocation()
    {
        return $this->belongsTo(Geolocation::class);
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
        $query->with('label')->with('subCategory.category')->with('account')->with('geolocation')->orderBy('date_time','desc');
    }

    /**
     *  find with specify uuid
     *  @param string $uuid
     *  
     *  @return Entry
     * */
    public static function findFromUuid(string $uuid): Entry
    {
        return Entry::where('uuid',$uuid)->firstOrFail();
    }

    /**
     * clean amount value
     * @param string $amount
     * 
     * @return float
     */
    private function cleanAmount(string $amount): float
    {
        $amount = number_format((float) $amount,2,'.',"");

        return (float) $amount;
    }

}
