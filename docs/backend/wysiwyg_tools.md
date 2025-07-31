# WYSIWYG Tools

Titane uses **SCEditor 3.2.0** as the WYSIWYG editor with custom PHPBB-style syntax for safe component embedding and content management.

## SCEditor Integration

### Why SCEditor?
- **Lightweight**: ~45KB minified, fast loading
- **Configurable**: Customizable toolbar per content type (pages vs articles)
- **Expandable**: Plugin system for custom PHPBB commands
- **Modern**: No jQuery dependency, clean JavaScript
- **BBCode Native**: Built-in BBCode support matches our syntax

### Editor Configuration
```javascript
// Basic SCEditor configuration for Titane
$('.wysiwyg-editor').sceditor({
    format: 'bbcode',
    toolbar: 'bold,italic,underline,strike|left,center,right,justify|' +
             'font,size,color,removeformat|cut,copy,paste,pastetext|' +
             'bulletlist,orderedlist,indent,outdent|' +
             'image,link,unlink|source,maximize|' +
             'titane-articles,titane-article,titane-form', // Custom Titane tools
    style: '/assets/sceditor/minified/themes/content.min.css',
    emoticonsEnabled: false,
    width: '100%',
    height: 400,
    resizeEnabled: true,
    plugins: 'titane-bbcode' // Custom plugin for Titane commands
});
```

### Custom Toolbar Per Content Type
- **Pages**: Full toolbar with all Titane embedding tools
- **Articles**: Standard formatting + article embedding only
- **Forms**: Basic formatting without embedding tools

## Custom Titane BBCode Commands

Follows PHPBB-style syntax to safely embed components and maintain content portability.

### Architecture: Storage vs Rendering

**Storage Phase (Editor)**:
- BBCode is inserted as plain text into content fields
- No HTML transformation occurs during editing/saving
- Content remains flexible and editable

**Rendering Phase (API/Frontend)**:
- BBCode is resolved to HTML only when content is requested
- Dynamic resolution ensures embedded content reflects current state
- Changes to referenced articles/forms automatically propagate

This approach ensures:
- **Dynamic Content**: Embedded articles/forms always show latest data
- **Editability**: Users can modify BBCode parameters after insertion
- **Performance**: HTML generation happens only when needed
- **Maintainability**: Content stays synchronized without manual updates

## \[articles] Tool

### Editor Interface (Phase 3)
When the user clicks the "Articles" tool in the WYSIWYG editor, a popup form appears with:
- **Tags field**: Multi-select or comma-separated input for tag selection
- **Sort field**: Dropdown with options (creation|update|id)  
- **Order field**: Dropdown with options (asc|desc)
- **Insert button**: Generates and inserts the BBCode

### BBCode Syntax
```bbcode
[articles tag="{tag1}, {tag2}" sort="creation|update|id" order="asc|desc"]
```

* Only published articles with at least one tag.
* Defaults: sort by creation, order asc.
* **Storage**: BBCode is stored as-is in the content field
* **Rendering**: HTML transformation happens at rendering time via API/frontend

### HTML Output (Runtime Resolution Only)
The BBCode is resolved to HTML only when content is rendered, ensuring dynamic resolution:

```html
<div id="article_{article_id}" class="titane_article_preview" onclick="document.location.href='/article/{article_slug}'">
    <h4 class="article_title">{article_title}</h4>
    <div class="article_body">{article_summary}</div>
</div>
```

## \[article] Tool

### Editor Interface (Phase 3)
When the user clicks the "Article" tool in the WYSIWYG editor, a popup form appears with:
- **Article selector**: Dropdown or autocomplete field for article selection by slug
- **Insert button**: Generates and inserts the BBCode

### BBCode Syntax
```bbcode
[article slug="{article_slug}"]
```

* **Storage**: BBCode is stored as-is in the content field
* **Rendering**: HTML transformation happens at rendering time via API/frontend

### HTML Output (Runtime Resolution Only)
```html
<div id="article_{article_slug}" class="titane_article">
    <h4 class="article_title">{article_title}</h4>
    <div class="article_body">{article_content}</div>
</div>
```

## \[form] Tool

### Editor Interface (Phase 3)
When the user clicks the "Form" tool in the WYSIWYG editor, a popup form appears with:
- **Form selector**: Dropdown or autocomplete field for form selection by slug
- **Insert button**: Generates and inserts the BBCode

### BBCode Syntax
```bbcode
[form slug="{form_slug}"]
```

* **Storage**: BBCode is stored as-is in the content field
* **Rendering**: HTML transformation happens at rendering time via API/frontend

### HTML Output (Runtime Resolution Only)
```html
<div id="form_{form_slug}" class="titane_form">
    <h4 class="form_title">{form_title}</h4>
    <div class="form_body">
        <div class="form_text">{form_text}</div>
        <div class="form_image">{form_image}</div>
        <div class="form_fields">
            {the fields of the form}
        </div>
    </div>
</div>
```

