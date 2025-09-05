import JwtService from "@/services/Jwt.service";

/**
 * Factory function for creating a JWT service instance.
 *
 * @function
 * @name Jwt
 * @param {Object} jwtOverrideConfig - Override configuration for JWT.
 * @returns {Object} An object containing a JWT service instance.
 */
function Jwt(jwtOverrideConfig) {
    const jwt = new JwtService(jwtOverrideConfig)

    return {
        jwt,
    }
}

/**
 * JWT service instance created with the default Axios instance and configuration.
 *
 * @type {Object}
 */
const { jwt } = Jwt({});
export default jwt
