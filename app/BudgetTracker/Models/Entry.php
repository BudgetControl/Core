<?php

namespace App\BudgetTracker\Models;

use App\BudgetTracker\Interfaces\EntryInterface;
use App\BudgetTracker\Entity\Entries\Entry as EntryObject;
use Illuminate\Database\Eloquent\Model;
use App\BudgetTracker\Enums\EntryType;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User\Services\UserService;
use DateTime;

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
        'date_time' =>  'date:Y-m-d H:i:s',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        
        $this->attributes['date_time'] = date('Y-m-d H:i:s',time());
        $this->attributes['transfer'] = 0;
        $this->attributes['confirmed'] = 1;

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
        $query->with('label')->with('subCategory.category')->with('account')->with("payee")->orderBy('date_time','desc')
        ->with('currency');
    }

    /**
     *  find with specify uuid
     *  @param string $uuid
     *  
     *  @return mixed
     * */
    public static function findFromUuid(string $uuid)
    {
        return Entry::where('uuid',$uuid)->with('label')->first();
    }

    /**
     * scope user
     */
    public function scopeStats($query): void
    {
        $query->leftJoin('accounts', 'accounts.id', '=', 'entries.account_id')
        ->where("accounts.exclude_from_stats",0);
    }

    /**
     * 
     */
    public static function buildEntity(array $data, EntryType $type): EntryInterface
    {
        return new EntryObject(
            $data['amount'],
            $type,
            Currency::findOrFail($data['currency_id']),
            $data['note'],
            new DateTime($data['date_time']),
            $data['waranty'],
            $data['transfer'],
            $data['confirmed'],
            SubCategory::findOrFail($data['category_id']),
            Account::findOrFail($data['account_id']),
            PaymentsTypes::findOrFail($data['payment_type']),
            new \stdClass(),
            $data['label']
          );
    }

    /**
     * public function is equaò
     */
    public function equal(Entry $entry): bool
    {
        return $this->toArray() === $entry->toArray();
    }

}
