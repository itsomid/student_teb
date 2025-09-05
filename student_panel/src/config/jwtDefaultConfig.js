/**
 * Configuration object for JWT authentication, including storage key names.
 *
 * @constant {Object} jwtConfig
 * @type {Object}
 * @property {string} TOKEN_TYPE - Token type to be used in the Authorization header.
 * @property {string} STORAGE_TOKEN_KEY_NAME - Key name for storing the JWT token in storage.
 * @property {string} STORAGE_REFRESH_TOKEN_KEY_NAME - Key name for storing the refresh token in storage.
 */
export default {

  // This will be prefixed in authorization header with token
  // e.g. Authorization: Bearer <token>
  TOKEN_TYPE: 'Bearer',

  // Value of this property will be used as key to store JWT token in storage
  STORAGE_TOKEN_KEY_NAME: 'accessToken',

  // Value of this property will be used as the key to store the refresh token in storage
  STORAGE_REFRESH_TOKEN_KEY_NAME: 'refreshToken',
}
