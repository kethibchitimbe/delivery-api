# JWT Authentication System

This delivery API now uses JWT (JSON Web Tokens) for authentication instead of Laravel Sanctum. The JWT tokens include user information (email, role, name) and have a 24-hour expiration time.

## Features

- **JWT Tokens with Expiry**: Tokens expire after 24 hours (configurable)
- **Custom Claims**: Tokens include email, role, and name information
- **Token Refresh**: Users can refresh their tokens before expiration
- **Proper Error Handling**: Clear error messages for expired/invalid tokens
- **Role-based Access**: Support for different user roles (consumer, restaurant, delivery, admin)

## API Endpoints

### Authentication Endpoints

#### Register User
```
POST /api/auth/register
```

**Request Body:**
```json
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "phone": "+1234567890",
    "role": "consumer"
}
```

**Response:**
```json
{
    "status": "success",
    "message": "User registered successfully",
    "data": {
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com",
            "phone": "+1234567890",
            "role": "consumer",
            "created_at": "2024-01-01T00:00:00.000000Z",
            "updated_at": "2024-01-01T00:00:00.000000Z"
        },
        "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..."
    }
}
```

#### Login User
```
POST /api/auth/login
```

**Request Body:**
```json
{
    "email": "john@example.com",
    "password": "password123"
}
```

**Response:**
```json
{
    "status": "success",
    "message": "Login successful",
    "data": {
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com",
            "phone": "+1234567890",
            "role": "consumer",
            "created_at": "2024-01-01T00:00:00.000000Z",
            "updated_at": "2024-01-01T00:00:00.000000Z"
        },
        "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..."
    }
}
```

#### Refresh Token
```
POST /api/auth/refresh
```

**Headers:**
```
Authorization: Bearer <current_token>
```

**Response:**
```json
{
    "status": "success",
    "message": "Token refreshed successfully",
    "data": {
        "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..."
    }
}
```

#### Logout User
```
POST /api/auth/logout
```

**Headers:**
```
Authorization: Bearer <token>
```

**Response:**
```json
{
    "status": "success",
    "message": "Logout successful"
}
```

#### Get User Profile
```
GET /api/auth/profile
```

**Headers:**
```
Authorization: Bearer <token>
```

**Response:**
```json
{
    "status": "success",
    "data": {
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com",
            "phone": "+1234567890",
            "role": "consumer",
            "created_at": "2024-01-01T00:00:00.000000Z",
            "updated_at": "2024-01-01T00:00:00.000000Z"
        }
    }
}
```

#### Update User Profile
```
PUT /api/auth/profile
```

**Headers:**
```
Authorization: Bearer <token>
```

**Request Body:**
```json
{
    "name": "Updated Name",
    "phone": "+9876543210"
}
```

**Response:**
```json
{
    "status": "success",
    "message": "Profile updated successfully",
    "data": {
        "user": {
            "id": 1,
            "name": "Updated Name",
            "email": "john@example.com",
            "phone": "+9876543210",
            "role": "consumer",
            "created_at": "2024-01-01T00:00:00.000000Z",
            "updated_at": "2024-01-01T00:00:00.000000Z"
        }
    }
}
```

## Token Information

JWT tokens contain the following information:
- **User ID**: Used for authentication
- **Email**: User's email address
- **Role**: User's role (consumer, restaurant, delivery, admin)
- **Name**: User's full name
- **Expiration**: Token expires after 24 hours

## Error Responses

### Token Expired
```json
{
    "status": "error",
    "message": "Token has expired",
    "code": "token_expired"
}
```

### Invalid Token
```json
{
    "status": "error",
    "message": "Token is invalid",
    "code": "token_invalid"
}
```

### Token Not Found
```json
{
    "status": "error",
    "message": "Token not found",
    "code": "token_not_found"
}
```

### Invalid Credentials
```json
{
    "status": "error",
    "message": "Invalid credentials"
}
```

## Configuration

### Token Expiration
The token expiration time is configured in `config/jwt.php`:
```php
'ttl' => env('JWT_TTL', 1440), // 24 hours in minutes
```

### Refresh Token Expiration
Refresh tokens are valid for 2 weeks by default:
```php
'refresh_ttl' => env('JWT_REFRESH_TTL', 20160), // 2 weeks in minutes
```

## Usage in Frontend

### Setting Authorization Header
```javascript
// After login, store the token
const token = response.data.data.token;
localStorage.setItem('jwt_token', token);

// Use token in API requests
const headers = {
    'Authorization': `Bearer ${token}`,
    'Content-Type': 'application/json'
};

fetch('/api/auth/profile', { headers })
    .then(response => response.json())
    .then(data => console.log(data));
```

### Handling Token Expiration
```javascript
// Check for token expiration error
if (response.status === 401 && response.data.code === 'token_expired') {
    // Try to refresh the token
    const refreshResponse = await fetch('/api/auth/refresh', {
        method: 'POST',
        headers: {
            'Authorization': `Bearer ${currentToken}`,
            'Content-Type': 'application/json'
        }
    });
    
    if (refreshResponse.ok) {
        const newToken = refreshResponse.data.data.token;
        localStorage.setItem('jwt_token', newToken);
        // Retry the original request with new token
    } else {
        // Redirect to login
        window.location.href = '/login';
    }
}
```

## Security Features

1. **Token Expiration**: Tokens automatically expire after 24 hours
2. **Secure Storage**: Tokens should be stored securely (not in localStorage for production)
3. **HTTPS Only**: Use HTTPS in production to protect token transmission
4. **Token Invalidation**: Logout invalidates the current token
5. **Role-based Access**: Different user roles for different access levels

## Testing

Run the authentication tests:
```bash
php artisan test tests/Feature/AuthTest.php
```

The tests cover:
- User registration
- User login
- Token refresh
- Profile management
- Token expiration handling
- Unauthorized access prevention 