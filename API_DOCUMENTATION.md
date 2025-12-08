# SpaceAlchemy API Documentation

## Base URL
```
http://localhost:8000/api/v1
```

## Response Format
All API responses follow this format:
```json
{
    "success": true/false,
    "data": {},
    "message": "string"
}
```

---

## Products API

### 1. Get All Products
**Endpoint:** `GET /products`

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "Modern 3-Seater Sofa",
            "description": "Comfortable sofa",
            "price": "799.00",
            "image": null,
            "created_at": "2025-12-08T...",
            "updated_at": "2025-12-08T..."
        }
    ],
    "message": "Products retrieved successfully"
}
```

---

### 2. Get Single Product
**Endpoint:** `GET /products/{id}`

**Example:** `GET /products/1`

**Response:**
```json
{
    "success": true,
    "data": {
        "id": 1,
        "name": "Modern 3-Seater Sofa",
        "description": "Comfortable sofa",
        "price": "799.00",
        "image": null,
        "created_at": "2025-12-08T...",
        "updated_at": "2025-12-08T..."
    },
    "message": "Product retrieved successfully"
}
```

---

### 3. Create Product
**Endpoint:** `POST /products`

**Request Body:**
```json
{
    "name": "New Product",
    "description": "Product description",
    "price": 99.99
}
```

**Response (201):**
```json
{
    "success": true,
    "data": {
        "id": 5,
        "name": "New Product",
        "description": "Product description",
        "price": "99.99",
        "created_at": "2025-12-09T...",
        "updated_at": "2025-12-09T..."
    },
    "message": "Product created successfully"
}
```

---

### 4. Update Product
**Endpoint:** `PUT /products/{id}`

**Example:** `PUT /products/1`

**Request Body:**
```json
{
    "name": "Updated Product Name",
    "price": 149.99
}
```

**Response:**
```json
{
    "success": true,
    "data": {
        "id": 1,
        "name": "Updated Product Name",
        "description": "Comfortable sofa",
        "price": "149.99",
        "updated_at": "2025-12-09T..."
    },
    "message": "Product updated successfully"
}
```

---

### 5. Delete Product
**Endpoint:** `DELETE /products/{id}`

**Example:** `DELETE /products/1`

**Response:**
```json
{
    "success": true,
    "message": "Product deleted successfully"
}
```

---

### 6. Search Products
**Endpoint:** `GET /products/search/{query}`

**Example:** `GET /products/search/sofa`

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "Modern 3-Seater Sofa",
            "description": "Comfortable sofa",
            "price": "799.00",
            "created_at": "2025-12-08T...",
            "updated_at": "2025-12-08T..."
        }
    ],
    "message": "Search completed"
}
```

---

## Services API

### 1. Get All Services
**Endpoint:** `GET /services`

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "title": "Interior Design",
            "icon": "fa-palette",
            "description": "Professional interior design services",
            "created_at": "2025-11-28T...",
            "updated_at": "2025-11-28T..."
        }
    ],
    "message": "Services retrieved successfully"
}
```

---

### 2. Get Single Service
**Endpoint:** `GET /services/{id}`

**Example:** `GET /services/1`

---

### 3. Create Service
**Endpoint:** `POST /services`

**Request Body:**
```json
{
    "title": "New Service",
    "description": "Service description",
    "icon": "fa-tools"
}
```

---

### 4. Update Service
**Endpoint:** `PUT /services/{id}`

**Example:** `PUT /services/1`

---

### 5. Delete Service
**Endpoint:** `DELETE /services/{id}`

**Example:** `DELETE /services/1`

---

### 6. Search Services
**Endpoint:** `GET /services/search/{query}`

**Example:** `GET /services/search/design`

---

## Packages API

### 1. Get All Packages
**Endpoint:** `GET /packages`

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "Premium Design Package",
            "description": "Complete interior design package",
            "price": "1999.99",
            "product_id": 1,
            "product": {
                "id": 1,
                "name": "Modern 3-Seater Sofa",
                "price": "799.00"
            },
            "services": [
                {
                    "id": 1,
                    "title": "Interior Design",
                    "icon": "fa-palette",
                    "description": "Professional interior design services"
                },
                {
                    "id": 2,
                    "title": "Installation",
                    "icon": "fa-tools",
                    "description": "Professional installation service"
                }
            ],
            "created_at": "2025-12-08T...",
            "updated_at": "2025-12-08T..."
        }
    ],
    "message": "Packages retrieved successfully"
}
```

