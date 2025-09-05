#  Composables
In the context of Vue applications, a "composable" is a function that leverages Vue's Composition API to encapsulate and reuse stateful logic.

# Index
-  [JWT Service Factory](#jwt-service-factory)
- -    [Overview](#overview)
- -    [Installation](#installation)
- -    [Setup](#setup)
- -    [Structure](#project-structure)
- -    [Configuration Options](#configuration-options)
- -    [Usage](#usage)
- - -   [Storing Tokens after Authentication](#storing-tokens-after-authentication)
- - -   [Sending Tokens with HTTP Requests](#sending-tokens-with-http-requests)
- - -   [Automatically Refreshing Tokens](#automatically-refreshing-tokens)
- -    [Features](#features)
- -    [Methods](#methods)
- -    [Security](#security)
- 
# JWT Service Factory

This README document explains the implementation and usage of the `Jwt` service factory function. The purpose of this function is to streamline the instantiation of a `JwtService` for handling JWT (JSON Web Tokens) authentication within JavaScript applications.

## Overview

The factory function allows for the creation of a `JwtService` instance that can be used across the application to manage JWTs. It supports providing an override configuration to customize the settings for the JWT service.

## Installation

To implement this JWT service factory in your project, you need to ensure that the `JwtService` is correctly placed in your project's directory structure and is accessible for import.

## Setup

No additional setup is required except to ensure that the `JwtService` module is correctly imported into the script where the JWT service factory function is defined.

## Project Structure
________________________________
Ensure that the JwtService class is defined within your services directory and properly exported, as the factory function relies on this class for creating JWT service instances.

For example:
```javascript
/src
  /services
    Jwt.service.js
```

## Configuration Options
______________________
The `jwtOverrideConfig` parameter allows customization of the JWT settings used by `JwtService`. This override configuration can include:

-   Token storage keys 
- Token expiration times 
- Other library-specific settings

- Provide a default set of configurations that the `JwtService` can fall back on if no overrides are provided.
- 
## Usage
_______________________

You can use the pre-configured JWT service instance as follows:

```javascript
import jwt from "@/path/to/useJwt";

// Store JWTs
jwt.setToken('yourAccessTokenHere');
jwt.setRefreshToken('yourRefreshTokenHere');

// Retrieve JWTs
const accessToken = jwt.getToken();
const refreshToken = jwt.getRefreshToken();
```

Or you can create a new instance with a custom configuration:

```javascript
// Prepare a custom JWT configuration
const customJwtConfig = {...};
// Pass the custom configuration to the Jwt factory function
const { jwt: customJwt } = Jwt(customJwtConfig);

// Now you can use `customJwt` the same way as the pre-configurated instance
```
### Storing Tokens after Authentication

```javascript
// After a successful authentication
login(credentials).then(response => {
  const { accessToken, refreshToken } = response.data;
  jwt.setToken(accessToken);
  jwt.setRefreshToken(refreshToken);
});
```

### Sending Tokens with HTTP Requests
```javascript
// Configuring axios to send the token with each request
axios.interceptors.request.use(config => {
const token = jwt.getToken();
config.headers['Authorization'] = `Bearer ${token}`;
return config;
});
```

### Automatically Refreshing Tokens
// Auto-refresh token before it expires
```javascript
setInterval(() => {
    const refreshToken = jwt.getRefreshToken();
    refreshTokenFunction(refreshToken).then(updatedTokens => {
        jwt.setToken(updatedTokens.accessToken);
    });
    }, calculateTokenRefreshTime());
```

Remember to replace `login`, `refreshTokenFunction`, and `calculateTokenRefreshTime` with your actual functions.


### Extensions and Integrations

Discuss any available extensions, plugins, or integrations that the `JwtService` might have with other systems or frameworks.

```markdown
## Extensions and Integrations

The `JwtService` is designed to be flexible and can easily integrate with the following:

- Frameworks: Integrate seamlessly with frameworks like Express.js for Node.js or Django for Python.
- Frontend Libraries: Compatible with frontend libraries like React or Vue.js, allowing you to manage authentication tokens effectively on the client side.
- OAuth Providers: Easily adaptable to work with various OAuth providers such as Google, Facebook, or GitHub authentication services.

For more detailed guidance on integrating `JwtService` with these systems, refer to our documentation site.
```
## Features
___________________

-   Simplified JWT service creation. 
- Support for custom JWT configurations. 
- Methods for token retrieval and storage.

## Methods
____________________
The factory function returns an object that contains the `JwtService` instance, which in turn provides the following methods:

-   `getToken()`: Retrieve the stored JWT access token.
- `getRefreshToken()`: Retrieve the stored JWT refresh token.
- `setToken(value)`: Store the JWT access token.
- `setRefreshToken(value)`: Store the JWT refresh token.

Make sure these methods are implemented in the JwtService class that you import at the start.

## Security
______________________
It is important to handle JWTs securely. Avoid using local storage in production for sensitive tokens. Prefer secure storage options that mitigate the risk of XSS attacks and consider the use of HttpOnly cookies if appropriate for your environment.