<?php

namespace Threecolts\Phptest;

class UrlCounter
{
    /**
     * This function counts how many unique normalized valid URLs were passed to the function
     *
     * Accepts a list of URLs
     *
     * Example:
     *
     * input: ['https://example.com']
     * output: 1
     *
     * Notes:
     *  - assume none of the URLs have authentication information (username, password).
     *
     * Normalized URL:
     *  - process in which a URL is modified and standardized: https://en.wikipedia.org/wiki/URL_normalization
     *
     *    For example.
     *    These 2 urls are the same:
     *    input: ["https://example.com", "https://example.com/"]
     *    output: 1
     *
     *    These 2 are not the same:
     *    input: ["https://example.com", "http://example.com"]
     *    output 2
     *
     *    These 2 are the same:
     *    input: ["https://example.com?", "https://example.com"]
     *    output: 1
     *
     *    These 2 are the same:
     *    input: ["https://example.com?a=1&b=2", "https://example.com?b=2&a=1"]
     *    output: 1
     */

    /* @var $urls : string[] */
    public function countUniqueUrls(?array $urls)
    {
        if ($urls === null) {
            return 0;
        }

        // Normalize and filter the URLs
        $normalized_urls = array_map(function ($url) {
            return strtolower(rtrim($url, '/'));
        }, $urls);

        $unique_urls = array_unique($normalized_urls);

        // Return the count of unique normalized URLs
        return count($uniqueUrls);
    }

    

    /**
     * This function counts how many unique normalized valid URLs were passed to the function per top level domain
     *
     * A top level domain is a domain in the form of example.com. Assume all top level domains end in .com
     * subdomain.example.com is not a top level domain.
     *
     * Accepts a list of URLs
     *
     * Example:
     *
     * input: ["https://example.com"]
     * output: ["example.com" => 1]
     *
     * input: ["https://example.com", "https://subdomain.example.com"]
     * output: ["example.com" => 2]
     *
     */
    /* @var $urls : string[] */
    public function countUniqueUrlsPerTopLevelDomain(?array $urls)
    {
        if ($urls === null) {
            return [];
        }
    
        $counts = [];
    
        foreach ($urls as $url) {
            $normalized_url = strtolower(rtrim($url, '/')); // Normalize and remove trailing slashes
            $parsed_url = parse_url($normalized_url);
    
            if ($parsed_url && isset($parsed_url['host'])) {
                // Extract the top-level domain (TLD)
                $tld = end(explode('.', $parsed_url['host']));
    
                if ($tld === 'com') {
                    $counts[$parsed_url['host']] = ($counts[$parsed_url['host']] ?? 0) + 1;
                }
            }
        }
    
        return $counts;
    }
    
    
}