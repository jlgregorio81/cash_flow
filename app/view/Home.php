<?php
namespace app\view;

use core\mvc\view\HtmlPage;
use app\dao\FlowDao;
use core\util\Strings;

final class Home extends HtmlPage
{

    protected $expensesChart; //..data to show in pie chart
    protected $expensesVsReceiptsChart; //..data to show in bar chart


    protected $expenses;
    protected $receipts;

    protected $currentBalance;

    public function __construct()
    {
        $this->htmlFile = 'app/view/home.phtml';
    }

    public function getExpensesChartData()
    {
        //get the data to generate the chart
        $currentMonth = (new \DateTime())->format('m');
        $data = (new FlowDao())->getFlowPerCategory($currentMonth, 'E');
        //..pie chart --> documentation: https://google-developers.appspot.com/chart/interactive/docs/gallery/piechart
        if ($data) {
            $stringChart = '[';
            $stringChart .= "['Categoria','Valor'],";
            foreach ($data as $row) {
                $stringChart .= "['{$row['name']}',{$row['value']}],";
            }
            $stringChart .= ']';
            $this->expensesChart = $stringChart;
        }
    }

    public function getReceiptsVsExpensesChartData()
    {
        $flowDao = new FlowDao();
        $currentDate = (new \DateTime())->format('Y-m-d');
        $anotherDate = '1900-01-01';
        $this->expenses = $flowDao->getFlows('E', $anotherDate, $currentDate);
        $this->receipts = $flowDao->getFlows('R', $anotherDate, $currentDate);

        if ($this->expenses || $this->receipts) {
            $this->expensesVsReceiptsChart = "[
            ['Tipo', 'Valor', {role: 'style'}],
            ['Receitas', {$this->receipts}, 'navy'],
            ['Despesas', {$this->expenses}, 'red'],
        ]";
        }
    }
}