Each field:

```html
<div class="titane_field {field_container_custom_class}">
    <div class="titane_form_label {field_label_custom_class}">{field_label}</div>
    <div class="titane_form_field {field_custom_class}">{field_label}</div>
</div>
```

## SCEditor Plugin Implementation

### Custom Titane BBCode Plugin Structure
```javascript
// assets/js/sceditor-titane-plugin.js
(function () {
    'use strict';
    
    sceditor.plugins.titane = function () {
        var base = this;
        
        // Register custom BBCode commands
        base.bbcode.set('articles', {
            tags: {
                articles: {
                    openTag: function(token, attrs) {
                        var tag = attrs.tag || '';
                        var sort = attrs.sort || 'creation';
                        var order = attrs.order || 'asc';
                        return '<div class="titane-articles-embed" data-tag="' + tag + 
                               '" data-sort="' + sort + '" data-order="' + order + '">';
                    },
                    closeTag: '</div>'
                }
            }
        });
        
        base.bbcode.set('article', {
            tags: {
                article: {
                    openTag: function(token, attrs) {
                        var slug = attrs.slug || '';
                        return '<div class="titane-article-embed" data-slug="' + slug + '">';
                    },
                    closeTag: '</div>'
                }
            }
        });
        
        base.bbcode.set('form', {
            tags: {
                form: {
                    openTag: function(token, attrs) {
                        var slug = attrs.slug || '';
                        return '<div class="titane-form-embed" data-slug="' + slug + '">';
                    },
                    closeTag: '</div>'
                }
            }
        });
    };
    
    // Add toolbar buttons
    sceditor.command.set('titane-articles', {
        dropdown: function(editor, caller) {
            var content = $('<div>');
            
            // Create form for articles embedding
            content.append(
                '<label>Tags (comma-separated):</label>' +
                '<input type="text" class="titane-articles-tags" placeholder="web, design">' +
                '<label>Sort by:</label>' +
                '<select class="titane-articles-sort">' +
                    '<option value="creation">Creation Date</option>' +
                    '<option value="update">Update Date</option>' +
                    '<option value="id">ID</option>' +
                '</select>' +
                '<label>Order:</label>' +
                '<select class="titane-articles-order">' +
                    '<option value="asc">Ascending</option>' +
                    '<option value="desc">Descending</option>' +
                '</select>' +
                '<button type="button" class="btn btn-primary titane-insert-articles">Insert</button>'
            );
            
            content.find('.titane-insert-articles').click(function() {
                var tags = content.find('.titane-articles-tags').val();
                var sort = content.find('.titane-articles-sort').val();
                var order = content.find('.titane-articles-order').val();
                
                editor.insertText('[articles tag="' + tags + '" sort="' + sort + '" order="' + order + '"]');
                editor.closeDropDown(true);
            });
            
            return content;
        },
        exec: function() {},
        txtExec: function() {},
        tooltip: 'Insert Articles List'
    });
    
    // Similar implementations for titane-article and titane-form commands...
    
})();
```

### EasyAdmin Integration
```php
// In EasyAdmin CRUD controllers for Page/Article entities
public function configureFields(string $pageName): iterable
{
    return [
        TextField::new('title'),
        SlugField::new('slug')->setTargetFieldName('title'),
        
        // Custom WYSIWYG field with SCEditor
        TextareaField::new('content')
            ->setFormType(TextareaType::class)
            ->setFormTypeOptions([
                'attr' => [
                    'class' => 'wysiwyg-editor titane-page-editor',
                    'data-editor-type' => 'page' // For different toolbar configs
                ]
            ])
            ->hideOnIndex(),
            
        // ... other fields
    ];
}
```

### Asset Integration
```yaml
# config/packages/webpack_encore.yaml or similar
# Include SCEditor assets in admin build
admin_css:
    - vendor/sceditor/minified/themes/default.min.css
    - assets/css/sceditor-titane-theme.css

admin_js:
    - vendor/sceditor/minified/sceditor.min.js
    - vendor/sceditor/minified/formats/bbcode.js
    - assets/js/sceditor-titane-plugin.js
    - assets/js/admin-wysiwyg.js
```

## Implementation Priority

### Phase 3a: Basic SCEditor Setup
1. Install SCEditor 3.2.0 via npm/yarn
2. Create basic EasyAdmin integration
3. Implement standard BBCode toolbar

### Phase 3b: Custom Titane Commands
1. Develop titane-bbcode plugin
2. Create dropdown forms for [articles], [article], [form] insertion
3. Add real-time preview functionality

### Phase 3c: Advanced Features
1. Content validation and sanitization
2. Auto-complete for article/form slugs
3. Drag-and-drop media insertion
4. Custom CSS themes for admin interface

This approach ensures SCEditor's expandability is fully utilized for Titane's custom requirements while maintaining a clean, professional admin experience.