// ------------ Server Configuration Loader ------------ //
const dotenv = require('dotenv');
dotenv.config();
module.exports = function () {
    return {
/*         webUi_username: process.env.WEBUI_USERNAME,
        webUi_password: process.env.WEBUI_PASSWORD, // encrypted with bcrypt
        webUi_readonly: process.env.WEBUI_READONLY,
        webUi_mode    : process.env.WEBUI_MODE,
        cors          : ["https://admin.socket.io"] */
    }
};

// ------------ How to set Configuration ------------ //
// Set the Server configuration on .env file