<?php
namespace app\view\user;

use core\mvc\view\HtmlPage;
use app\model\UserModel;

final class UserView extends HtmlPage{

    public function __construct(UserModel $model = null)
    {
        $this->htmlFile = 'app/view/user/user_view.phtml';
        $this->model = is_null($model) ? new UserModel() : $model;
    }

}