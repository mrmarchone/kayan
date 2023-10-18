<?php

namespace App\Http\Requests;

use App\Models\ScanResult;
use Illuminate\Foundation\Http\FormRequest;

class ScanResultRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $id = ScanResult::findByHashId($this->route('scan_result'))->id;
        $elasticUnique = $id ? ['unique:scan_results,elastic_id,' . $id] : ['unique:scan_results,elastic_id'];
        return [
            'scan' => 'required|exists:scans,id',
            "elastic_id" => ["required", 'regex:/^[a-zA-Z0-9_-]+$/', ...$elasticUnique],
            "source" => ['required', 'regex:/^[a-zA-Z0-9\\/:\-_\s.\\\\\[\]]+$/'],
            "host" => ["required", 'regex:/^[a-zA-Z0-9\\/:\-_\s.\\\\]+$/'],
            "domain" => ["required", 'regex:/^[a-zA-Z0-9\\/:\-_\s.\\\\]+$/'],
            "user" => ["required", 'regex:/^[a-zA-Z0-9\\/:\-_\s.\\\\@]+$/'],
            "password" => ["required"],
            "info_stealer" => ["required", 'regex:/^[a-zA-Z0-9\s\(\)%]+$/'],
            "infection_date" => ["required", 'date', 'date_format:Y-m-d'],
            "country" => ["required", 'min:2', "max:5"],
            "type" => ["required", 'in:Client,Employee'],
            "status" => ["required", 'in:not_started,in_progress,mitigated,false_positive']
        ];
    }
}
