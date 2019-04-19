<?php namespace App\maguttiCms\Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Validator;
use Input;

use \App\maguttiCms\Admin\Helpers\AdminUserTrackerTrait;
use App\maguttiCms\Admin\Requests\AdminFormRequest;
use App\maguttiCms\Searchable\SearchableTrait;
use App\maguttiCms\Sluggable\SluggableTrait;
use App\maguttiCms\Tools\UploadManager;

/**
 * Class AdminPagesController
 * @package App\maguttiCms\Admin\Controllers
 */
class AdminPagesController extends Controller
{
    use SluggableTrait;
    use SearchableTrait;
    use AdminUserTrackerTrait;

    protected $model;
    protected $models;
    protected $modelClass;
    protected $curObject;
    protected $request;
    protected $config;
    protected $id;

    /**
     * @param $model
     */
    public function init($model)
    {
        $this->model = $model;
        $this->config = config('maguttiCms.admin.list.section.' . $this->model);
        $this->models = strtolower(Str::plural($this->config['model']));
        $this->modelClass = 'App\\' . $this->config['model'];
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function home()
    {
        return view('admin.home');
    }

    /**
     * @param Request $request
     * @param $model
     * @param string $sub
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function lista(Request $request, $model, $sub = '')
    {
        $this->request = $request;
        $this->init($model);
        $models = new $this->modelClass;
        $objBuilder = $models::query();
        $this->setCurModel($models);

        $this->joinable($objBuilder);
        $this->whereFilter($objBuilder);
        $this->searchFilter($objBuilder);
        $this->orderFilter($objBuilder);

        $this->withRelation($objBuilder);

        if( $this->isTranslatableField($this->sort)) {
            $objBuilder->select($this->model->getTable().'.*');
        }
        $articles = $objBuilder->paginate(config('maguttiCms.admin.list.item_per_pages'));
        $articles->appends(request()->input())->links(); // paginazione con parametri di ricerca

		$fieldspec = $models->getFieldspec();

        return view('admin.list', ['articles' => $articles, 'pageConfig' => $this->config, 'fieldspec' => $fieldspec, 'model' => $this->models]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $model
     *
     * @return Response
     */
    public function create($model)
    {
        $this->init($model);
        $article = new $this->modelClass;
        return view('admin.edit', ['article' => $article, 'pageConfig' => $this->config]);
    }

    /**
     * Show the form for editing
     * the specified resource.
     *
     * @param $model
     * @param  int $id
     *
     * @return Response
     */
    public function edit($model, $id)
    {
        $this->id = $id;
        $this->init($model);
        $model = new  $this->modelClass;
        $article = $model::whereId($this->id)->firstOrFail();
        /** @var  gestione pageTemplate */
        $this->pageTemplate = (isset($this->config['editTemplate'])) ? $this->config['editTemplate'] : 'admin.edit';
        return view( $this->pageTemplate, ['article' => $article, 'pageConfig' => $this->config]);
    }

    /**
     *
     * GF_ma view controller
     * @param $model
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function view($model, $id)
    {
        $this->id = $id;
        $this->init($model);
        $model = new  $this->modelClass;
        $article = $model::whereId($this->id)->firstOrFail();
        $this->pageTemplate = (isset($this->config['viewTemplate'])) ? $this->config['viewTemplate'] : 'admin.view';
        return view( $this->pageTemplate, ['article' => $article, 'pageConfig' => $this->config]);
    }

    /**
     * @param $model
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editmodal($model, $id)
    {
        $this->id = $id;
        $this->init($model);
        $model = new  $this->modelClass;
        $article = $model::whereId($this->id)->firstOrFail();
        return view('admin.editmodal', ['article' => $article, 'pageConfig' => $this->config]);
    }

    /**
     * Store a newly created
     * resource in storage.
     *
     * @param $model
     * @param AdminFormRequest $request
     *
     * @return Response
     */
    public function store($model, AdminFormRequest $request)
    {
        $this->init($model);
        $this->request = $request;
        $config = config('maguttiCms.admin.list.section.' . $model);
        $model  = new  $this->modelClass;
        $article = new $model;
        // input data Handler
        $this->requestFieldHandler($article);

        session()->flash('success', 'The item <strong>' . $article->title . '</strong> has been created!');
        return redirect(action('\App\maguttiCms\Admin\Controllers\AdminPagesController@edit', $this->models . '/' . $article->id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $model
     * @param  int $id
     * @param AdminFormRequest $request
     *
     * @return Response
     */
    public function update($model, $id, AdminFormRequest $request)
    {
        $this->init($model);
        $this->request = $request;
        $model   = new  $this->modelClass;
        $article = $model::whereId($id)->firstOrFail();
        // input data Handler
        $this->requestFieldHandler($article);
        return redirect(action('\App\maguttiCms\Admin\Controllers\AdminPagesController@edit', $this->models . '/' . $article->id));

    }


    /**
     * SIMPLE DUPLICATE FUNCTION
     * FOR NOW DUPLICATE A
     * RECORD WITHOUT IS
     * RELATION
     *
     * TODO RELATION DUPLICATION
     * @param $model
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function duplicate($model, $id)
    {
        $this->init($model);
        $model      = new  $this->modelClass;
        $oldArticle =  $model::find($id);
        $article    =  $oldArticle->replicate();

        $article->save();
        return redirect(action('\App\maguttiCms\Admin\Controllers\AdminPagesController@edit', $this->models . '/' . $article->id));
    }

    /**
     * Update the specified resource
     * in storage.
     *
     * @param $model
     * @param  int $id
     * @param AdminFormRequest $request
     *
     * @return Response
     */
    public function updatemodal($model, $id, AdminFormRequest $request)
    {
        $this->init($model);
        $this->request = $request;
        $model = new  $this->modelClass;
        $article = $model::whereId($id)->firstOrFail();
        // input data Handler
        $this->requestFieldHandler($article);
        echo json_encode(array('status' => $this->config['model'] . ' Has been update'));
    }

    /**
     * Remove the specified resource
     * from storage.
     *
     * @param $model
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($model, $id)
    {
        $this->init($model);
        $this->id = $id;
        $model = new  $this->modelClass;
        $article = $model::whereId($this->id)->firstOrFail();
        $article->delete();
        flash('success', 'The items ' . $article->title . ' has been deleted!');

        return redirect(action('\App\maguttiCms\Admin\Controllers\AdminPagesController@lista', $this->models));
    }

    /**
     * @param $article
     */
    public function requestFieldHandler($article)
    {
        foreach ($article->getFillable() as $a) {
            if($this->request->has($a))$article->$a = $this->request->get($a);
        }

        if (isset($article->sluggable)) {
            foreach ($article->sluggable as $key => $a) {

                if(!$this->slugIsTranslatable($a) ) {
                    $slug_value    = $this->request->get($key);
                    $source_value  = $this->request->get($a['field']);
                    $article->$key = $this->setSlugAttributes($a)
                                          ->sluggy($article, $slug_value,$source_value);
                }
            }
        }

        /** tiene traccia dell'utente che ha fatto le modifiche */
        $this->hackedBy($article);

        $this->processMedia($article);

        $article->save();
        // many to many relation
        /* TODO -> create  dimanic  check roles */
        if (method_exists($article, 'saveRoles'))       $article->saveRoles($this->request->get('role'));
        if (method_exists($article, 'saveTags'))        $article->saveTags($this->request->get('tag'));
        if (method_exists($article, 'saveArticles'))    $article->saveArticles($this->request->get('example_articles'));
        if (method_exists($article, 'saveCountries'))   $article->saveCountries($this->request->get('country'));

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
    }

    /**
     * Perform the media upload
     * @param $model
     * @param $media
     */
    private function mediaHandler($model,$media, $disk = '', $folder = '')
    {
        $UM = new UploadManager;
        $model->$media = ($UM->init($media, $this->request, $disk, $folder)->store()->getFileFullName()) ? :  $model->$media;
    }

    /**
     * PROCESS ALL THE
     * MEDIA FILES
     * @param $model
     */
    private function processMedia($model)
    {
        foreach ($model->getFieldSpec() as $key => $field) {
            if ($field['type'] == 'media') {

				$disk   = (isset($field['disk']))? $field['disk']: '';
				$folder = (isset($field['folder']))? $field['folder']: '';

                $this->mediaHandler($model, $key, $disk, $folder);
            }
        }
    }

	// questa funzione recupera solo i file non immagine. Per le immagini è già presente l'anteprima.
	public function get_file($object, $key) {
		$fields = $object->getFieldSpec();

		$disk = (isset($fields[$key]['disk'])) ? $fields[$key]['disk'] : 'media';
		$folder = (isset($fields[$key]['folder'])) ? $fields[$key]['folder'] : 'docs';

		$storage = \Storage::disk($disk);

		if ($storage->exists($folder.'/'.$object->$key))
			return [
				'file' => $storage->get($folder.'/'.$object->$key),
				'mime' => $storage->mimeType($folder.'/'.$object->$key)
			];
		else
			return false;
	}

	public function file_view($model, $id, $key) {
		$this->id = $id;
        $this->init($model);
        $model = new $this->modelClass;
        $article = $model::whereId($this->id)->firstOrFail();

		if ($article) {
			$file = $this->get_file($article, $key);
			if ($file['file']) {
				return response()->make($file['file'], 200, [
				    'Content-Type' => $file['mime'],
				    'Content-Disposition' => 'inline; filename="'.$article->$key.'"'
				]);
			}
		}
	}
}
