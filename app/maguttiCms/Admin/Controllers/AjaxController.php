<?php namespace App\maguttiCms\Admin\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Input;
use Image;
use App\maguttiCms\Tools\UploadManager;
use App\Media;

class AjaxController extends Controller
{
    private $responseContainer = ['status' => 'ko', 'message' => '', 'error' => '', 'data' => ''];
    protected $request;

    public function update($action, $model, $id = '', Request $request)
    {
        $this->request = $request;
        switch ($action) {
            case "updateItemField":

                if ($this->request->input('field')) {
                    $field = $this->request->input('field');
                    $value = $this->request->input('value');
                    $modelClass = 'App\\' . $model;
                    $object = $modelClass::whereId($id)->firstOrFail();
                    $object->$field = $value;
                    $object->save();
                    $this->responseContainer['status'] = 'ok';
                    $this->responseContainer['message'] = 'Data has been updated';
                    $this->responseContainer['data'] = $object;
                }
                break;
        }
        return $this->responseHandler();
    }

    public function delete($model, $id = '')
    {

        $modelClass = 'App\\' . ucFirst($model);
        $object = $modelClass::whereId($id)->first();
        if (is_object($object)) {
            $object->delete();
            $this->responseContainer['status'] = 'ok';
            $this->responseContainer['message'] = 'Data has been deleted';
        } else $this->responseContainer['error'] = 'Data not found';
        return $this->responseHandler();
    }


    /*
    |--------------------------------------------------------------------------
    |  Upload File using Ajax Method
    |--------------------------------------------------------------------------
    |  Filesystem Disk = > media
    |
    |
     */
    public function uploadifiveSingle(Request $request)
    {
		$modelClass = 'App\\' . $request->model;
		$object = new $modelClass;
		$fieldspec = $object->getFieldSpec();
		$disk = (isset($fieldspec[$request->key]['disk']))? $fieldspec[$request->key]['disk']: '';
		$folder = (isset($fieldspec[$request->key]['folder']))? $fieldspec[$request->key]['folder']: '';

        $media = 'Filedata';
        if (Input::hasFile($media) && Input::file($media)->isValid()) {

            $UM              = new UploadManager;
            $fileData        = $UM->init($media, $request, $disk, $folder)->store()->getFileDetails();

            // $disk            = "media";
            // $destinationPath = $disk.'/' .$fileData['mediaType']; // upload path folder
            // if (is_image($fileData['mediaType']) == 'image') {
            //     //$img = Image::make($newMedia->getRealPath());
            //     $img = Image::make(public_path( $destinationPath . '/' . $fileData['fullName'] ))->widen(1600);
            //     // save file as png with medium quality
            //     $img->save(public_path($destinationPath . '/' . $fileData['fullName'], 60));
            // }

            $this->responseContainer['status'] = 'ok';
            $this->responseContainer['data']   = $fileData['mediaType'];
			$this->responseContainer['filename'] = $fileData['fullName'];
            return $this->responseHandler();
        }
    }

