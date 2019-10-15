<?php
namespace app\view\user;

use core\mvc\view\HtmlPage;
use app\model\UserModel;

final class NewUserView extends HtmlPage{

    public function __construct()
    {
        $this->model = new UserModel();
        $this->htmlFile = 'app/view/user/new_user_view.phtml';
    }

}