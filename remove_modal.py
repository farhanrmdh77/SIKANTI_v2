import codecs

with codecs.open(r'd:\laragon\www\SIKANTI_V2\resources\views\arsip\index.blade.php', 'r', 'utf-8') as f:
    lines = f.readlines()

new_lines = []
skip = False
for i, line in enumerate(lines):
    if '<div class="modal fade" id="modalDetail{{ ->id }}"' in line:
        skip = True
    if skip and '</div>' in line and lines[i+1].strip() == '@endforeach':
        # we found the end of the modal, wait, actually this might be tricky because of nested divs
        pass

# let's just delete by line numbers if they haven't changed much
# The modal detail started at 627 and ended at 699.
# Let's verify line 627
