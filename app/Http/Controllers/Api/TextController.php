<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\NLPService;
use Illuminate\Http\Request;

class TextController extends Controller
{
    protected $nlpService;
    public function __construct(NLPService $nlpService)
    {
        $this->nlpService = $nlpService;
    }

    public function summarize(Request $request)
    {
        $text = $request->input('text');
        return $this->nlpService->summarizeText($text);
    }

    public function translate(Request $request)
    {
        $text = $request->input('text');
        return $this->nlpService->translateText($text, 'eng_Latn', 'arz_Arab');
    }

    public function sentiment(Request $request)
    {
        $text = $request->input('text');
        return $this->nlpService->analyzeSentiment($text);
    }

    public function entity(Request $request)
    {
        $text = $request->input('text');
        return $this->nlpService->namedEntityRecognition($text);
    }
}
