<?php
namespace app\view\category;

use core\mvc\view\HtmlPage;
use app\model\CategoryModel;

final class CategoryView extends HtmlPage{

    public function __construct(CategoryModel $model = null)
    {
        $this->model = is_null($model) ? new CategoryModel() : $model;
        $this->htmlFile = 'app/view/category/category_view.phtml';
    }

    

}