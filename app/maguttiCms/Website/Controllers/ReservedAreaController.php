<?php

namespace App\maguttiCms\Website\Controllers;

use App\maguttiCms\Website\Requests\WebsiteFormRequest;
use App\Country;
use App\Address;
use App\Http\Controllers\Controller;
use App\maguttiCms\Website\Repos\Article\ArticleRepositoryInterface;
use Auth;
use Input;
use Validator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;

class ReservedAreaController extends Controller

{
	use \App\maguttiCms\SeoTools\MaguttiCmsSeoTrait;
    /**
     * @var
     */
    protected  $template;
    /**
     * @var ArticleRepositoryInterface
     */
    protected  $articleRepo;


    /**
     * @param ArticleRepositoryInterface $article
     *
     */

    public function __construct(ArticleRepositoryInterface $article )
    {
        $this->articleRepo = $article;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function dashboard()
    {
        $article =$this->articleRepo->getBySlug('dashboard');
        $this->setSeo($article);
		$user = Auth::user();
		$orders = $user->orders()->list()->get();
		$addresses = $user->addresses;
        return view('website.users.dashboard', compact('article', 'orders', 'addresses'));
    }

    public function profile()
    {
        $article =$this->articleRepo->getBySlug('profile');
        $this->setSeo($article);
        return view('website.users.profile', compact('article'));
    }

	public function addressNew()
	{
		$previous = url()->previous();
		$countries = Country::list()->get();
		return view('website.users.address_new', compact('countries', 'previous'));
	}

	public function addressCreate(WebsiteFormRequest $request)
	{
		$user = Auth::user();

		$address = Address::create([
			'user_id'	 => $user->id,
			'street'	 => $request->street,
			'number'	 => $request->number,
			'zip_code'	 => $request->zip_code,
			'city'	     => $request->city,
			'province'	 => $request->province,
			'country_id' => $request->country_id,
			'phone'	     => $request->phone,
			'mobile'	 => $request->mobile,
			'email'	     => $request->email,
			'vat'		 => $request->vat
		]);

		if ($request->previous)
			return Redirect::to($request->previous);
		else
			return Redirect::to('/users/dashboard');
	}
}
