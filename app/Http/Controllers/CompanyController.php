<?php

namespace App\Http\Controllers;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function store(Request $request)
    {
        $company = Company::create([
            'name' => $request->name,
        ]);
        $company->addMediaFromRequest('photo')->toMediaCollection('companies');

        return 'Success';
    }


public function show(Company $company)
{
    $media = $company->getMedia('companies');

    if ($media->count() > 0) {
        $url = $media[0]->getUrl();
    } else {
        $url = 'default-url.jpg';
    }
    return response("Company: {$company->name}\r\n\r\n<br />\r\n\r\n<img src=\"$url\" />\r\n");
}

}
