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
        // Check for overlapping salary ranges
        $existingRanges = SalaryRange::where('minimum', '<', $this->maximum)
            ->where('maximum', '>', $this->minimum)
            ->exists();

        return !$existingRanges;
    }

    public function message()
    {
        return 'The salary range overlaps with an existing range.';
    }
}
