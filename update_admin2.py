import re
with open('admin/index.php', 'r', encoding='utf-8') as f:
    content = f.read()

# Fix php echo in ajaxDelete
content = re.sub(
    r"onclick=\"ajaxDelete\('([^']+)', '([^']+)', (\$[^,]+), this\.closest\('tr'\), '([^']+)'\)",
    r"onclick=\"ajaxDelete('\1', '\2', <?php echo \3; ?>, this.closest('tr'), '\4')\"",
    content
)

with open('admin/index.php', 'w', encoding='utf-8') as f:
    f.write(content)

print("Fixed PHP tags")