    /*
    |--------------------------------------------------------------------------
    |  Upload File using Ajax Method
    |--------------------------------------------------------------------------
    |  Filesystem Disk = > media
    |
    |
     */
    public function uploadifiveMedia(Request $request)
    {
		$modelClass = 'App\\' . $request->model;
		$object = new $modelClass;
		$fieldspec = $object->getFieldSpec();
		$disk = (isset($fieldspec[$request->key]['disk']))? $fieldspec[$request->key]['disk']: '';
		$folder = (isset($fieldspec[$request->key]['folder']))? $fieldspec[$request->key]['folder']: '';

        $media = 'Filedata';
        if (Input::hasFile($media) && Input::file($media)->isValid()) {

            $UM              = new UploadManager;
            $fileData        = $UM->init($media, $request, $disk, $folder)->store()->getFileDetails();

            // $disk            = "media";
            // $destinationPath = $disk.'/' .$fileData['mediaType']; // upload path folder
            // if (is_image($fileData['mediaType']) == 'image') {
            //     //$img = Image::make($newMedia->getRealPath());
            //     $img = Image::make(public_path( $destinationPath . '/' . $fileData['fullName'] ))->widen(1600);
            //     // save file as png with medium quality
            //     $img->save(public_path($destinationPath . '/' . $fileData['fullName'], 60));
            // }

            /**
             * SAVE THE DATA TO
             * THE MEDIA MODEL
             */

            $modelClass = 'App\\' . $request->model;
            $list       = $modelClass::find($request->Id);

            $c = new Media;
            $c->title               = $fileData['fullName'];
            $c->file_name           = $fileData['fullName'];
            $c->size                = $fileData['size'];
            $c->collection_name     = $fileData['mediaType'];
            $c->disk                = $disk;
            $c->media_category_id   = ($request->has('myImgType'))? $request->myImgType: 1;
            $c->file_ext            = $fileData['extension'];
            $list->media()->save($c);

            $this->responseContainer['status'] = 'ok';
            $this->responseContainer['data']   = $fileData['mediaType'];
            return $this->responseHandler();
        }
    }

    public function updateMediaList($mediaType, $model, $id = '')
    {
        $modelClass = 'App\\' . ucfirst($model);
        $object = $modelClass::whereId($id)->firstOrFail();
        if ($mediaType == 'images') return view('admin.helper.images_list_gallery', ['article' => $object]);
        else return view('admin.helper.docs_list', ['article' => $object]);
    }



    public function updateModelMediaList($modelFilter)
    {
        $object = Media::orderBy('id','DESC')->get();
        return view('admin.helper.modal_media_gallery', ['medias' => $object]);
    }





    public function updateMediaSortList(Request $request)
    {
        $i = 1;

        $input = Input::all();
        foreach ($input as $key => $items) {
            $dataObject = explode('_', $key);
            foreach ($items as $id) {
                $modelClass = 'App\\' . ucfirst($dataObject[1]);
                $object = $modelClass::whereId($id)->firstOrFail();
                $object->sort = $i * 10;
                $object->save();
                $i++;
            };
        };
    }

    public function responseHandler()
    {
        return response()->json($this->responseContainer);
    }

    /**
     * This method is used to upload filemanager image or docs
     */
     public function uploadFileManager(Request $request)
     {

        $media = 'Filedata';

        if (Input::hasFile($media) && Input::file($media)->isValid()) {

          $UM = new UploadManager;
          $fileData = $UM->init($media, $request)->store()->getFileDetails();

          $c = new Media;
          $c->title = $fileData['fullName'];
          $c->file_name = $fileData['fullName'];
          $c->size = $fileData['size'];
          $c->collection_name = $fileData['mediaType'];
          $c->media_category_id = 0;
          $c->file_ext = $fileData['extension'];
          $c->save();

          $this->responseContainer['status'] = 'ok';
          $this->responseContainer['id'] = $c->id;
          $this->responseContainer['data'] = $fileData['mediaType'];

          return $this->responseHandler();

        }

     }

    /**
     * This method is used to fetch filemanager media list
     */
    public function getFileManagerList($id='')
    {
        $object = (new Media)->when($id, function($query) use ($id) {
                                $query-> orderByRaw('IF(FIELD(id,'.$id.')=0,1,0)');
                            })
                            ->orderBy('id','DESC')->get();
        return view('admin.helper.filemanager-list', ['medias' => $object]);
    }

    /**
     * This method is used to fetch edit view
     */
    public function editFileManager($id)
    {
      $media = Media::whereId($id)->firstOrFail();
      return view('admin.helper.filemanager-edit', ['media' => $media]);
    }

