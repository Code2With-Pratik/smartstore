<?php

namespace App\Validation;

use DOMDocument;

class AppRules
{
    public function validate_custom_footer_code(string $inputCode, string &$error = null): bool
    {
        // Limit the content length
        $maxLength = 5000; // Maximum 5000 characters
        if (strlen($inputCode) > $maxLength) {
            $error = "The content is too long. Please enter less than $maxLength characters.";
            return false;
        }

        // Allowed tags and attributes
        $allowedTags = [
            'meta' => ['charset', 'name', 'content'],
            'link' => ['rel', 'href', 'type'],
            'style' => [],
            'script' => ['src', 'type'],
            'img' => ['src', 'alt', 'width', 'height'],
            'a' => ['href', 'target'], // Allow <a> tag (links)
            'p' => [], // Allow <p> tag for paragraphs
            'div' => [], // Allow <div> for content
            'footer' => [] // Allow <footer> tag itself
        ];

        // Parse HTML input
        $dom = new DOMDocument();
        libxml_use_internal_errors(true); // Suppress parsing errors
        // Use HTML5 compatible parsing mode
        $dom->loadHTML('<?xml encoding="utf-8" ?>' . $inputCode, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        // Loop through all tags
        foreach ($dom->getElementsByTagName('*') as $node) {
            $tagName = strtolower($node->nodeName);

            // If the tag is not allowed -> Error
            if (!array_key_exists($tagName, $allowedTags)) {
                $error = "The tag <$tagName> is not allowed.";
                $error = htmlspecialchars($error, ENT_QUOTES, 'UTF-8');
                return false;
            }

            // Check attributes
            foreach ($node->attributes as $attr) {
                $attrName = strtolower($attr->nodeName);

                // If the attribute is not allowed for the tag -> Error
                if (!in_array($attrName, $allowedTags[$tagName])) {
                    $error = "The attribute '$attrName' in <$tagName> is not allowed.";
                    $error = htmlspecialchars($error, ENT_QUOTES, 'UTF-8');
                    return false;
                }

                // Remove dangerous values (e.g., javascript:, data:, on<event> attributes)
                if (preg_match('/(javascript:|data:|on\w+)/i', $attr->nodeValue)) {
                    $error = "The attribute value in <$tagName> contains unsafe content.";
                    $error = htmlspecialchars($error, ENT_QUOTES, 'UTF-8');
                    return false;
                }
            }
        }

        // Check for dangerous keywords in the content
        if (preg_match('/(on\w+=|<iframe|<object|<embed|<applet|<form)/i', $inputCode)) {
            $error = "The content contains unsafe elements (e.g., iframe, object, embed, applet).";
            $error = htmlspecialchars($error, ENT_QUOTES, 'UTF-8');
            return false;
        }

        // Content is valid
        return true;
    }

    public function validate_custom_header_code(string $inputCode, string &$error = null): bool
    {
        // Limit the content length
        $maxLength = 5000; // Maximum 5000 characters
        if (strlen($inputCode) > $maxLength) {
            $error = "The content is too long. Please enter less than $maxLength characters.";
            
            return false;
        }

        // Allowed tags and attributes
        $allowedTags = [
            'meta' => ['charset', 'name', 'content'],
            'link' => ['rel', 'href', 'type'],
            'style' => [],
            'script' => ['src', 'type'],
            'img' => ['src', 'alt', 'width', 'height'],
        ];

        // Parse HTML
        $dom = new DOMDocument();
        libxml_use_internal_errors(true); // Suppress parsing errors
        $dom->loadHTML('<?xml encoding="utf-8" ?>' . $inputCode, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        // Loop through all tags
        foreach ($dom->getElementsByTagName('*') as $node) {
            $tagName = strtolower($node->nodeName);

            // If the tag is not allowed -> Error
            if (!array_key_exists($tagName, $allowedTags)) {
                $error = "The tag <$tagName> is not allowed.";
                $error = htmlspecialchars($error, ENT_QUOTES, 'UTF-8');
                return false;
            }

            // Check attributes
            foreach ($node->attributes as $attr) {
                $attrName = strtolower($attr->nodeName);

                if (!in_array($attrName, $allowedTags[$tagName])) {
                    $error = "The attribute '$attrName' in <$tagName> is not allowed.";
                    $error = htmlspecialchars($error, ENT_QUOTES, 'UTF-8');
                    return false;
                }

                // Remove dangerous values
                if (preg_match('/(javascript:|data:|on\w+)/i', $attr->nodeValue)) {
                    $error = "The attribute value in <$tagName> contains unsafe content.";
                    $error = htmlspecialchars($error, ENT_QUOTES, 'UTF-8');
                    return false;
                }
            }
        }

        // Check for dangerous keywords in the content
        if (preg_match('/(on\w+=|<iframe|<object|<embed|<applet)/i', $inputCode)) {
            $error = "The content contains unsafe elements (e.g., iframe, object, embed, applet).";
            $error = htmlspecialchars($error, ENT_QUOTES, 'UTF-8');
            return false;
        }

        // Content is valid
        return true;
    }

    public function validate_image_url(string $str, ?string &$error = null): bool
    {
        // Check if the URL is valid
        if (!filter_var($str, FILTER_VALIDATE_URL)) {
            $error = 'The URL is not valid.';  // Set error message if URL is not valid
            return false;
        }

        // List of allowed image file extensions
        $allowed_extensions = [
            '.jpg', '.jpeg', '.png', '.gif', '.svg', '.webp', '.bmp', '.tiff', '.tif', '.ico', '.heic'
        ];
        
        $url = strtolower($str);  // Convert URL to lowercase to avoid case sensitivity issues

        // Check if the URL has a valid image file extension
        $is_valid_extension = false;
        foreach ($allowed_extensions as $ext) {
            if (substr($url, -strlen($ext)) === $ext) {
                $is_valid_extension = true;  // If a valid extension is found, break out of the loop
                break;
            }
        }

        if (!$is_valid_extension) {
            $error = 'The URL must point to a valid image file with extensions: .jpg, .jpeg, .png, .gif, .svg, .webp, .bmp, .tiff, .tif, .ico, .heic.';  // Set error message for invalid extension
            return false;
        }

        // Check if the image exists by sending an HTTP request to get headers
        $headers = @get_headers($str, 1);
        
        // Check if headers are not returned or if the status code is not 200 OK
        if (!$headers || strpos($headers[0], '200') === false) {
            $error = 'The image URL does not exist or is unavailable.';  // Set error message if the image doesn't exist
            return false;
        }

        // If everything is valid, return true
        return true;
    }

    public function validate_item_ids(string $str, ?string &$error = null): bool
    {
        $pattern = '/^[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}$/i';
        if (preg_match($pattern, $str)) {
            return true;  
        } else {
            return false; 
        }
    }

    public function valid_end_date(string $str, string $fields, array $data, ?string &$error = null): bool { 
        $start_date = \DateTime::createFromFormat('d-m-Y', $data['start_date']); 
        $end_date = \DateTime::createFromFormat('d-m-Y', $str); 
        if ($end_date > $start_date) { 
            return true; 
        } else { 
            $error = 'End date must be greater than the start date.'; 
            return false; 
        } 
    }

    public function validate_icon_class(string $str): bool
    {
        return preg_match('/^bi\s+bi-[a-z0-9\-]+$/i', $str) === 1;
    }
}