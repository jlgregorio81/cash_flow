<?php
namespace app\view\category;

use core\mvc\view\HtmlPage;
use app\model\CategoryModel;

final class CategoryList extends HtmlPage{

    public function __construct($model = null)
    {
        parent::__construct($model);
        $this->htmlFile = 'app/view/category/category_list.phtml';
    }
    
}