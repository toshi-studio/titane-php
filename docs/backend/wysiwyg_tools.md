# WYSIWYG Tools

Follows PHPBB-style syntax to safely embed components.

## \[articles] Tool

```bbcode
[articles tag="{tag1}, {tag2}" sort="creation|update|id" order="asc|desc"]
```

* Only published articles with at least one tag.
* Defaults: sort by creation, order asc.

**HTML Output:**

```html
<div id="article_{article_id}" class="titane_article_preview" onclick="document.location.href='/article/{article_slug}'">
    <h4 class="article_title">{article_title}</h4>
    <div class="article_body">{article_summary}</div>
</div>
```

## \[article] Tool

```bbcode
[article slug="{article_slug}"]
```

**HTML Output:**

```html
<div id="article_{article_slug}" class="titane_article">
    <h4 class="article_title">{article_title}</h4>
    <div class="article_body">{article_content}</div>
</div>
```

## \[form] Tool

```bbcode
[form slug="{form_slug}"]
```

**HTML Output:**

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