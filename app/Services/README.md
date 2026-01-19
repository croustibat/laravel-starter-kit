# URL Metadata Extractor Service

This service automatically extracts metadata (title, description, and image) from URLs using Open Graph tags and standard HTML meta tags.

## Usage

### In PHP Code

```php
use App\Services\UrlMetadataExtractor;

$extractor = app(UrlMetadataExtractor::class);
$metadata = $extractor->extract('https://example.com/article');

// Returns:
// [
//     'title' => 'Article Title',
//     'description' => 'Article description',
//     'image_url' => 'https://example.com/image.jpg'
// ]
```

### Via API

**Endpoint:** `POST /api/url-metadata`

**Authentication:** Required (session-based auth)

**Request:**
```json
{
    "url": "https://example.com/article"
}
```

**Response:**
```json
{
    "success": true,
    "data": {
        "title": "Article Title",
        "description": "Article description",
        "image_url": "https://example.com/image.jpg"
    }
}
```

### In Livewire Components

Use the `url-input` Volt component:

```blade
<livewire:url-input />
```

This component provides:
- URL input field with validation
- "Fetch Metadata" button with loading state
- Auto-populated title, description, and image URL fields
- Error handling and user feedback

## Features

- Extracts Open Graph tags (`og:title`, `og:description`, `og:image`)
- Falls back to standard HTML tags (`<title>`, `<meta name="description">`)
- Handles HTML entities and decodes them properly
- 5-second timeout to prevent hanging requests
- Graceful error handling (404, 500, timeouts)
- Comprehensive test coverage

## Technical Details

### Extraction Priority

1. **Title:**
   - `og:title` meta tag (highest priority)
   - `<title>` tag (fallback)

2. **Description:**
   - `og:description` meta tag (highest priority)
   - `<meta name="description">` tag (fallback)

3. **Image:**
   - `og:image` meta tag only

### Error Handling

The service logs errors and returns null values when:
- The URL returns a non-200 status code
- The request times out (>5 seconds)
- Network errors occur
- The HTML doesn't contain any metadata tags

## Testing

Run tests with:
```bash
php artisan test --filter=UrlMetadata
php artisan test --filter=UrlInputTest
```

## Examples

### Example 1: Blog Post
```php
$metadata = $extractor->extract('https://blog.example.com/post');
// Returns:
// [
//     'title' => 'How to Build Amazing Apps',
//     'description' => 'A comprehensive guide to...',
//     'image_url' => 'https://blog.example.com/featured.jpg'
// ]
```

### Example 2: No Metadata
```php
$metadata = $extractor->extract('https://example.com/plain-page');
// Returns:
// [
//     'title' => null,
//     'description' => null,
//     'image_url' => null
// ]
```

### Example 3: Error Handling
```php
$metadata = $extractor->extract('https://invalid-domain-xyz.com/page');
// Returns:
// [
//     'title' => null,
//     'description' => null,
//     'image_url' => null
// ]
// Error is logged but doesn't throw exception
```
