<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\SalaryRange;

class DistinctSalaryRange implements Rule
{
    private $minimum;
    private $maximum;

    public function __construct($minimum, $maximum)
    {
        $this->minimum = $minimum;
        $this->maximum = $maximum;
    }

    public function passes($attribute, $value)
    {
        // Check for overlapping salary ranges, including boundary overlaps
        $existingRanges = SalaryRange::where(function($query) {
            $query->where(function($query) {
                $query->where('minimum', '<=', $this->maximum)
                      ->where('maximum', '>=', $this->minimum);
            })
            ->orWhere(function($query) {
                $query->where('maximum', '>=', $this->minimum)
                      ->where('minimum', '<=', $this->maximum);
            });
        })->exists();

        return !$existingRanges;
    }

    public function message()
    {
        return 'The salary range overlaps with an existing range.';
    }
}
