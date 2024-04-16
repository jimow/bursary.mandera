<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GlobalSearchController extends Controller
{
    private $models = [
        'Principal' => 'cruds.principal.title',
        'School'    => 'cruds.school.title',
        'Student'   => 'cruds.student.title',
    ];

   public function search(Request $request)
{
    $search = $request->input('search');

    if ($search === null || !isset($search['term'])) {
        abort(400);
    }

    $term = $search['term'];
    $searchableData = [];
    foreach ($this->models as $model => $translation) {
        $modelClass = 'App\Models\\' . $model;
        // Eager load the 'form' and 'stream' relationships along with 'school' if not already done
        $query = $modelClass::with(['form', 'stream', 'school']);

        $fields = $modelClass::$searchable;

        foreach ($fields as $field) {
            $query->orWhere($field, 'LIKE', '%' . $term . '%');
        }

        $results = $query->take(10)->get();

        foreach ($results as $result) {
            $parsedData = $result->only($fields);
            $parsedData['model'] = trans($translation);
            $parsedData['fields'] = $fields;
            $formattedFields = [];
            foreach ($fields as $field) {
                $formattedFields[$field] = Str::title(str_replace('_', ' ', $field));
            }
            $parsedData['fields_formated'] = $formattedFields;

            // Append 'school_name', 'form_name', and 'stream_name' if the relations exist
            if (isset($result->school)) {
                $parsedData['school_name'] = $result->school->name;
            }
            if (isset($result->form) && isset($result->stream)) {
                // Combining form and stream names to create a class name
                $parsedData['class_name'] = $result->form->name . ' ' . $result->stream->name;
            }

            $parsedData['url'] = url('/admin/' . Str::plural(Str::snake($model, '-')) . '/' . $result->id . '/edit');

            $searchableData[] = $parsedData;
        }
    }

    return response()->json(['results' => $searchableData]);
}

    
}
