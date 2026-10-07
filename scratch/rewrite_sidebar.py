import os
import re

directory = r'd:\laragon\www\SIKANTI_V2\resources\views'
pattern = re.compile(r'<div class="sidebar">.*?</div>\s*<!-- ================================================================ -->', re.DOTALL)
pattern_no_comment = re.compile(r'<div class="sidebar">.*?</div>\s*<div class="main-content">', re.DOTALL)

for root, dirs, files in os.walk(directory):
    for file in files:
        if file.endswith('.blade.php') and file != 'sidebar.blade.php':
            filepath = os.path.join(root, file)
            with open(filepath, 'r', encoding='utf-8') as f:
                content = f.read()

            new_content = re.sub(
                r'<!-- ================================================================ -->\s*<!-- BLOK SIDEBAR TERKUNCI \(KONSISTEN\) -->\s*<!-- ================================================================ -->\s*<div class="sidebar">.*?</div>\s*<!-- ================================================================ -->',
                "@include('layouts.sidebar')",
                content,
                flags=re.DOTALL
            )
            
            if new_content == content:
                # Try a simpler regex
                new_content = re.sub(
                    r'<div class="sidebar">.*?</div>\s*(?=<div class="main-content">)',
                    "@include('layouts.sidebar')\n    ",
                    content,
                    flags=re.DOTALL
                )

            if new_content != content:
                with open(filepath, 'w', encoding='utf-8') as f:
                    f.write(new_content)
                print(f"Updated {filepath}")
