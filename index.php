<?php
require_once('autoload.php');

use app\dao\CategoryDao;
use app\view\category\CategoryReport;
use core\Application;

Application::start();


//testing report with dao without controller.
//..retrieve the data
//$cat = (new CategoryDao())->select();
//..creates a CategoryReport
//$rpt = new CategoryReport();
//..set the data
//$rpt->setData($cat);
//..generates the report
//$rpt->Output('I');

