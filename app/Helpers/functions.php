<?php

use App\Enums\ProductStatus;
use App\Models\Question;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Vite;

if (!function_exists('class_name')) {
    function class_name($object)
    {
        $baseName = get_class($object);

        return str_replace('App\\Models\\', '', $baseName);
    }
}
if (!function_exists('product_status')) {
    function product_status($product)
    {
        if ($product->status == ProductStatus::Active) {
            $class = 'success';
        } elseif ($product->status == ProductStatus::Pending) {
            $class = 'warning';
        } elseif ($product->status == ProductStatus::Inactive) {
            $class = 'danger';
        } else {
            $class = 'primary';
        }

        return <<<HTML
    <span class="badge bg-{$class} rounded">
      {$product->statusName()}
    </span>
    HTML;
    }
}

if (!function_exists('job_status')) {
    function job_status($job)
    {
        switch ($job->status) {
            case 'open':
                return '<span class="badge bg-success">Open</span>';
            case 'preview':
                return '<span class="badge bg-warning">Preview</span>';
            case 'closed':
                return '<span class="badge bg-danger">Closed</span>';
            default:
                return '<span class="badge bg-secondary">Unknown</span>';
        }
    }
}

if (!function_exists('permission_name_humanize')) {
    function permission_name_humanize($name)
    {
        return ucwords(str_replace('-', ' ', $name));
    }
}

if (!function_exists('str_humanize')) {
    function str_humanize($str)
    {
        return preg_replace('/(?!^)[A-Z]{2,}(?=[A-Z][a-z])|[A-Z][a-z]/', ' $0', $str);
    }
}

if (!function_exists('attachment_url')) {
    function attachment_url($attachment)
    {
        if ($attachment->disk == 's3') {
            return $attachment->getTemporaryUrl(Carbon::now()->addMinutes(5));
        }

        return $attachment->getUrl();
    }
}

if (!function_exists('resource_image_url')) {
    function resource_image_url($resource)
    {
        $images = $resource->getMedia('images');
        if (count($images) > 0) {
            return attachment_url($images->first());
        } else {
            return Vite::asset('resources/images/products/product-80x80.jpg');
        }
    }
}

if (!function_exists('feature_image_url')) {
    function feature_image_url($resource, $collection = 'attachments', $conversion = 'featured')
    {
        $featured = $resource->getMedia('attachments', ['featured' => 'true']);
        if (count($featured) > 0) {
            return attachment_url($featured->first());
        } else {
            return Vite::asset('resources/images/products/product-80x80.jpg');
        }
    }
}


if (!function_exists('assessments_choices')) {
    function assessments_choices($id)
    {
        $question =  Question::where('id', '=', $id)->first();

        // Decode the JSON strings
        $multipleChoices = json_decode($question->multiple_choices, true);
        //  $markingScheme = json_decode($question->marking_scheme, true);

        // Initialize an array to store the choices
        $choices = [];

        // Loop through the marking scheme to find all correct multiple choice answers
        foreach ($multipleChoices as $index) {
            $choices[] = $index;
        }

        return $choices;
    }
}


if (!function_exists('assessments_answers')) {
    function assessments_answers($id)
    {
        $question =  Question::where('id', '=', $id)->first();

        // Decode the JSON strings
        $multipleChoices = json_decode($question->multiple_choices, true);
        $markingScheme = json_decode($question->marking_scheme, true);

        // Initialize an array to store the correct answers
        $correctAnswers = [];

        // Loop through the marking scheme to find all correct multiple choice answers
        foreach ($markingScheme as $index) {
            if (isset($multipleChoices[$index])) {
                $correctAnswers[] = $multipleChoices[$index];
            }
        }

        return $correctAnswers;
    }
}
