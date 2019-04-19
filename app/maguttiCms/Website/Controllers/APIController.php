<?php

namespace App\maguttiCms\Website\Controllers;

use App\Http\Controllers\Controller;
use App\maguttiCms\Website\Requests\AjaxFormRequest;
use Input;
use Validator;
use App\Newsletter;

class APIController extends Controller
{
    protected $articleRepo;

    /**
     * @return mixed
     */
    public function subscribeNewsletter( AjaxFormRequest $request  ) {
        $validator = Validator::make($request->all(), $request->rules());

        if ($validator->fails()) {
            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ));

        }else {

          // INSERT RECORD IN DATABASE
          $newsletter = new Newsletter;
          $newsletter->email = sanitizeParameter( $request->email );
          $saved = $newsletter->save();

          return response()->json(array(
            'status'=>'ok',
            'msg'   =>  trans('website.mail_message.subscribe_newsletter_feedback')
          ));

        }

    }

	public function updateGhost(AjaxFormRequest $request)
	{
		//	vars
		$id = $request->id;
		$model = $request->model;
		$field = $request->field;
		$value = $request->value;
		$response = ['alerts' => []];
		$status = 0;

		if (in_array($model, config('maguttiCms.website.option.ghost_input.models'))) {
			$model = app('App\\'.$model)::find($id);
			$model->$field = $value;
			$model->save();
			array_push($response['alerts'], [
				'text'	=> trans('website.ghost.updated'),
				'type'	=> 'success',
				'time'	=> 3
			]);
		}
		else {
			array_push($response['alerts'], [
				'text'	=> trans('website.ghost.forbidden'),
				'type'	=> 'warning',
				'time'	=> 5
			]);
		}
		return response()->json($response);
	}

}
