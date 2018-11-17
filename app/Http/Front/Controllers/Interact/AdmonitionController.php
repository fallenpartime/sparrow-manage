<?php
/**
 * 师生互动
 * Date: 2018/10/27
 * Time: 9:38
 */
namespace App\Http\Front\Controllers\Interact;

use App\Http\Front\Actions\Interact\Admonition\ConsultAction;
use App\Http\Front\Actions\Interact\Admonition\FeedbackAction;
use App\Http\Front\Actions\Interact\Admonition\IndexAction;
use App\Http\Front\Controllers\Controller;
use Illuminate\Http\Request;

class AdmonitionController extends Controller
{
    /**
     * @param Request $request
     */
    public function index(Request $request)
    {
        return (new IndexAction($request))->run();
    }

    public function consult(Request $request)
    {
        return (new ConsultAction($request))->run();
    }

    public function feedback(Request $request)
    {
        return (new FeedbackAction($request))->run();
    }
}