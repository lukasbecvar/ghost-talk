<?php

namespace App\Managers;

use App\Utils\SiteUtil;
use Illuminate\Contracts\View\Factory as ViewFactory;

class ErrorManager 
{
    private ViewFactory $view;
    private SiteUtil $siteUtil;

    public function __construct(ViewFactory $view, SiteUtil $siteUtil)
    {
        $this->view = $view;
        $this->siteUtil = $siteUtil;
    }

    public function handleError(int $code, string $message): void 
    {
        $error_json = [
            'status' => 'error',
            'code' => $code,
            'message' => $message
        ];

        if ($this->siteUtil->isDevMode()) {
            die(json_encode($error_json));
        } else {
            $this->handleErrorView($code);
        }
    }

    public function handleErrorView(int $code): void
    {
        $viewContent = $this->view->make('error/error_'.$code)->render();

        echo $viewContent;
    }
}