    /**
     * This method is used to save the edit data
     */
     public function updateFileManager($id, Request $request)
     {

       $article = Media::find($id);

       $this->request = $request;

       foreach ($article->getFillable() as $a) {
           $article->$a = $this->request->get($a);
       }

       $article->save();

       // translatable
       if (isset($article->translatedAttributes) && count($article->translatedAttributes) > 0) {
           foreach (config('app.locales') as $locale => $value) {
               foreach ($article->translatedAttributes as $attribute) {
                   // se è un attributo sluggabile;
                   if(isset($article->sluggable) && $this->attributeIsSluggable($attribute,$article->sluggable)){
                       $attribute_to_slug = (config('app.locale') != $locale) ? $attribute.'_' . $locale:$attribute;
                       $string_value      = $this->setSlugAttributes($a)
                                                  ->sluggyTranslatable($article,$this->request->get($attribute_to_slug),$locale);

                       $article->translateOrNew($locale)->$attribute = $string_value;
                   }
                   else {
                       if (config('app.locale') != $locale) $article->translateOrNew($locale)->$attribute = $this->request->get($attribute . '_' . $locale);
                       else $article->translateOrNew($locale)->$attribute = $this->request->get($attribute);
                   }
               }
               $article->save();
           }
       }

       $this->responseContainer['status'] = 'ok';
       $this->responseContainer['message'] = 'Data has been updated';

       return $this->responseHandler();
     }

    /**
     * This method is used to perform a search for select 2 suggestion fields.
     *
     * @param Request $request: The current select 2 request.
     *
     * @return \Illuminate\Http\JsonResponse: The JSON representation of the result.
     */
    public function suggest(Request $request)
    {
        // Validate the request.
        $this->validate($request, [
            'q' => 'required',
            'model' => 'required',
            'value' => 'required',
            'caption' => 'required',
        ]);

        // Set convenience variables.
        $term = $request->q;
        $model = getModelFromString($request->model);
        $value = $request->value;
        $caption = $request->caption;
        $searchField = (isset($request->searchFields) && $request->searchFields!='') ? $request->searchFields:$caption;


        /*
         * Make sure that the user can access this data (meaning he has sufficient role permissions).
         * Permissions should be set on the relevant model, for example User model could have:
         *
         *     public $ajaxAccessibilityRoles = ['su', 'admin']; // Super user and admin can perform a search.
         *
         * If roles are not set the accessibility is considered 'public'.
         */
        if (property_exists(get_class($model), 'ajaxAccessibilityRoles')) {

            $accessAllowed = false;
            foreach ($model->ajaxAccessibilityRoles as $role) {

                if (Auth::guard('admin')->user()->hasRole($role))
                    $accessAllowed = true;
            }

            // The user is not allowed to perform this query, just return without any error message.
            if (!$accessAllowed)
                return response()->json([]);
        }
        // Check if the field is translatable.
        if ($this->isTranslatableField($model, $caption)) {
            $records = $model::whereTranslationLike($caption, "%{$term}%");
        }
        else {

            // This is the simplest case where we know exactly what's the field to search.
            $records = $model::select('*');
            $seachFieldsList =explode(',',$searchField);
            foreach( $seachFieldsList as $_field){
                $records->orWhere($_field,'like',"%{$term}%");
            }
        }

        if ($request->has('where') && $request->where != '')
            $records = $records->whereRaw($request->where);

        $records = $records->get();


        // Build the response and return.
        $items = $this->buildSuggestResponse($records, $value, $caption);
        return response()->json($items);
    }

    /**
     * This method is used to build an array response suitable for select 2.
     * Note: the result must be converted to JSON before sending it over.
     *
     * @param $records: The records to iterate.
     * @param $value: The 'key' of key => value array.
     * @param $caption: The 'value' of key => value array.
     *
     * @return array: The array of items.
     */
    public function buildSuggestResponse($records, $value, $caption)
    {
        $items = [];
        foreach ($records as $record) {

            $items[] = [
                'id'    => $record->$value,
                'value' => $record->$caption
            ];
        }

        return $items;
    }

    /**
     * Edited: GF_ma check if the field is translatable.
     *
     * @param $model: The model.
     * @param $key: The field to look for.
     *
     * @return bool: True if translatable, false otherwise.
     */
    protected function isTranslatableField($model, $key)
    {
        return (property_exists($model, 'translatedAttributes') && in_array($key, $model->translatedAttributes));
    }
}