---

### 2. Get Single Package
**Endpoint:** `GET /packages/{id}`

**Example:** `GET /packages/1`

---

### 3. Create Package
**Endpoint:** `POST /packages`

**Request Body:**
```json
{
    "name": "New Package",
    "description": "Package description",
    "price": 2999.99,
    "product_id": 1,
    "services": [1, 2, 3]
}
```

**Response (201):**
```json
{
    "success": true,
    "data": {
        "id": 2,
        "name": "New Package",
        "description": "Package description",
        "price": "2999.99",
        "product_id": 1,
        "product": {
            "id": 1,
            "name": "Modern 3-Seater Sofa",
            "price": "799.00"
        },
        "services": [
            {
                "id": 1,
                "title": "Interior Design"
            },
            {
                "id": 2,
                "title": "Installation"
            },
            {
                "id": 3,
                "title": "Consultation"
            }
        ],
        "created_at": "2025-12-09T...",
        "updated_at": "2025-12-09T..."
    },
    "message": "Package created successfully"
}
```

---

### 4. Update Package
**Endpoint:** `PUT /packages/{id}`

**Example:** `PUT /packages/1`

**Request Body:**
```json
{
    "price": 3499.99,
    "services": [1, 2]
}
```

---

### 5. Delete Package
**Endpoint:** `DELETE /packages/{id}`

**Example:** `DELETE /packages/1`

---

### 6. Search Packages
**Endpoint:** `GET /packages/search/{query}`

**Example:** `GET /packages/search/premium`

---

### 7. Get Packages by Product
**Endpoint:** `GET /packages/product/{product_id}`

**Example:** `GET /packages/product/1`

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "Premium Design Package",
            "price": "1999.99",
            "product_id": 1,
            "product": {...},
            "services": [...]
        }
    ],
    "message": "Packages retrieved successfully"
}
```

---

## Error Handling

### 404 Not Found
```json
{
    "message": "Not Found"
}
```

### 422 Validation Error
```json
{
    "message": "The given data was invalid.",
    "errors": {
        "name": ["The name field is required."],
        "price": ["The price must be a number."]
    }
}
```

### 500 Server Error
```json
{
    "message": "Server Error"
}
```

---

## Testing with cURL

### Get all products
```bash
curl -X GET "http://localhost:8000/api/v1/products"
```

### Create a product
```bash
curl -X POST "http://localhost:8000/api/v1/products" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Test Product",
    "description": "Test description",
    "price": 99.99
  }'
```

### Get all packages with relationships
```bash
curl -X GET "http://localhost:8000/api/v1/packages"
```

### Create a package
```bash
curl -X POST "http://localhost:8000/api/v1/packages" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Test Package",
    "description": "Test package",
    "price": 1999.99,
    "product_id": 1,
    "services": [1, 2]
  }'
```

---

## Status Codes

| Code | Meaning |
|------|---------|
| 200 | OK - Request successful |
| 201 | Created - Resource created successfully |
| 400 | Bad Request - Invalid request |
| 404 | Not Found - Resource not found |
| 422 | Unprocessable Entity - Validation failed |
| 500 | Server Error |

---

## Notes

- All API endpoints are public and do not require authentication
- Use the appropriate HTTP method for each operation
- Always include `Content-Type: application/json` header for POST/PUT requests
- API responses use HTTP status codes appropriately
- Search endpoints are case-insensitive and search across multiple fields
