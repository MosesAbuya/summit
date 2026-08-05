import re

with open('admin/index.php', 'r', encoding='utf-8') as f:
    content = f.read()

# Replace main forms
content = re.sub(r'<form method="POST">', '<form class="ajax-form" enctype="multipart/form-data">', content)
content = re.sub(r'<form method="POST" enctype="multipart/form-data">', '<form class="ajax-form" enctype="multipart/form-data">', content)

# Replace image URL inputs with file inputs
content = re.sub(
    r'<input type="text" name="image_url".*?class="(.*?)".*?>',
    r'<input type="file" name="image_file" accept="image/*" class="\1" required>',
    content
)
content = re.sub(
    r'<input type="url" name="image_url".*?class="(.*?)".*?>',
    r'<input type="file" name="image_file" accept="image/*" class="\1" required>',
    content
)

def replace_delete_form(match):
    action = match.group(1)
    id_name = match.group(2)
    php_id = match.group(3)
    button_inner = match.group(4)
    # The tab ID logic: derive from action (e.g. delete_partner -> tab-partners)
    tab_id = 'tab-' + action.replace('delete_', '') + 's'
    if action == 'delete_news': tab_id = 'tab-news'
    return f'<button type="button" onclick="ajaxDelete(\'{action}\', \'{id_name}\', {php_id}, this.closest(\'tr\'), \'{tab_id}\')" class="text-red-600 hover:text-red-900">{button_inner}</button>'

# Regex for delete forms
pattern = r'<form method="POST" (?:class="inline" )?onsubmit="return confirm\([^)]+\);">\s*<input type="hidden" name="action" value="(delete_[^"]+)">\s*<input type="hidden" name="([^"]+)" value="<\?php echo ([^;]+); \?>">\s*<button type="submit"[^>]*>(.*?)</button>\s*</form>'

content = re.sub(pattern, replace_delete_form, content, flags=re.DOTALL)

with open('admin/index.php', 'w', encoding='utf-8') as f:
    f.write(content)

print("Done")
