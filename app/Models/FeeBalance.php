<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FeeBalance extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'fee_balances';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const TERM_SELECT = [
        'Term 1' => 'Term 1',
        'Term 2' => 'Term 2',
        'Term 3' => 'Term 3',
    ];

    protected $fillable = [
        'admission_number_id',
        'balance',
        'term',
        'year_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function admission_number()
    {
        return $this->belongsTo(Student::class, 'admission_number_id');
    }

    public function year()
    {
        return $this->belongsTo(Year::class, 'year_id');
    }
}
