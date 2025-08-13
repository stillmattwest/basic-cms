<?php

use App\Helpers\QuillHelper;

test('it converts quill div structure to pre code blocks', function () {
    $input = '<div><div>function test() {</div><div>  return true;</div><div>}</div></div>';
    
    $result = QuillHelper::convertQuillCodeBlocks($input);
    
    expect($result)->toBe('<pre><code>function test() {
  return true;
}</code></pre>');
});

test('it preserves legacy format with language attributes', function () {
    $input = '<div class="ql-code-block-container"><div class="ql-code-block" data-language="javascript">console.log("test");</div></div>';
    
    $result = QuillHelper::convertQuillCodeBlocks($input);
    
    expect($result)->toBe('<pre><code class="language-javascript">console.log(&quot;test&quot;);</code></pre>');
});

test('it ignores non-code content', function () {
    $input = '<div><p>Regular content</p></div>';
    
    $result = QuillHelper::convertQuillCodeBlocks($input);
    
    expect($result)->toBe($input);
});