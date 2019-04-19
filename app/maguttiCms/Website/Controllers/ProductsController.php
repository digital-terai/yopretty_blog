<?php

namespace App\maguttiCms\Website\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\maguttiCms\Website\Repos\Article\ArticleRepositoryInterface;
use App\maguttiCms\Website\Repos\Product\ProductRepositoryInterface;
use App\maguttiCms\Website\Repos\Category\CategoryRepositoryInterface;
use Input;
use Validator;
use App\Category;
use App\Product;
use App\Domain;

/**
* Class ProductsController
* @package App\maguttiCms\Website\Controllers
*/
class ProductsController extends Controller
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
	* @var ProductRepositoryInterface
	*/
	protected  $productRepo;
	/**
	* @var CategoryRepositoryInterface
	*/
	protected  $categoryRepo;

	/**
	* ProductsController constructor.
	* @param ArticleRepositoryInterface $article
	* @param ProductRepositoryInterface $product
	* @param CategoryRepositoryInterface $product
	*/
	public function __construct(ArticleRepositoryInterface $article, ProductRepositoryInterface $product, CategoryRepositoryInterface $category){
		$this->articleRepo = $article;
		$this->productRepo = $product;
		$this->categoryRepo = $category;
	}

	/**
	* @param string $product_slug
	* @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	*/
	public function category($category_slug = '') {
		$article = $this->articleRepo->getBySlug('products');
		if ($category_slug == '') {
            // lista categorie
			$categories = Category::published()->get();
			$this->setSeo($article);
			return view('website.categories', ['article' => $article, 'categories' => $categories]);
		}
		else {
			// categoria singola
			$category = $this->categoryRepo->getBySlug($category_slug);
			if ($category) {
				$this->setSeo($category);
				$locale_article = $category;
				$products = $category->products()->published()->orderBy('sort')->get();
				return view('website.category', compact('article', 'category', 'products', 'locale_article'));
			}
			else return redirect('/');
		}
	}

    /**
     * @param string $product_slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function products($category_slug = '', $product_slug='' ) {
      	$article = $this->articleRepo->getBySlug('products');
        if ($product_slug == '' ) {
			$categories = Category::published()->get();
            $product  = $this->productRepo->getPublished();
            $this->setSeo($article);
            return view('website.products', compact('article', 'products', 'categories')); //LISTA PRODOTTI
        }
		else {
			// singolo prodotto
			$article = $this->articleRepo->getBySlug('prodotti');
			$product = $this->productRepo->getBySlug($product_slug);
			if ($product) {
				$category = $product->category;
				$locale_article = $product;
				$this->setSeo($product);
				return view('website.product', compact('article', 'product', 'category', 'locale_article'));
			}
			else return redirect('/');
		}
    }
}
