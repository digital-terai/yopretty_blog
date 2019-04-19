<?php

namespace App\maguttiCms\Website\Controllers;

use App\maguttiCms\Website\Repos\Article\ArticleRepositoryInterface;
use App\maguttiCms\Website\Repos\News\NewsRepositoryInterface;
use App\Http\Controllers\Controller;
use App\News;
use Input;
use Validator;

use App\FaqCategory;
use App\Product;
use Domain;


class PagesController extends Controller

{
    use \App\maguttiCms\SeoTools\MaguttiCmsSeoTrait;
    /**
     * @var
     */
    protected $template;
    /**
     * @var ArticleRepositoryInterface
     */
    protected $articleRepo;
    /**
     * @var NewsRepositoryInterface
     */
    protected $newsRepo;
    /**
     * @var
     */
    private $news;

    /**
     * @param ArticleRepositoryInterface $article
     * @param PostRepositoryInterface $news
     */

    public function __construct(ArticleRepositoryInterface $article, NewsRepositoryInterface $news)
    {
        $this->articleRepo = $article;
        $this->newsRepo = $news;

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function home()
    {
        $article = $this->articleRepo->getBySlug('home');
        $this->setSeo($article);

         $news= News::all();
        return view('website.home', compact('article'))->with('news',$news);
    }

    /**
     * @param $parent
     * @param string $child
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function pages($parent, $child = '')
    {
        $article = (!$child) ? $this->articleRepo->getParentPage($parent, app()->getLocale()) : $this->articleRepo->getSubPage($parent, $child);

        // Get website default locale
        $fallback_locale = \Config::get('app.fallback_locale');

        if ($article && $article->slug != 'home' && $article->pub == 1) {
            $this->setSeo($article);
            $this->template = ($article->template_id) ? $article->template->value : $article->{'slug:' . $fallback_locale};
            if (view()->exists('website.' . $this->template)) {
                return view('website.' . $this->template, compact('article'));
            }
            return view('website.normal', compact('article'));
        } else {
            return redirect(url_locale('/'));
        }

    }

    public function test()
    {
        phpinfo();
        die();
    }

    /**
     * @param int $parameter
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function contacts()
    {
        $article = $this->articleRepo->getBySlug('contatti');
        $parameter = Input::get('product_id');

        if ($parameter) {
            $product = Product::findOrFail($parameter);
            $info_request = 'Buongiorno, vorrei ricevere maggiori informazioni riguardo al prodotto "' . $product->title . '" del ' . $product->year . '.';
            return view('website.contacts', ['request_product_id' => $parameter, 'product' => $product, 'article' => $article]);
        } else {
            return view('website.contacts', ['request_product_id' => 0, 'article' => $article]);
        }
    }

    /**
     * @param string $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function news($slug = '')
    {
        $article = $this->articleRepo->getBySlug('news');

        if ($slug == '') {
            $this->setSeo($article);
            $news = $this->newsRepo->getPublished();
            return view('website.news.home', compact('article', 'news'));
        } else {
            $news = $this->newsRepo->getBySlug($slug, app()->getLocale());
            if ($news) {
                $this->setSeo($news);
                $locale_article = $news;
                return view('website.news.single', compact('article', 'news', 'locale_article'));
            }
            return redirect(url_locale('/'));
        }
    }
}