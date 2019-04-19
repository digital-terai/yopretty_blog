<?php

namespace App\maguttiCms\Admin\Controllers;


use App\Article;
use App\maguttiCms\Exports\CollectionExport;
use App\maguttiCms\Tools\ExportHelper;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Input;

use Maatwebsite\Excel\Facades\Excel;
use Validator;


/**
 * Class AdminExportController
 * @package App\maguttiCms\Admin\Controllers
 */
class AdminExportController extends Controller
{
    protected $model;
    protected $models;
    protected $modelClass;
    protected $curObject;
    protected $request;
    protected $config;
    protected $id;


    /**
     * @param Request $request
     * @param $model
     * @param string $sub
     */
    public function lista(Request $request, $model, $sub = '')
    {

        $ExportHelper = new  ExportHelper();
        $data     = $ExportHelper->init($model)->getDataToExport();
        $filename = $ExportHelper->getFileName();
        return Excel::download(new CollectionExport($data), $filename);
    }
}
