<?php

namespace App\Helpers;

class QuillHelper
{
    public static function convertQuillCodeBlocks($html)
    {
        if (empty($html)) {
            return $html;
        }

        // First try the old pattern for existing content with ql-code-block-container
        $pattern = '/<div class="ql-code-block-container"[^>]*>.*?<\/div>/s';
        $html = preg_replace_callback($pattern, function($matches) {
            $fullMatch = $matches[0];
            
            // Extract language from data-language attribute
            $language = 'plain'; // default
            if (preg_match('/data-language="([^"]*)"/', $fullMatch, $langMatch)) {
                $language = $langMatch[1];
            }
            
            // Extract all text content from ql-code-block divs
            preg_match_all('/<div class="ql-code-block"[^>]*>(.*?)<\/div>/s', $fullMatch, $codeMatches);
            
            $codeLines = [];
            foreach ($codeMatches[1] as $line) {
                // Remove HTML tags but preserve the text content
                $cleanLine = strip_tags($line);
                // Handle empty lines (they might just contain <br> tags)
                if (trim($cleanLine) === '' && strpos($line, '<br>') !== false) {
                    $codeLines[] = '';
                } else {
                    $codeLines[] = $cleanLine;
                }
            }
            
            // Join lines and create standard code block
            $codeText = implode("\n", $codeLines);
            
            return '<pre><code class="language-' . htmlspecialchars($language) . '">' . htmlspecialchars($codeText) . '</code></pre>';
        }, $html);

        // Now handle standard Quill code-block format (consecutive divs within a parent div)
        // This matches patterns like: <div><div>line1</div><div>line2</div></div>
        $pattern = '/<div>(\s*<div>[^<]*(?:<br[^>]*>)?[^<]*<\/div>\s*)+<\/div>/s';
        
        return preg_replace_callback($pattern, function($matches) {
            $fullMatch = $matches[0];
            
            // Check if this looks like a code block (multiple consecutive div lines)
            $divCount = preg_match_all('/<div>/', $fullMatch);
            if ($divCount < 2) {
                return $fullMatch; // Not a code block, return as is
            }
            
            // Extract all div content
            preg_match_all('/<div>([^<]*(?:<br[^>]*>)?[^<]*)<\/div>/', $fullMatch, $matches);
            
            $codeLines = [];
            foreach ($matches[1] as $line) {
                // Remove HTML tags but preserve the text content
                $cleanLine = strip_tags($line);
                // Handle empty lines (they might just contain <br> tags)
                if (trim($cleanLine) === '' && strpos($line, '<br>') !== false) {
                    $codeLines[] = '';
                } else {
                    $codeLines[] = $cleanLine;
                }
            }
            
            // If all lines are code-like (no paragraph content), treat as code block
            $codeText = implode("\n", $codeLines);
            
            // Simple heuristic: if it contains programming patterns, treat as code
            if (preg_match('/[{}();]/', $codeText) || count($codeLines) > 2) {
                return '<pre><code>' . htmlspecialchars($codeText) . '</code></pre>';
            }
            
            // Otherwise return original
            return $fullMatch;
        }, $html);
    }
}