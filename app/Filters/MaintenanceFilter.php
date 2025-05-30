<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Config\Maintenance;
use Config\Services;

class MaintenanceFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $maintenanceConfig = new Maintenance();

        if ($maintenanceConfig->checkMaintenanceStatus()) {
            $session = Services::session();
            
            // Nếu người dùng là admin hoặc truy cập vào trang maintenance đặc biệt, cho phép tiếp tục
            if ($this->isAdmin() || $this->hasSpecialAccess($request)) {
                return;
            }

            // Nếu không phải admin và không có quyền truy cập đặc biệt, chuyển hướng đến trang bảo trì
            return redirect()->to('/maintenance');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Không cần xử lý gì sau khi trả về response
    }

    /**
     * Kiểm tra xem người dùng có phải là admin hay không
     */
    private function isAdmin()
    {
        // Kiểm tra quyền admin từ session (giả sử bạn đã lưu giá trị này trong session)
        return session()->get('isAdmin') === true;
    }

    /**
     * Kiểm tra quyền truy cập đặc biệt thông qua tham số trong URL (special_access=true)
     */
    private function hasSpecialAccess(RequestInterface $request)
    {
        return $request->getGet('special_access') === 'true';  // Kiểm tra tham số trong URL
    }
}
