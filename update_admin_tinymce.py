import re
import json

with open('admin/index.php', 'r', encoding='utf-8') as f:
    content = f.read()

# Add TinyMCE script
if 'tinymce' not in content:
    content = content.replace('</title>', '</title>\n    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js"></script>')

# Add rich-text class to all textareas
content = re.sub(r'<textarea([^>]*)class="([^"]*)"', r'<textarea\1class="\2 rich-text"', content)
# Handle textareas without a class
content = re.sub(r'<textarea([^>]*)(?<!class=)(?<!class="[^"]*")>', r'<textarea\1 class="rich-text">', content)

# Ensure all textareas have an ID equal to their name if not present
def add_id_if_missing(match):
    attrs = match.group(1)
    # Check if name exists
    name_match = re.search(r'name="([^"]+)"', attrs)
    if name_match and 'id=' not in attrs:
        name = name_match.group(1)
        return f'<textarea{attrs} id="{name}">'
    return match.group(0)

content = re.sub(r'<textarea([^>]+)>', add_id_if_missing, content)


# Inject tinymce initialization and triggerSave
if 'tinymce.init' not in content:
    init_script = """
    <script>
        tinymce.init({
            selector: 'textarea.rich-text',
            plugins: 'lists link image code',
            toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | bullist numlist | link code',
            height: 300,
            menubar: false,
            setup: function (editor) {
                editor.on('change', function () {
                    editor.save();
                });
            }
        });
        
        function editRecord(tabId, dataStr, actionName) {
            const data = JSON.parse(dataStr);
            const tab = document.getElementById(tabId);
            const form = tab.querySelector('form.ajax-form');
            if(!form) return;
            
            // Populate form fields
            for (const [key, value] of Object.entries(data)) {
                const input = form.elements[key];
                if (input) {
                    if (input.type === 'checkbox' || input.type === 'radio') {
                        input.checked = (value == 1 || value == '1' || value === true);
                    } else if (input.type !== 'file') {
                        input.value = value;
                    }
                }
            }
            
            // Update TinyMCE instances if any
            if(window.tinymce) {
                for (const [key, value] of Object.entries(data)) {
                    const editor = tinymce.get(key) || Array.from(tinymce.editors).find(e => e.id === key || (form.elements[key] && e.id === form.elements[key].id));
                    if (editor) {
                        editor.setContent(value || '');
                    }
                }
            }
            
            // Set action and id
            let actionInput = form.querySelector('input[name="action"]');
            if(!actionInput) {
                actionInput = document.createElement('input');
                actionInput.type = 'hidden';
                actionInput.name = 'action';
                form.appendChild(actionInput);
            }
            actionInput.value = actionName;
            
            let idInput = form.querySelector('input[name="id"]');
            if(!idInput) {
                idInput = document.createElement('input');
                idInput.type = 'hidden';
                idInput.name = 'id';
                form.appendChild(idInput);
            }
            idInput.value = data.id;
            
            // Change submit button text
            const submitBtn = form.querySelector('button[type="submit"]');
            if(submitBtn) {
                submitBtn.innerHTML = '<i class="fa-solid fa-save"></i> Update Record';
            }
            
            // Scroll to form
            form.scrollIntoView({ behavior: 'smooth' });
        }
    """
    content = content.replace('<script>', init_script + '\n    <script>', 1)

# Add tinymce.triggerSave() before formData
if 'tinymce.triggerSave' not in content:
    content = content.replace('const formData = new FormData(form);', 'if(window.tinymce) tinymce.triggerSave();\n                    const formData = new FormData(form);')


with open('admin/index.php', 'w', encoding='utf-8') as f:
    f.write(content)
print('Phase 1 done')
