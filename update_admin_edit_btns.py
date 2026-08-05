import re

with open('admin/index.php', 'r', encoding='utf-8') as f:
    content = f.read()

# For News:
# $news is the loop variable. We need to pass htmlspecialchars(json_encode($n)) or something similar.
# The table uses $n in some loops, $p in partners, $s in speakers, $a in accommodations, $res in resources.
# Actually, the loops are:
# $all_news as $n (line 386 -> $n)
# $partners as $p
# $speakers as $s
# $accommodations as $a
# $resources as $res

# Let's do a generic replacement for the delete button.
def inject_edit_button(match):
    # match.group(1) is the whole button e.g. <button type="button" onclick="ajaxDelete('delete_news', 'news_id', <?php echo $n['id']; ?>, this.closest('tr'), 'tab-news')" ...
    full_delete_btn = match.group(0)
    
    # Extract the variable name used for id, e.g., $n['id'] -> $n
    var_match = re.search(r'<\?php echo (\$[^\[]+)\[\'id\'\]; \?>', full_delete_btn)
    if not var_match:
        # Check if it was already updated to something else or missing
        return full_delete_btn
        
    var_name = var_match.group(1)
    
    # Extract action and tab
    action_match = re.search(r'ajaxDelete\(\'delete_([^\']+)\',', full_delete_btn)
    action_name = 'edit_' + action_match.group(1) if action_match else 'edit_item'
    
    tab_match = re.search(r'this\.closest\(\'tr\'\), \'([^\']+)\'\)', full_delete_btn)
    tab_id = tab_match.group(1) if tab_match else 'tab-unknown'
    
    # Construct edit button
    edit_btn = f'<button type="button" onclick="editRecord(\'{tab_id}\', \'<?php echo htmlspecialchars(json_encode({var_name}), ENT_QUOTES, \\\'UTF-8\\\'); ?>\', \'{action_name}\')" class="text-blue-600 hover:text-blue-900 mr-3"><i class="fa-solid fa-edit"></i></button>'
    
    return edit_btn + '\n' + full_delete_btn

# Find the delete buttons
content = re.sub(r'<button type="button" onclick="ajaxDelete[^>]+>.*?</button>', inject_edit_button, content)

with open('admin/index.php', 'w', encoding='utf-8') as f:
    f.write(content)
print("Edit buttons injected")
