<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;
    protected $fillable=['store_id','user_id','payment_method','status','payment_status'];
    public function store(): BelongsTo
    {
        return $this->belongsTo(store::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault(['name'=>'customer']);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class,'order_items','order_id','product_id','id','id')
            ->using(OrderItem::class)
            ->withPivot(['product_name','price','quantity','options']);
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(OrderAddress::class);
    }

    public function billingAddress(): HasOne
    {
        return $this->hasOne(OrderAddress::class,'order_id','id')->where('type','=','billing');
    }
    public function shippingAddress(): HasOne
    {
        return $this->hasOne(OrderAddress::class,'order_id','id')->where('type','=','shipping');
    }

    public static function booted()
    {
        parent::booted(); // TODO: Change the autogenerated stub
        static::creating(function (Order $order){
            $order->number=Order::GetNextOrderNumber() ;
        });
    }

    public static function GetNextOrderNumber(){
        $year = Carbon::now()->year;
        $number = Order::WhereYear('created_at',$year)->max('number');
        if ($number){
            return $number+1;
        }
        return $year.'0001';
    }
}
