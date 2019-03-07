<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use App\Page;
use Illuminate\Support\Facades\Input;
use App\SeoSetting;
use Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class PageController extends Controller {
    /* ____________Show all Pages___________ */

    public function index() {
        $url = URL::to('/');

        $topPages = Page::where('location', 'top')->orderBy('order', 'asc')->get();

        /* _______________Create multi-demensional array for pages and sub pages__________ */


        /* ___________TOP LOCATION PAGES____________ */

        if ($topPages->count()) {
            foreach ($topPages as $topPage) {
                $topPage['subs'] = array();
                $indexedItems[$topPage->id] = $topPage;
            }

            $topLevel = array();
            if (count($indexedItems)) {
                foreach ($indexedItems as $item) {
                    if ($item->parent == 0) {
                        $topLevel[] = $item;
                    } else {
                        $temp = array();
                        $temp = $indexedItems[$item->parent]->subs;
                        array_push($temp, $item);
                        $indexedItems[$item->parent]->subs = $temp;
                    }
                }
            }
        } else {
            $topLevel = array();
        }

        /* ___________FOOTER LOCATION PAGES____________ */

        $footerPages = Page::where('location', 'bottom')->orderBy('order', 'asc')->get();

        if (count($footerPages) > 0) {
            foreach ($footerPages as $footerPage) {
                $footerPage['subs'] = array();
                $footerindexedItems[$footerPage->id] = $footerPage;
            }


            $footerLevel = array();
            if (count($footerindexedItems)) {
                foreach ($footerindexedItems as $footeritem) {
                    if ($footeritem->parent == 0) {
                        $footerLevel[] = $footeritem;
                    } else {
                        $temp = array();
                        $temp = $footerindexedItems[$footeritem->parent]->subs;
                        array_push($temp, $footeritem);
                        $footerindexedItems[$footeritem->parent]->subs = $temp;
                    }
                }
            }
        } else {
            $footerLevel = array();
        }

        return View::make('admin.pages.index', compact('topLevel', 'footerLevel', 'url'));
    }

    /* ____________ 'GET' HTTP METHOD FOR CREATE PAGE  ___________ */

    public function create() {

        $url = URL::to('/');

        $pagelisting = Page::orderBy('order', 'asc')->pluck('name', 'id');
        $topmenus = Page::where('location', 'top')->get();

        /* ___________TOP LOCATION PAGES____________ */
        if ($topmenus->count()) {
            foreach ($topmenus as $topmenu) {
                $topmenu['subs'] = array();
                $indexedItems[$topmenu->id] = $topmenu;
            }


            $topLevel = array();
            if (count($indexedItems)) {
                foreach ($indexedItems as $item) {
                    if ($item->parent == 0) {
                        $topLevel[] = $item;
                    } else {
                        $temp = array();
                        $temp = $indexedItems[$item->parent]->subs;
                        array_push($temp, $item);
                        $indexedItems[$item->parent]->subs = $temp;
                    }
                }
            }
        } else {
            $topLevel = array();
        }

        /* ___________ FOOTER LOCATION PAGES ____________ */
        $footermenus = Page::where('location', 'bottom')->get();

        if (count($footermenus) > 0) {
            foreach ($footermenus as $footermenu) {
                $footermenu['subs'] = array();
                $footerindexedItems[$footermenu->id] = $footermenu;
            }


            $footerLevel = array();
            if (count($footerindexedItems)) {
                foreach ($footerindexedItems as $footeritem) {
                    if ($footeritem->parent == 0) {
                        $footerLevel[] = $footeritem;
                    } else {
                        $temp = array();
                        $temp = $footerindexedItems[$footeritem->parent]->subs;
                        array_push($temp, $footeritem);
                        $footerindexedItems[$footeritem->parent]->subs = $temp;
                    }
                }
            }
        } else {
            $footerLevel = array();
        }

        // Render view with variables
        return View::make('admin.pages.create', compact('topLevel', 'footerLevel', 'pagelisting', 'url'));
    }

    /* ___________ 'POST' HTTP METHOD FOR CREATE PAGE  ____________ */

    public function store() {

        /*
         * Validations of required field and unique name
         */

        $rules = array(
            'name' => 'required|unique:pages'
        );

        //____Check validation rules on Input____
        $validator = Validator::make(Input::all(), $rules);

        $TotalPages = Page::all()->count();

        //_____Check Validation rules have any failure___
        if ($validator->fails()) {
            return Redirect::to('admin/page/create')
                            ->withErrors($validator);
        } else {
            /* Page */
            $page = new Page;
            $page['page_type'] = Input::get('page_type');
            $page['name'] = Input::get('name');

            $page['location'] = Input::get('location');
            $page['url'] = Input::get('url');
            $page['navigation_label'] = Input::get('navigation_label');
            $page['content'] = Input::get('content');
            $page['who_can_view'] = Input::get('who_can_view');
            $page['visibility'] = Input::get('visibility');

            if (Input::get('page_type') == 'main_page') {
                $page['parent'] = 0;
            } else {
                $page['parent'] = Input::get('parent');
            }

            $page['order'] = (int) $TotalPages + 1;
            $page['status'] = Input::get('status');

            $page->save();

            $seoSettings = new SeoSetting;

            $seoSettings['page_id'] = $page->id;
            ;
            $seoSettings['title'] = Input::get('page_seo_title');
            $seoSettings['keywords'] = Input::get('page_seo_keywords');
            $seoSettings['description'] = Input::get('page_seo_description');
            $seoSettings['status'] = 1;
            $seoSettings->save();
            Session::flash('alert-success', 'Successfully created Page!');
            return Redirect::to('admin/pages');
        }
    }

    public function edit($id) {

        $url = URL::to('/');
        /* ----  Fetch Top Menus  ----- */

        $pagelisting = Page::where('id', '!=', $id)->orderBy('order', 'asc')->pluck('name', 'id');

        $topmenus = Page::where('location', 'top')->orderBy('order', 'asc')->get();

        if ($topmenus->count()) {
            foreach ($topmenus as $topmenu) {
                $topmenu['subs'] = array();
                $indexedItems[$topmenu->id] = $topmenu;
            }


            $topLevel = array();
            if (count($indexedItems)) {
                foreach ($indexedItems as $item) {
                    if ($item->parent == 0) {
                        $topLevel[] = $item;
                    } else {
                        $temp = array();
                        $temp = $indexedItems[$item->parent]->subs;
                        array_push($temp, $item);
                        $indexedItems[$item->parent]->subs = $temp;
                    }
                }
            }
        } else {
            $topLevel = array();
        }

        /* ----  Fetch Footer Pages  ----- */
        $footermenus = Page::where('location', 'bottom')->get();

        if (count($footermenus) > 0) {
            foreach ($footermenus as $footermenu) {
                $footermenu['subs'] = array();
                $footerindexedItems[$footermenu->id] = $footermenu;
            }

            $footerLevel = array();
            if (count($footerindexedItems)) {
                foreach ($footerindexedItems as $footeritem) {
                    if ($footeritem->parent == 0) {
                        $footerLevel[] = $footeritem;
                    } else {
                        $temp = array();
                        $temp = $footerindexedItems[$footeritem->parent]->subs;
                        array_push($temp, $footeritem);
                        $footerindexedItems[$footeritem->parent]->subs = $temp;
                    }
                }
            }
        } else {
            $footerLevel = array();
        }


        $page = Page::find($id);
        $seosettings = SeoSetting::where('page_id', $page->id)->first();

        $page['page_seo_title'] = $seosettings->title;
        $page['page_seo_keywords'] = $seosettings->keywords;
        $page['page_seo_description'] = $seosettings->description;

        return View::make('admin.pages.edit', compact('page', 'topLevel', 'pagelisting', 'url', 'footerLevel'));
    }
    
    
    /**/
    public function update(Request $request, $id) {

        /*
         * Validations
         * --- Required field 
         * --- Unique name except current page
         */

        $rules = array(
            'name' => 'required|unique:pages,name,' . $id
        );

        $validator = Validator::make(Input::all(), $rules);

        $TotalPages = Page::all()->count();

        //_____Check Validation rules have any failure___
        if ($validator->fails()) {
            return Redirect::to('admin/page/' . $id . '/edit')
                            ->withErrors($validator);
        } else {
            /* Page */
            $page = Page::find($id);
            $page['page_type'] = Input::get('page_type');
            $page['name'] = Input::get('name');

            $page['location'] = Input::get('location');
            $page['url'] = Input::get('url');
            $page['navigation_label'] = Input::get('navigation_label');
            $page['content'] = Input::get('content');
            $page['who_can_view'] = Input::get('who_can_view');
            $page['visibility'] = Input::get('visibility');

            if (Input::get('page_type') == 'main_page') {
                $page['parent'] = 0;
            } else {
                $page['parent'] = Input::get('parent');
            }

            $page['order'] = (int) $TotalPages + 1;
            $page['status'] = Input::get('status');

            // Update The Page data
            $page->save();

            $seoSettings = SeoSetting::where('page_id', $id)->first();

            $seoSettings['title'] = Input::get('page_seo_title');
            $seoSettings['keywords'] = Input::get('page_seo_keywords');
            $seoSettings['description'] = Input::get('page_seo_description');
            $seoSettings['status'] = 1;

            // Update The SEO data for page.
            $seoSettings->save();
            
            Session::flash('alert-success', 'Successfully updated Page!');
            return Redirect::to('admin/pages');
        }
    }

    /*_________________Delete the Page_________________*/
    
    public function destroy($id) {

        $page = Page::find($id);
        $page->delete();

        $seosettings = SeoSetting::where('page_id', $id)->first();
        $seosettings->delete();

        // redirect
        Session::flash('alert-success', 'Successfully deleted the Page!');
        return Redirect::to('admin/pages');
    }

    /* __________Recursive function to get all page menus__________ */

    public static function renderMenu($items, $page = null) {

        $menus = $page['MenuReference'];
        $render = '<ul>';
        foreach ($items as $item) {

            if (count($menus) > 0) {
                foreach ($menus as $menu) {
                    if ($item->id == $menu['menu_id']) {
                        $checked = 'checked';
                    } else {
                        $checked = '';
                    }
                }
            } else {
                $checked = '';
            }

            $render .= '<li><i class="fa fa-file"></i><label>' . $item->name . '</label>';
            if (!empty($item->subs)) {
                $render .= PageController::renderMenu($item->subs, $page);
            }

            $render .= '</li>';
        }

        return $render . '</ul>';
    }

    /* ___________________Update the order of pages when drag and drop the page_______________ */

    public static function orderChange() {
        
        /*_______Check ajax request______*/
        
        if (Request::ajax()) {
            $data = Input::all();
            $order = $data['order'];
            $orders = explode(',', $order);
            $orders = array_filter($orders);
            $i = 1;
            foreach ($orders as $order) {
                $page = Page::find($order);
                $page->order = $i;
                
                //Update the page
                $page->save();
                $i++;
            }
        }
    }

}
