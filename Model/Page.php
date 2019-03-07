<?php
 
namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model {

    protected $table = 'pages';

    public function SeoSetting() {
        return $this->hasOne('App\SeoSetting', 'page_id');
    }

}
