# Services
It contain all your business logic.

# Index
1.  [JWT Service for Authentication](#jwt-service-for-authentication)
  - -    [Introduction](#introduction)
  - -    [Features](#features)
  - -    [Installation](#installation)
  - -    [Configuration](#configuration)
  - -    [Methods](#methods)
2.  [Initializer service](#initializer-service)
    - [general package initializer service](#general-package-initializer-service)
    - [google analytic](#google-analytic)
    - [meta tags initializer service](#meta-tags-initializer-service)
    - [global properties initializer service](#global-properties-initializer-service)


# JWT Service for Authentication

## Introduction
This README accompanies the `JwtService` class, a comprehensive service module written in JavaScript for managing JSON Web Tokens (JWT) in a web application. It is responsible for handling JWT-related operations such as storing, retrieving, and refreshing tokens.

## Features
- Storing and retrieving JWT access and refresh tokens from local storage
- Managing a queue of subscribers for token refresh operations
- Overriding default JWT configuration

## Installation
Before using the `JwtService` class, ensure that its dependencies (e.g., [jwtDefaultConfig.js](../config/jwtDefaultConfig.js)) are correctly configured and accessible within your project structure.

```bash
# import the JwtService class
import JwtService from "@/path/to/JwtService";
```

## Configuration
_____________________
`JwtService` uses a default configuration that can be overridden during instantiation:

```javascript
import jwtDefaultConfig from '@/config/jwtDefaultConfig';

const jwtService = new JwtService({
  // Your override configurations here
});
```

You can then use the service throughout your application to manage JWTs:
```javascript
// Store tokens
jwtService.setToken(yourAccessToken);
jwtService.setRefreshToken(yourRefreshToken);

// Retrieve tokens
const accessToken = jwtService.getToken();
const refreshToken = jwtService.getRefreshToken();
```

## Methods
________________________

The JwtService class provides the following methods:

-   `getToken()`: Retrieves the access token from storage.
- `getRefreshToken()`: Retrieves the refresh token from storage.
- `setToken(value)`: Stores the access token into storage.
- `setRefreshToken(value)`: Stores the refresh token into storage.
- `addSubscriber(callback)`: Adds a subscriber that waits for a new access token.
## Initializer service

### general package initializer service

### google analytic

### meta tags initializer service

### global properties initializer service



## Sitemap Generator service