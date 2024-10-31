<?php

namespace App\Services;

use App\Http\Helpers\ApiResponse;
use Illuminate\Support\Facades\Redis;
use NLPCloud\NLPCloud;
use Predis\Connection\ConnectionException;

class NLPService
{
    protected $client;

    private function initializeClient($model, $useGpu = false, $languageCode = null)
    {
        $this->client = new NLPCloud(
            $model,
            config('services.nlp.api_key'),
            $useGpu,
            $languageCode
        );
    }

    private function cacheOrFetch($cacheKey, $callback, $expiration = 20)
    {
        try {
            // Check Redis cache for existing data
            $cachedData = Redis::get($cacheKey);
            if ($cachedData) {
                return ApiResponse::sendResponse(
                    json_decode($cachedData, true, 512, JSON_THROW_ON_ERROR),
                    'Data retrieved from cache',
                );
            }

            // Fetch data and cache it
            $data = $callback();
            Redis::setex($cacheKey, $expiration, json_encode($data, JSON_THROW_ON_ERROR));

            return ApiResponse::sendResponse($data, 'Data cached successfully');

        } catch (ConnectionException $exception) {
            // If Redis not available
            $data = $callback();
            return ApiResponse::sendResponse($data, 'Redis is not available; proceeding without caching.');
        }
    }


    public function summarizeText($text, $model = 'bart-large-cnn')
    {
        $this->initializeClient($model);
        $cacheKey = 'summarize_' . md5($text . $model);

        return $this->cacheOrFetch($cacheKey, function() use ($text) {
            try {
                return $this->client->summarization($text)->summary_text;
            } catch (\Exception $e) {
                return ['error' => 'Failed to summarize text: ' . $e->getMessage()];
            }
        });
    }

    public function translateText($text, $originalLang, $targetLang, $model = 'nllb-200-3-3b')
    {
        $this->initializeClient($model);
        $cacheKey = 'translate_' . md5($text . $originalLang . $targetLang . $model);

        return $this->cacheOrFetch($cacheKey, function() use ($text, $originalLang, $targetLang) {
            try {
                return $this->client->translation($text, $originalLang, $targetLang)->translation_text;
            } catch (\Exception $e) {
                return ['error' => 'Failed to translate text: ' . $e->getMessage()];
            }
        });
    }

    public function analyzeSentiment($text, $model = 'distilbert-base-uncased-finetuned-sst-2-english')
    {
        $this->initializeClient($model);
        $cacheKey = 'sentiment_' . md5($text . $model);

        return $this->cacheOrFetch($cacheKey, function() use ($text) {
            try {
                return $this->client->sentiment($text)->scored_labels;
            } catch (\Exception $e) {
                return ['error' => 'Failed to analyze sentiment: ' . $e->getMessage()];
            }
        });
    }

    public function namedEntityRecognition($text, $model = 'en_core_web_lg')
    {
        $this->initializeClient($model);
        $cacheKey = 'ner_' . md5($text . $model);

        return $this->cacheOrFetch($cacheKey, function() use ($text) {
            try {
                return $this->client->entities($text)->entities;
            } catch (\Exception $e) {
                return ['error' => 'Failed to recognize entities: ' . $e->getMessage()];
            }
        });
    }

//    public function summarizeText($text, $model = 'bart-large-cnn')
//    {
//        $this->initializeClient($model);
//        try {
//            return $this->client->summarization($text);
//        } catch (\Exception $e) {
//            return ['error' => 'Failed to summarize text: ' . $e->getMessage()];
//        }
//    }
//
//    public function translateText($text,$originalLang, $targetLang, $model = 'nllb-200-3-3b')
//    {
//        $this->initializeClient($model);
//        try {
//            return $this->client->translation($text, $originalLang, $targetLang);
//        } catch (\Exception $e) {
//            return ['error' => 'Failed to translate text: ' . $e->getMessage()];
//        }
//    }
//
//    public function analyzeSentiment($text, $model = 'distilbert-base-uncased-finetuned-sst-2-english')
//    {
//        $this->initializeClient($model);
//        try {
//            return $this->client->sentiment($text);
//        } catch (\Exception $e) {
//            return ['error' => 'Failed to analyze sentiment: ' . $e->getMessage()];
//        }
//    }
//
//    public function namedEntityRecognition($text, $model = 'en_core_web_lg')
//    {
//        $this->initializeClient($model);
//        return $this->client->entities($text);
//    }
}
